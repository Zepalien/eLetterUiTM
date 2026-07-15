<?php
declare(strict_types=1);

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Reports Controller
 *
 * Menguruskan sistem laporan rasmi bercetak dan tapisan bersyarat.
 */
class ReportsController extends AppController
{
    protected ?string $defaultTable = 'LetterRequests';

    /**
     * Index - Paparan Laporan Interaktif di Web Portal
     */
    public function index()
    {
        $letterRequestsTable = $this->getTableLocator()->get('LetterRequests');

        // Ambil input daripada borang penapis (Filter Form)
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');
        $selectedStatus = $this->request->getQuery('status');

        // Bina query asas
        $query = $letterRequestsTable->find();

        // Letakkan syarat WHERE sekiranya admin menggunakan penapis
        if (!empty($startDate)) {
            $query->where(['LetterRequests.created_at >=' => $startDate . ' 00:00:00']);
        }
        if (!empty($endDate)) {
            $query->where(['LetterRequests.created_at <=' => $endDate . ' 23:59:59']);
        }
        if (!empty($selectedStatus)) {
            $query->where(['LetterRequests.status' => $selectedStatus]);
        }

        // Klon query utama untuk pengiraan kad info dan carta secara dinamik mengikut tapisan
        $queryTotal = clone $query;
        $queryCourse = clone $query;
        $queryList = clone $query;

        // 1. Kira statistik ringkasan status permohonan
        $totalRequests = $queryTotal->count();
        $statusCounts = $queryTotal->select(['status', 'count' => 'COUNT(*)'])->group(['status'])->all()->combine('status', 'count')->toArray();
        
        $approvedCount = $statusCounts['Approved'] ?? 0;
        $pendingCount = $statusCounts['Pending'] ?? 0;
        $rejectedCount = $statusCounts['Rejected'] ?? 0;

        // 2. Tarik top 5 Kursus/Program paling banyak apply berdasarkan filter semasa
        $courseStats = $queryCourse->select(['program_name', 'count' => 'COUNT(*)'])
            ->group(['program_name'])
            ->order(['count' => 'DESC'])
            ->limit(5)
            ->toArray();

        // 3. Ambil senarai rekod terperinci permohonan surat untuk jadual laporan
        $reportRecords = $queryList->order(['LetterRequests.created_at' => 'DESC'])->toArray();

        // Hantar semua variable ke fail view (index.php)
        $this->set(compact(
            'totalRequests', 'approvedCount', 'pendingCount', 'rejectedCount', 
            'courseStats', 'reportRecords', 'startDate', 'endDate', 'selectedStatus'
        ));
    }

    /**
     * ExportPdf - Mengubah HTML menjadi fail muat turun PDF rasmi
     */
    public function exportPdf()
    {
        // Matikan layout template web biasa supaya tidak mengganggu struktur dokumen kertas
        $this->viewBuilder()->disableAutoLayout();
        
        // Guna logik penapis yang sama seperti index() untuk memastikan data yang dicetak adalah tepat
        $letterRequestsTable = $this->getTableLocator()->get('LetterRequests');
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');
        $selectedStatus = $this->request->getQuery('status');

        $query = $letterRequestsTable->find();

        if (!empty($startDate)) {
            $query->where(['LetterRequests.created_at >=' => $startDate . ' 00:00:00']);
        }
        if (!empty($endDate)) {
            $query->where(['LetterRequests.created_at <=' => $endDate . ' 23:59:59']);
        }
        if (!empty($selectedStatus)) {
            $query->where(['LetterRequests.status' => $selectedStatus]);
        }

        $queryTotal = clone $query;
        $queryList = clone $query;

        $totalRequests = $queryTotal->count();
        $statusCounts = $queryTotal->select(['status', 'count' => 'COUNT(*)'])->group(['status'])->all()->combine('status', 'count')->toArray();
        $approvedCount = $statusCounts['Approved'] ?? 0;
        $pendingCount = $statusCounts['Pending'] ?? 0;
        $rejectedCount = $statusCounts['Rejected'] ?? 0;

        $reportRecords = $queryList->order(['LetterRequests.created_at' => 'DESC'])->toArray();

        $this->set(compact('totalRequests', 'approvedCount', 'pendingCount', 'rejectedCount', 'reportRecords', 'startDate', 'endDate', 'selectedStatus'));

        // RENDER KEPADA PDF MENGGUNAKAN DOMPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Membenarkan gambar logo universiti dimuatkan
        $dompdf = new Dompdf($options);
        
        // Panggil fail templates/Reports/pdf/export_pdf.php untuk dijadikan string HTML
       $this->viewBuilder()->setTemplatePath('Reports/pdf');
        $this->viewBuilder()->setTemplate('export_pdf');

        $html = $this->viewBuilder()->build()->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Hantar fail ke browser untuk paparan/muat turun automatik
        return $this->response->withType('pdf')->withStringBody($dompdf->output());
    }
    public function exportCsv()
    {
        $this->viewBuilder()->disableAutoLayout();
        
        $letterRequestsTable = $this->getTableLocator()->get('LetterRequests');
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');
        $selectedStatus = $this->request->getQuery('status');

        $query = $letterRequestsTable->find();

        // Guna logik tapisan parameter yang sama demi ketepatan data
        if (!empty($startDate)) {
            $query->where(['LetterRequests.created_at >=' => $startDate . ' 00:00:00']);
        }
        if (!empty($endDate)) {
            $query->where(['LetterRequests.created_at <=' => $endDate . ' 23:59:59']);
        }
        if (!empty($selectedStatus)) {
            $query->where(['LetterRequests.status' => $selectedStatus]);
        }

        $reportRecords = $query->order(['LetterRequests.created_at' => 'DESC'])->toArray();

        // Tetapkan tetapan respon kepada fail muat turun CSV
        $response = $this->response;
        $response = $response->withType('csv')
            ->withHeader('Content-Disposition', 'attachment; filename="Laporan_Permohonan_Surat_' . date('Ymd_His') . '.csv"')
            ->withHeader('Pragma', 'no-cache')
            ->withHeader('Expires', '0');

        // Buka stream untuk menulis data CSV
        $stream = fopen('php://memory', 'r+');
        
        // Letakkan BOM (Byte Order Mark) supaya MS Excel boleh baca tulisan/simbol dengan betul
        fprintf($stream, chr(0xEF).chr(0xBB).chr(0xBF));

        // Letakkan tajuk kolum (Header Row)
        fputcsv($stream, ['Tarikh Mohon', 'No. Matrik', 'Program', 'Organisasi', 'Tujuan Surat', 'Status']);

        // Masukkan baris data daripada pangkalan data
        foreach ($reportRecords as $record) {
            fputcsv($stream, [
                $record->created_at ? $record->created_at->format('d/m/Y h:i A') : '—',
                $record->matrix_id ?? '—',
                $record->program_name ?? '—',
                $record->organization_name ?? '—',
                $record->purpose ?? '—',
                $record->status ?? 'Pending'
            ]);
        }

        rewind($stream);
        $csvContent = stream_get_contents($stream);
        fclose($stream);

        return $response->withStringBody($csvContent);
    }
}