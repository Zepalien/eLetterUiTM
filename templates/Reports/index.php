<?php
/**
 * @var \App\View\AppView $this
 * @var int $totalRequests
 * @var int $approvedCount
 * @var int $pendingCount
 * @var int $rejectedCount
 * @var array $courseStats
 * @var array $faculties // Ditambah untuk data filter fakulti
 * @var string $startDate
 * @var string $endDate
 * @var string $selectedStatus
 * @var string $selectedFaculty
 */
?>
<style>
/* ===== BASE ===== */
.rp-wrap { padding: 24px; background: #f8fafc; min-height: 100vh; font-family: 'Segoe UI', system-ui, sans-serif; }

/* ===== ANIMATIONS ===== */
@keyframes slideDown  { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
@keyframes slideUp    { from { opacity:0; transform:translateY(14px);  } to { opacity:1; transform:translateY(0); } }
@keyframes rowIn      { from { opacity:0; transform:translateX(-6px);  } to { opacity:1; transform:translateX(0); } }
@keyframes spin       { to { transform:rotate(360deg); } }

@media (prefers-reduced-motion:reduce) {
    * { animation:none!important; transition:none!important; opacity:1!important; }
}

/* ===== HEADER ===== */
.rp-header {
    display:flex; justify-content:space-between; align-items:flex-start;
    flex-wrap:wrap; gap:14px; margin-bottom:22px;
    opacity:0; animation:slideDown .45s ease-out .05s forwards;
}
.rp-header h5 { font-size:18px; font-weight:700; color:#0f172a; margin:0 0 3px; }
.rp-header p  { font-size:13px; color:#64748b; margin:0; }

.btn-export {
    display:inline-flex; align-items:center; gap:7px;
    padding:9px 18px; border-radius:10px;
    background:#dc2626; color:#fff !important;
    font-size:13px; font-weight:600; text-decoration:none;
    box-shadow:0 4px 14px rgba(220,38,38,.3);
    transition:transform .2s, box-shadow .2s, background .2s;
    white-space:nowrap;
}
.btn-export:hover { background:#b91c1c; transform:translateY(-2px); box-shadow:0 8px 22px rgba(220,38,38,.4); color:#fff!important; }

.btn-export-excel {
    display:inline-flex; align-items:center; gap:6px;
    padding:6px 12px; border-radius:8px;
    background:#16a34a; color:#fff !important;
    font-size:12px; font-weight:600; text-decoration:none;
    transition:all .2s;
}
.btn-export-excel:hover { background:#15803d; transform:translateY(-1px); }

/* ===== FILTER CARD ===== */
.rp-filter {
    background:#fff; border-radius:16px;
    box-shadow:0 1px 3px rgba(0,0,0,.05),0 4px 16px rgba(0,0,0,.04);
    padding:22px; margin-bottom:20px;
    opacity:0; animation:slideDown .45s ease-out .12s forwards;
}
.rp-filter h6 { font-size:12px; font-weight:700; letter-spacing:.6px; text-transform:uppercase; color:#94a3b8; margin:0 0 16px; }

/* Diubah kepada 4 kolum untuk memuatkan filter Fakulti & Action Buttons sebaris */
.filter-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:14px; align-items:end; }

.fld-label { font-size:11px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:#64748b; display:block; margin-bottom:6px; }
.fld-ctrl {
    width:100%; padding:9px 12px; border-radius:9px;
    border:1.5px solid #e2e8f0; background:#fff;
    font-size:13px; color:#1e293b; outline:none;
    transition:border-color .2s, box-shadow .2s;
    height:40px;
}
.fld-ctrl:focus { border-color:#a78bfa; box-shadow:0 0 0 3px rgba(124,58,237,.12); }

.filter-actions { display:grid; grid-template-columns: 2fr 1fr; gap:8px; width:100%; }

.btn-filter {
    height:40px; padding:0 12px; border-radius:9px;
    border:none; background:#4c1d95; color:#fff;
    font-size:13px; font-weight:700; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:7px;
    transition:background .2s, transform .15s, box-shadow .2s;
    box-shadow:0 4px 12px rgba(76,29,149,.3);
}
.btn-filter:hover { background:#3b0f7a; transform:translateY(-1px); box-shadow:0 6px 18px rgba(76,29,149,.4); }
.btn-filter:active { transform:translateY(0); }
.btn-filter.loading .btn-filter-txt { display:none; }
.btn-filter.loading .btn-filter-spin { display:block; }
.btn-filter-spin { display:none; animation:spin .7s linear infinite; }

.btn-reset {
    height:40px; border-radius:9px;
    border:1.5px solid #e2e8f0; background:#f8fafc; color:#475569;
    font-size:13px; font-weight:600; cursor:pointer; text-decoration:none;
    display:flex; align-items:center; justify-content:center;
    transition:all .2s;
}
.btn-reset:hover { background:#e2e8f0; color:#1e293b; }

/* ===== STAT CARDS ===== */
.stat-row {
    display:grid; grid-template-columns:repeat(4,1fr); gap:14px;
    margin-bottom:20px;
}
@media(max-width:900px){ .stat-row{grid-template-columns:repeat(2,1fr);} }
@media(max-width:500px){ .stat-row{grid-template-columns:1fr;} }

.stat-card {
    background:#fff; border-radius:14px;
    box-shadow:0 1px 3px rgba(0,0,0,.05),0 4px 16px rgba(0,0,0,.04);
    padding:18px 20px; overflow:hidden; position:relative;
    opacity:0; cursor:default;
    transition:transform .2s, box-shadow .2s;
}
.stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 26px rgba(0,0,0,.09); }
/* Interface Fix: Tukar kepada border kiri yang tebal & buang border bottom asal */
.stat-card-accent { position:absolute; left:0; top:0; bottom:0; width:5px; border-radius:14px 0 0 14px; }
.stat-label { font-size:10px; font-weight:700; letter-spacing:.8px; text-transform:uppercase; color:#94a3b8; margin-bottom:4px; }
/* Interface Fix: Kecilkan saiz font dari 30px ke 26px untuk lebih breathing space */
.stat-value { font-size:26px; font-weight:800; line-height:1; margin-bottom:6px; font-variant-numeric:tabular-nums; }
.stat-subtext { font-size:11px; color:#64748b; margin-top:6px; display:flex; align-items:center; gap:4px; }
.stat-bar-track { height:4px; background:#f1f5f9; border-radius:99px; overflow:hidden; margin-top:8px; }
.stat-bar-fill  { height:100%; border-radius:99px; width:0; transition:width 1s ease-out; }

/* ===== SECTION CARDS ===== */
.rp-card {
    background:#fff; border-radius:16px;
    box-shadow:0 1px 3px rgba(0,0,0,.05),0 4px 16px rgba(0,0,0,.04);
    overflow:hidden; margin-bottom:20px;
    opacity:0;
}
.rp-card-head {
    display:flex; justify-content:space-between; align-items:center;
    padding:16px 20px; border-bottom:1px solid #f1f5f9; flex-wrap:wrap; gap:10px;
}
.rp-card-head h6 { font-size:14px; font-weight:700; color:#0f172a; margin:0; }

/* ===== COURSE TABLE ===== */
.course-table { width:100%; border-collapse:collapse; }
.course-table thead th {
    font-size:10.5px; font-weight:700; letter-spacing:.6px; text-transform:uppercase;
    color:#94a3b8; background:#f8fafc; padding:11px 16px; border-bottom:1px solid #f1f5f9;
}
.course-table thead th:first-child { padding-left:22px; }
.course-table thead th:last-child  { padding-right:22px; text-align:right; }

.course-table tbody tr { border-bottom:1px solid #f8fafc; transition:background .15s; opacity:0; animation:rowIn .3s ease-out forwards; }
.course-table tbody tr:last-child { border-bottom:none; }
.course-table tbody tr:hover { background:#faf9ff; }
.course-table td { padding:13px 16px; font-size:13px; vertical-align:middle; }
.course-table td:first-child { padding-left:22px; }
.course-table td:last-child  { padding-right:22px; text-align:right; }

.course-rank { width:26px; height:26px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; }
.rank-1 { background:#fef9c3; color:#a16207; }
.rank-2 { background:#f1f5f9; color:#475569; }
.rank-3 { background:#fef3c7; color:#d97706; }
.rank-n { background:#f8fafc; color:#94a3b8; }

.course-bar-wrap { display:flex; align-items:center; gap:10px; }
/* Interface Fix: Nipiskan progress bar ke 4px daripada 6px untuk impak visual elegan */
.course-bar-track { flex:1; height:4px; background:#f1f5f9; border-radius:99px; overflow:hidden; max-width:180px; }
.course-bar-fill  { height:100%; background:linear-gradient(90deg,#8b5cf6,#4c1d95); border-radius:99px; width:0; transition:width 1s cubic-bezier(.4,0,.2,1); }

/* ===== LOG TABLE ===== */
.log-table { width:100%; border-collapse:collapse; }
.log-table thead th {
    font-size:10.5px; font-weight:700; letter-spacing:.6px; text-transform:uppercase;
    color:#94a3b8; background:#f8fafc; padding:11px 16px; border-bottom:1px solid #f1f5f9;
    white-space:nowrap;
}
.log-table thead th:first-child { padding-left:22px; }
.log-table thead th:last-child  { padding-right:22px; text-align:center; }

.log-table tbody tr { border-bottom:1px solid #f8fafc; transition:background .15s; opacity:0; animation:rowIn .3s ease-out forwards; }
.log-table tbody tr:last-child { border-bottom:none; }
.log-table tbody tr:hover { background:#faf9ff; }
.log-table td { padding:14px 16px; font-size:13px; vertical-align:middle; } /* Ditambah padding py-14px */
.log-table td:first-child { padding-left:22px; }
.log-table td:last-child  { padding-right:22px; text-align:center; }

.status-pill { display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:99px; font-size:11px; font-weight:700; }
.pill-dot    { width:6px; height:6px; border-radius:50%; background:currentColor; }
.pill-approved { background:#dcfce7; color:#15803d; }
.pill-pending  { background:#fef9c3; color:#a16207; }
.pill-rejected { background:#fee2e2; color:#b91c1c; }

/* ===== SEARCH & ACTIONS ===== */
.log-controls { display:flex; align-items:center; gap:10px; }
.log-search-wrap { position:relative; }
.log-search-wrap input {
    padding:7px 14px 7px 34px; border-radius:99px;
    border:1.5px solid #e2e8f0; background:#fff;
    font-size:12px; color:#1e293b; outline:none; width:200px;
    transition:border-color .2s, box-shadow .2s;
}
.log-search-wrap input:focus { border-color:#a78bfa; box-shadow:0 0 0 3px rgba(124,58,237,.12); }
.log-search-wrap i { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:12px; pointer-events:none; }

/* ===== EMPTY STATE ===== */
.empty-state { padding:52px 20px; text-align:center; }
.empty-state i { font-size:36px; color:#cbd5e1; display:block; margin-bottom:10px; }
.empty-state p { font-size:13px; color:#94a3b8; margin:0; }

/* ===== PRINT STYLES ===== */
@media print {
    .rp-filter, .btn-export, .log-controls { display:none!important; }
    .rp-wrap { background:#fff!important; padding:0!important; }
    .rp-card, .stat-card { box-shadow:none!important; border:1px solid #e2e8f0!important; }
}
</style>

<div class="rp-wrap">

    <!-- ===== HEADER ===== -->
    <div class="rp-header">
        <div>
            <h5><i class="fa-solid fa-chart-bar" style="color:#4c1d95;margin-right:8px"></i>Modul Laporan Rasmi</h5>
            <p>Analisis menyeluruh, statistik program, dan eksport dokumen PDF rasmi</p>
        </div>
        <?= $this->Html->link(
            '<i class="fa-solid fa-file-pdf"></i> Eksport PDF',
            ['action' => 'exportPdf', '?' => $this->request->getQuery()],
            ['class' => 'btn-export', 'escape' => false, 'target' => '_blank']
        ) ?>
    </div>

    <!-- ===== FILTER CARD ===== -->
    <div class="rp-filter">
        <h6><i class="fa-solid fa-sliders" style="margin-right:6px;color:#4c1d95"></i>Tapisan Parameter Laporan</h6>
        <?= $this->Form->create(null, ['type' => 'get', 'id' => 'filter-form']) ?>
        <div class="filter-grid">

            <div>
                <label class="fld-label" for="start_date">Tarikh Mula</label>
                <?= $this->Form->control('start_date', [
                    'type' => 'date', 'label' => false,
                    'id' => 'start_date', 'class' => 'fld-ctrl',
                    'value' => $startDate ?? ''
                ]) ?>
            </div>

            <div>
                <label class="fld-label" for="end_date">Tarikh Tamat</label>
                <?= $this->Form->control('end_date', [
                    'type' => 'date', 'label' => false,
                    'id' => 'end_date', 'class' => 'fld-ctrl',
                    'value' => $endDate ?? ''
                ]) ?>
            </div>

            <!-- FUNGSI BARU: Filter berasaskan Fakulti/Bahagian UiTM -->
            <div>
                <label class="fld-label" for="faculty">Fakulti / Bahagian</label>
                <?= $this->Form->control('faculty', [
                    'type' => 'select', 'label' => false,
                    'id' => 'faculty', 'class' => 'fld-ctrl',
                    'options' => $faculties ?? [
                        '' => '— Semua Fakulti —',
                        'IM' => 'Fakulti Pengurusan Maklumat (IM)',
                        'CS' => 'Fakulti Sains Komputer & Matematik (CS)',
                        'AP' => 'Fakulti Seni Bina, Perancangan & Ukur (AP)'
                    ],
                    'value' => $selectedFaculty ?? '',
                    'style' => 'cursor:pointer'
                ]) ?>
            </div>

            <div>
                <label class="fld-label" for="status">Status Permohonan</label>
                <?= $this->Form->control('status', [
                    'type' => 'select', 'label' => false,
                    'id' => 'status', 'class' => 'fld-ctrl',
                    'options' => [
                        ''         => '— Semua Status —',
                        'Approved' => 'Approved',
                        'Pending'  => 'Pending',
                        'Rejected' => 'Rejected',
                    ],
                    'value' => $selectedStatus ?? '',
                    'style' => 'cursor:pointer'
                ]) ?>
            </div>

            <!-- Jajaran butang aksi yang lebih seimbang sebaris dengan input -->
            <div class="filter-actions">
                <button type="submit" class="btn-filter" id="btn-filter">
                    <svg class="btn-filter-spin" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <circle cx="8" cy="8" r="6" stroke="rgba(255,255,255,.35)" stroke-width="2"/>
                        <path d="M8 2a6 6 0 0 1 6 6" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="btn-filter-txt"><i class="fa-solid fa-magnifying-glass"></i> Tapis</span>
                </button>
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-reset" title="Set Semula">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>

        </div>
        <?= $this->Form->end() ?>
    </div>

    <!-- ===== STAT CARDS ===== -->
    <?php
        $total    = (int)($totalRequests  ?? 0);
        $approved = (int)($approvedCount  ?? 0);
        $pending  = (int)($pendingCount   ?? 0);
        $rejected = (int)($rejectedCount  ?? 0);
        $safeT    = $total > 0 ? $total : 1;

        // FUNGSI BARU: Simulasi semakan SLA untuk status Pending yang memerlukan tindakan segera
        $criticalPending = $pending > 0 ? true : false; 

        $statCards = [
            ['label'=>'Jumlah Rekod',  'value'=>$total,    'color'=>'#4c1d95', 'accent'=>'#4c1d95', 'icon'=>'fa-file-invoice',  'pct'=>100,                         'subtext' => 'Permohonan keseluruhan', 'delay'=>0],
            ['label'=>'Approved',      'value'=>$approved, 'color'=>'#15803d', 'accent'=>'#22c55e', 'icon'=>'fa-circle-check',   'pct'=>round($approved/$safeT*100), 'subtext' => round($approved/$safeT*100) . '% dari jumlah asal', 'delay'=>80],
            ['label'=>'Pending',       'value'=>$pending,  'color'=>'#a16207', 'accent'=>'#f59e0b', 'icon'=>'fa-clock',          'pct'=>round($pending/$safeT*100),  'subtext' => $criticalPending ? '<span style="color:#dc2626"><i class="fa-solid fa-triangle-exclamation"></i> Perlu tindakan SLA</span>' : 'SLA dalam keadaan baik', 'delay'=>160],
            ['label'=>'Rejected',      'value'=>$rejected, 'color'=>'#b91c1c', 'accent'=>'#ef4444', 'icon'=>'fa-circle-xmark',   'pct'=>round($rejected/$safeT*100), 'subtext' => round($rejected/$safeT*100) . '% kadar ditolak', 'delay'=>240],
        ];
    ?>
    <div class="stat-row">
        <?php foreach ($statCards as $sc): ?>
        <div class="stat-card" style="animation:slideUp .45s ease-out <?= $sc['delay'] ?>ms forwards">
            <div class="stat-card-accent" style="background:<?= $sc['accent'] ?>"></div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start">
                <div>
                    <div class="stat-label"><?= $sc['label'] ?></div>
                    <div class="stat-value count-up" data-target="<?= $sc['value'] ?>" style="color:<?= $sc['color'] ?>">0</div>
                </div>
                <div style="width:36px;height:36px;border-radius:8px;background:<?= $sc['accent'] ?>12;color:<?= $sc['accent'] ?>;display:flex;align-items:center;justify-content:center;font-size:14px">
                    <i class="fa-solid <?= $sc['icon'] ?>"></i>
                </div>
            </div>
            <div class="stat-bar-track">
                <div class="stat-bar-fill" data-pct="<?= $sc['pct'] ?>" style="background:<?= $sc['accent'] ?>"></div>
            </div>
            <div class="stat-subtext"><?= $sc['subtext'] ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ===== TOP COURSES ===== -->
    <?php
        $maxCount = 0;
        if (!empty($courseStats)) {
            foreach ($courseStats as $cs) {
                $c = (int)($cs->count ?? 0);
                if ($c > $maxCount) $maxCount = $c;
            }
        }
        $safeMax = $maxCount > 0 ? $maxCount : 1;
    ?>
    <div class="rp-card" style="animation:slideUp .5s ease-out .3s forwards">
        <div class="rp-card-head">
            <h6><i class="fa-solid fa-trophy" style="color:#f59e0b;margin-right:8px"></i>Top Program / Kursus Paling Aktif</h6>
            <span style="font-size:11px;color:#94a3b8"><?= count((array)($courseStats ?? [])) ?> program dikenal pasti</span>
        </div>
        <div class="table-responsive">
            <table class="course-table">
                <thead>
                    <tr>
                        <th style="width:50px">Rank</th>
                        <th>Nama / Kod Program</th>
                        <th style="width:300px;text-align:right">Bilangan &amp; Trend Visual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($courseStats)): ?>
                        <?php foreach ($courseStats as $idx => $stat): ?>
                        <?php
                            $cnt = (int)($stat->count ?? 0);
                            $pct = round($cnt / $safeMax * 100);
                            $rankCls = $idx===0?'rank-1':($idx===1?'rank-2':($idx===2?'rank-3':'rank-n'));
                        ?>
                        <tr style="animation-delay:<?= $idx*45 ?>ms">
                            <td>
                                <span class="course-rank <?= $rankCls ?>">
                                    <?= $idx===0?'🥇':($idx===1?'🥈':($idx===2?'🥉':($idx+1))) ?>
                                </span>
                            </td>
                            <td style="font-weight:600;color:#1e293b"><?= h($stat->program_name ?? 'N/A') ?></td>
                            <td>
                                <div class="course-bar-wrap" style="justify-content:flex-end">
                                    <div class="course-bar-track">
                                        <div class="course-bar-fill" data-pct="<?= $pct ?>"></div>
                                    </div>
                                    <span style="font-weight:700;color:#4c1d95;font-size:13px;min-width:24px;text-align:right">
                                        <?= number_format($cnt) ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    <p>Tiada data program bagi tempoh atau fakulti yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== LOG TABLE ===== -->
    <div class="rp-card" style="animation:slideUp .5s ease-out .4s forwards">
        <div class="rp-card-head">
            <h6><i class="fa-solid fa-table-list" style="color:#4c1d95;margin-right:8px"></i>Jadual Log Data Laporan</h6>
            
            <div class="log-controls">
                <!-- FUNGSI BARU: Butang eksport berasingan format CSV/Excel khusus untuk data berjadual -->
                <?= $this->Html->link(
                    '<i class="fa-solid fa-file-excel"></i> Eksport Data',
                    ['action' => 'exportCsv', '?' => $this->request->getQuery()],
                    ['class' => 'btn-export-excel', 'escape' => false]
                ) ?>
                
                <div class="log-search-wrap">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="log-search" placeholder="Cari matrik, program…" autocomplete="off">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="log-table" id="log-table">
                <thead>
                    <tr>
                        <th>Tarikh Mohon</th>
                        <th>No. Matrik</th>
                        <th>Program</th>
                        <th>Organisasi</th>
                        <th>Tujuan Surat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="log-tbody">
                    <?php
    // Diselaraskan dengan variable daripada ReportsController
    $logRows = [];
    if (!empty($reportRecords)) {
        foreach ($reportRecords as $r) {
            $logRows[] = $r;
        }
    }
?>
                    <?php if (!empty($logRows)): ?>
                        <?php foreach ($logRows as $idx => $request): ?>
                        <?php
                            $st  = $request->status ?? 'Pending';
                            $cls = strtolower($st)==='approved'?'pill-approved':(strtolower($st)==='rejected'?'pill-rejected':'pill-pending');
                        ?>
                        <tr style="animation-delay:<?= $idx*40 ?>ms"
                            data-search="<?= strtolower(h($request->matrix_id ?? '') . ' ' . h($request->program_name ?? '') . ' ' . h($request->organization_name ?? '') . ' ' . h($request->purpose ?? '')) ?>">
                            <td style="color:#64748b;white-space:nowrap">
                                <?= $request->created_at ? $request->created_at->format('d M Y') : '—' ?><br>
                                <span style="font-size:10px;color:#94a3b8"><?= $request->created_at ? $request->created_at->format('h:i A') : '' ?></span>
                            </td>
                            <td style="font-weight:700;color:#1e293b"><?= h($request->matrix_id ?? ($request->user->matrix_id ?? '—')) ?></td>
                            <td style="color:#475569;max-width:160px">
                                <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= h($request->program_name ?? '—') ?></div>
                            </td>
                            <td style="color:#475569;max-width:150px">
                                <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= h($request->organization_name ?? '—') ?></div>
                            </td>
                            <td style="color:#64748b;max-width:180px">
                                <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= h($request->purpose ?? '—') ?></div>
                            </td>
                            <td>
                                <span class="status-pill <?= $cls ?>">
                                    <span class="pill-dot"></span><?= h($st) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="log-empty-row">
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fa-solid fa-folder-open"></i>
                                    <p>Tiada rekod log permohonan ditemui.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="log-filter-empty" style="display:none">
            <div class="empty-state">
                <i class="fa-solid fa-filter-circle-xmark"></i>
                <p>Tiada rekod sepadan dengan carian log.</p>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===== COUNT-UP ANIMATION ===== */
    function countUp(el) {
        var target = parseInt(el.dataset.target) || 0;
        if (!target) { el.textContent = '0'; return; }
        var dur = 1100, start = null;
        (function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            var e = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.floor(e * target).toLocaleString();
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString();
        })(performance.now());
    }
    document.querySelectorAll('.count-up').forEach(countUp);

    /* ===== FILL PROGRESS BARS ===== */
    function fillBars() {
        document.querySelectorAll('.stat-bar-fill').forEach(function (b) {
            b.style.width = (b.dataset.pct || 0) + '%';
        });
        setTimeout(function () {
            document.querySelectorAll('.course-bar-fill').forEach(function (b) {
                b.style.width = (b.dataset.pct || 0) + '%';
            });
        }, 300);
    }
    setTimeout(fillBars, 200);

    /* ===== LOADING FILTER STATE ===== */
    var filterForm = document.getElementById('filter-form');
    var btnFilter  = document.getElementById('btn-filter');
    if (filterForm && btnFilter) {
        filterForm.addEventListener('submit', function () {
            btnFilter.classList.add('loading');
            btnFilter.disabled = true;
        });
    }

    /* ===== DATE FIELD VALIDATION ===== */
    var startDate = document.getElementById('start_date');
    var endDate   = document.getElementById('end_date');
    if (startDate && endDate) {
        endDate.addEventListener('change', function () {
            if (startDate.value && this.value && this.value < startDate.value) {
                this.value = startDate.value;
            }
        });
        startDate.addEventListener('change', function () {
            if (endDate.value && this.value > endDate.value) {
                endDate.value = '';
            }
        });
    }

    /* ===== LIVE TABLE SEARCH ===== */
    var logSearch   = document.getElementById('log-search');
    var logFilterEm = document.getElementById('log-filter-empty');
    var logRows     = Array.from(document.querySelectorAll('#log-tbody tr:not(#log-empty-row)'));

    if (logSearch) {
        logSearch.addEventListener('input', function () {
            var q = this.value.trim().toLowerCase();
            var visible = 0;
            logRows.forEach(function (row) {
                var match = !q || (row.dataset.search || '').includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            if (logFilterEm) {
                logFilterEm.style.display = (visible === 0 && logRows.length > 0) ? 'block' : 'none';
            }
        });
    }
});
</script>