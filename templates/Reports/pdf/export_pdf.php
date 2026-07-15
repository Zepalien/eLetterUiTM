<?php
/**
 * templates/Reports/pdf/export_pdf.php
 * Fail reka bentuk khusus dokumen bertulis PDF (A4 Kertas Cetakan) - Edisi Analitik Data
 */

// LOGIK ANALITIK (AGREGAT DATA)
$total = count($reportRecords);
$approved = 0;
$pending = 0;
$rejected = 0;

foreach ($reportRecords as $record) {
    if ($record->status === 'Approved') $approved++;
    if ($record->status === 'Pending') $pending++;
    if ($record->status === 'Rejected') $rejected++;
}

// Kira Kadar Kelulusan (Approval Rate)
$approvalRate = $total > 0 ? ($approved / $total) * 100 : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; font-size: 11px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #4c1d95; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4c1d95; font-size: 18px; letter-spacing: 0.5px; text-transform: uppercase; }
        .header .subtitle { margin: 5px 0 0 0; font-size: 11px; font-weight: bold; color: #64748b; letter-spacing: 1px; }
        
        .meta-table { width: 100%; margin-bottom: 20px; font-size: 10px; color: #475569; background: #f8fafc; padding: 8px; border-radius: 4px; }
        
        /* Gaya Kad KPI Analitikal */
        .grid-cards { width: 100%; margin-bottom: 25px; border-collapse: collapse; }
        .grid-cards td { padding: 10px; border: 1px solid #e2e8f0; text-align: center; width: 25%; }
        .card-title { font-size: 9px; color: #64748b; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .card-value { font-size: 18px; font-weight: bold; margin-top: 4px; color: #0f172a; }
        
        .section-title { color: #4c1d95; margin: 20px 0 8px 0; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border-left: 3px solid #4c1d95; padding-left: 6px; }
        
        /* Jadual Data Gaya Korporat */
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        table.data-table th { background-color: #4c1d95; color: #ffffff; font-weight: bold; text-align: left; padding: 8px; border: 1px solid #4c1d95; font-size: 10px; text-transform: uppercase; }
        table.data-table td { padding: 8px; border: 1px solid #e2e8f0; font-size: 10px; color: #334155; }
        table.data-table tr:nth-child(even) { background-color: #f8fafc; }
        
        .badge { padding: 3px 6px; border-radius: 3px; font-size: 8px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .approved { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .pending { background-color: #fef9c3; color: #a16207; border: 1px solid #fef08a; }
        .rejected { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        
        .footer { position: fixed; bottom: -10px; width: 100%; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Universiti Teknologi MARA (UiTM)</h2>
        <div class="subtitle">PORTAL E-LETTER — LAPORAN EKSEKUTIF ANALISIS PERMOHONAN SURAT</div>
    </div>

    <table class="meta-table">
        <tr>
            <td style="width: 50%;"><strong>Tarikh Dokumen Dijana:</strong> <?= date('d M Y, h:i A') ?></td>
            <td style="text-align: right; width: 50%;">
                <strong>Skop Tapisan Semasa:</strong> 
                <?php 
                    $text = [];
                    if (!empty($startDate)) $text[] = "Dari: " . date('d/m/Y', strtotime($startDate));
                    if (!empty($endDate)) $text[] = "Hingga: " . date('d/m/Y', strtotime($endDate));
                    if (!empty($selectedStatus)) $text[] = "Status: " . $selectedStatus;
                    echo !empty($text) ? implode(' | ', $text) : 'Semua Rekod Induk';
                ?>
            </td>
        </tr>
    </table>

    <!-- RINGKASAN METRIK (KPI) GAYA DATA ANALYST -->
    <div class="section-title">Ringkasan Eksekutif & Prestasi Pokok</div>
    <table class="grid-cards">
        <tr>
            <td style="background-color: #f8fafc;">
                <div class="card-title">Sampel Rekod Ditapis</div>
                <div class="card-value"><?= number_format($total) ?></div>
            </td>
            <td style="background-color: #f0fdf4;">
                <div class="card-title" style="color: #166534;">Kadar Kelulusan</div>
                <div class="card-value" style="color: #166534;"><?= number_format($approvalRate, 1) ?>%</div>
            </td>
            <td style="background-color: #fefce8;">
                <div class="card-title" style="color: #854d0e;">Tunggakan (Pending)</div>
                <div class="card-value" style="color: #854d0e;"><?= number_format($pending) ?></div>
            </td>
            <td style="background-color: #fdf2f2;">
                <div class="card-title" style="color: #991b1b;">Ditolak (Rejected)</div>
                <div class="card-value" style="color: #991b1b;"><?= number_format($rejected) ?></div>
            </td>
        </tr>
    </table>

    <!-- TABULAR DATA LOG -->
    <div class="section-title">Lampiran Log Terperinci Permohonan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 12%;">Tarikh</th>
                <th style="width: 15%;">No. Matrik</th>
                <th style="width: 15%;">Kod Kursus</th>
                <th style="width: 28%;">Nama Organisasi Syarikat</th>
                <th style="width: 20%;">Tujuan Dokumen</th>
                <th style="width: 10%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reportRecords)): ?>
                <?php foreach ($reportRecords as $record): ?>
                    <tr>
                        <td><?= $record->created_at ? h($record->created_at->format('d/m/Y')) : 'N/A' ?></td>
                        <td style="font-weight: bold; color: #0f172a;"><?= h($record->matrix_id) ?></td>
                        <td><?= h($record->program_name ?? 'N/A') ?></td>
                        <td><?= h($record->organization_name) ?></td>
                        <td><?= h($record->purpose) ?></td>
                        <td style="text-align: center;">
                            <?php 
                            $class = 'pending';
                            if($record->status === 'Approved') $class = 'approved';
                            if($record->status === 'Rejected') $class = 'rejected';
                            ?>
                            <span class="badge <?= $class ?>"><?= h($record->status) ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #64748b;">Tiada padanan data analitik ditemui bagi parameter semasa.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        Bahagian Pengurusan Maklumat Laporan e-Letter UiTM — Dokumen Ditandatangani Secara Digital & Rahsia.
    </div>

</body>
</html>