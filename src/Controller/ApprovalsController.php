<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Approvals Controller
 * Menguruskan proses kelulusan permohonan surat pelajar
 */
class ApprovalsController extends AppController
{
    /**
     * Set secara spesifik model utama menggunakan LetterRequests
     */
    protected ?string $defaultTable = 'LetterRequests';

    /**
     * Index method - Paparan Senarai Permohonan Mengikut Tab Status
     */
    public function index()
    {
        // Ambil status daripada query string (default: Pending)
        $status = $this->request->getQuery('status', 'Pending');

        // Pastikan hanya status yang sah sahaja diproses
        if (!in_array($status, ['Pending', 'Approved', 'Rejected'])) {
            $status = 'Pending';
        }

        // Bina query dan dapatkan data permohonan
        $query = $this->LetterRequests->find()
            ->order(['LetterRequests.created_at' => 'DESC']);

        // Tapis mengikut tab status yang sedang aktif
        $query->where(['LetterRequests.status' => $status]);

        // Carian pantas menggunakan No. Matrik atau Nama Syarikat
        $search = $this->request->getQuery('search');
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'LetterRequests.matrix_id LIKE' => '%' . $search . '%',
                    'LetterRequests.organization_name LIKE' => '%' . $search . '%'
                ]
            ]);
        }

        $this->paginate = ['limit' => 10];
        $requests = $this->paginate($query);

        // Dapatkan jumlah pembilang (counter) untuk setiap status bagi paparan di Tab
        $counts = $this->LetterRequests->find()
            ->select(['status', 'count' => 'COUNT(*)'])
            ->group(['status'])
            ->all()
            ->combine('status', 'count')
            ->toArray();

        $pendingCount = $counts['Pending'] ?? 0;
        $approvedCount = $counts['Approved'] ?? 0;
        $rejectedCount = $counts['Rejected'] ?? 0;

        $this->set(compact('requests', 'status', 'search', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * ChangeStatus method - Mengubah status surat (Approve / Reject) secara pantas
     */
   public function changeStatus($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        
        $requestData = $this->LetterRequests->get($id);
        
        // Tangkap keputusan status dan ulasan daripada form modal
        $newStatus = $this->request->getData('status_decision');
        $adminRemarks = $this->request->getData('admin_remarks');
        
        if (in_array($newStatus, ['Approved', 'Rejected'])) {
            $requestData->status = $newStatus;
            $requestData->admin_remarks = $adminRemarks; // Menyimpan nota ulasan pentadbir
            
            // Set ID admin yang sedang login (Contoh default: 1)
            $requestData->admin_id = 1; 

            if ($this->LetterRequests->save($requestData)) {
                $this->Flash->success(__("Permohonan surat #{$id} telah berjaya dikemaskini kepada status: {$newStatus}."));
            } else {
                $this->Flash->error(__('Gagal mengemaskini status permohonan.'));
            }
        }

        // Kembali semula ke tab status asal semasa menghantar borang
        $currentStatus = $this->request->getData('current_status', 'Pending');
        return $this->redirect(['action' => 'index', '?' => ['status' => $currentStatus]]);
    }
}