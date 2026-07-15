<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LetterTemplate> $letterTemplates
 */
?>
<style>
/* ===== BASE ===== */
.lr-wrap { padding: 24px; background: #f8fafc; min-height: 100vh; font-family: 'Segoe UI', system-ui, sans-serif; }

/* ===== HEADER ===== */
.lr-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
    opacity: 0; animation: slideDown .45s ease-out .05s forwards;
}
.lr-header h5 { font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; }
.lr-header p  { font-size: 13px; color: #64748b; margin: 2px 0 0; }

.btn-new {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 10px;
    background: #4c1d95; color: #fff !important;
    font-size: 13px; font-weight: 600; text-decoration: none;
    border: none; cursor: pointer;
    transition: transform .2s, box-shadow .2s, background .2s;
    box-shadow: 0 4px 14px rgba(76,29,149,.35);
}
.btn-new:hover { background: #3b0f7a; transform: translateY(-2px); box-shadow: 0 8px 22px rgba(76,29,149,.45); color: #fff !important; }
.btn-new:active { transform: translateY(0); }

/* ===== SEARCH BAR ===== */
.filter-bar {
    display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
    margin-bottom: 16px;
    opacity: 0; animation: slideDown .45s ease-out .12s forwards;
}
.search-wrap { position: relative; margin-left: auto; }
.search-wrap input {
    padding: 7px 14px 7px 36px; border-radius: 99px;
    border: 1.5px solid #e2e8f0; background: #fff;
    font-size: 13px; color: #1e293b; outline: none;
    transition: border-color .2s, box-shadow .2s; width: 250px;
}
.search-wrap input:focus { border-color: #a78bfa; box-shadow: 0 0 0 3px rgba(124,58,237,.12); }
.search-wrap .s-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none; }

/* ===== TABLE CARD ===== */
.lr-card {
    background: #fff; border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04);
    overflow: hidden;
    opacity: 0; animation: slideUp .5s ease-out .2s forwards;
}

table.lr-table { width: 100%; border-collapse: collapse; }
.lr-table thead th {
    font-size: 10.5px; font-weight: 700; letter-spacing: .7px;
    text-transform: uppercase; color: #94a3b8;
    background: #f8fafc; padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9; white-space: nowrap;
}
.lr-table thead th:first-child { padding-left: 20px; }
.lr-table thead th:last-child  { padding-right: 20px; text-align: right; }

.lr-table tbody tr {
    border-bottom: 1px solid #f8fafc;
    transition: background .15s;
    opacity: 0;
    animation: rowIn .35s ease-out forwards;
}
.lr-table tbody tr:last-child { border-bottom: none; }
.lr-table tbody tr:hover { background: #faf9ff; }

.lr-table td { padding: 14px 14px; vertical-align: middle; font-size: 13px; color: #334155; }
.lr-table td:first-child { padding-left: 20px; }
.lr-table td:last-child  { padding-right: 20px; text-align: right; }

/* ===== SUBJECT FORMAT STYLING ===== */
.subject-badge {
    background: #f8fafc; border: 1px solid #e2e8f0; 
    border-radius: 6px; padding: 6px 10px; 
    font-family: monospace; font-size: 12px;
    color: #475569; display: inline-block;
    max-width: 100%; overflow: hidden; text-overflow: ellipsis;
}

/* ===== ACTION BUTTONS ===== */
.act-group { display: inline-flex; gap: 6px; justify-content: flex-end; }

.act-btn {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 11px; border-radius: 8px;
    font-size: 12px; font-weight: 600; text-decoration: none;
    border: 1.5px solid transparent; cursor: pointer;
    transition: all .18s; background: none; white-space: nowrap;
}
.act-view  { border-color: #e0e7ff; color: #4338ca; background: #eef2ff; }
.act-view:hover  { background: #4338ca; color: #fff; border-color: #4338ca; }
.act-edit  { border-color: #e0f2fe; color: #0369a1; background: #f0f9ff; }
.act-edit:hover  { background: #0369a1; color: #fff; border-color: #0369a1; }
.act-del   { border-color: #fee2e2; color: #b91c1c; background: #fef2f2; }
.act-del:hover   { background: #b91c1c; color: #fff; border-color: #b91c1c; }

/* ===== EMPTY STATE ===== */
.empty-state { padding: 60px 20px; text-align: center; color: #94a3b8; }
.empty-state i { font-size: 40px; margin-bottom: 12px; display: block; opacity: .4; }
.empty-state p { font-size: 14px; margin: 0; }

/* ===== PAGINATION ===== */
.lr-pagination {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 4px 4px;
    opacity: 0; animation: slideUp .45s ease-out .35s forwards;
}
.lr-pagination .pager-info { font-size: 12px; color: #94a3b8; }
.lr-pagination .pagination  { margin: 0; display: flex; gap: 4px; }
.lr-pagination .pagination li a,
.lr-pagination .pagination li span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 32px; padding: 0 8px;
    border-radius: 8px; font-size: 13px; font-weight: 500;
    border: 1.5px solid #e2e8f0; text-decoration: none; color: #475569;
    transition: all .15s;
}
.lr-pagination .pagination li.active span,
.lr-pagination .pagination li a:hover { background: #4c1d95; color: #fff; border-color: #4c1d95; }
.lr-pagination .pagination li.disabled span { opacity: .35; pointer-events: none; }

/* ===== ANIMATIONS ===== */
@keyframes slideDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }
@keyframes slideUp   { from { opacity:0; transform:translateY(12px);  } to { opacity:1; transform:translateY(0); } }
@keyframes rowIn     { from { opacity:0; transform:translateX(-6px);  } to { opacity:1; transform:translateX(0); } }

@media (prefers-reduced-motion: reduce) {
    .lr-header, .filter-bar, .lr-card, .lr-pagination, .lr-table tbody tr { opacity:1 !important; animation:none !important; }
}

/* ===== DELETE CONFIRM OVERLAY ===== */
.del-modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(15,23,42,.45); backdrop-filter: blur(3px);
    align-items: center; justify-content: center;
}
.del-modal-overlay.open { display: flex; animation: fadeOverlay .2s ease; }
@keyframes fadeOverlay { from { opacity:0; } to { opacity:1; } }

.del-modal {
    background: #fff; border-radius: 16px; padding: 32px 28px;
    width: 100%; max-width: 380px; text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,.25);
    animation: popIn .25s cubic-bezier(.34,1.56,.64,1);
}
@keyframes popIn { from { opacity:0; transform:scale(.9); } to { opacity:1; transform:scale(1); } }

.del-modal .del-icon { font-size: 36px; color: #ef4444; margin-bottom: 12px; }
.del-modal h6 { font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
.del-modal p  { font-size: 13px; color: #64748b; margin-bottom: 24px; }
.del-modal .modal-actions { display: flex; gap: 10px; }
.modal-btn-cancel { flex:1; padding:10px; border-radius:9px; border:1.5px solid #e2e8f0; background:#f8fafc; color:#475569; font-size:13px; font-weight:600; cursor:pointer; transition:all .15s; }
.modal-btn-cancel:hover { background:#e2e8f0; }
.modal-btn-confirm { flex:1; padding:10px; border-radius:9px; border:none; background:#ef4444; color:#fff; font-size:13px; font-weight:700; cursor:pointer; transition:all .15s; }
.modal-btn-confirm:hover { background:#dc2626; }
</style>

<div class="lr-wrap">

    <div class="lr-header">
        <div>
            <h5>Pengurusan Templat Surat Admin</h5>
            <p>Uruskan struktur format subjek dan kandungan teks auto-fix untuk permohonan pelajar</p>
        </div>
        <?= $this->Html->link(
            '<i class="fa-solid fa-plus"></i> Tambah Templat Baru',
            ['action' => 'add'],
            ['class' => 'btn-new', 'escape' => false]
        ) ?>
    </div>

    <div class="filter-bar">
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass s-icon"></i>
            <input type="text" id="search-input" placeholder="Cari nama atau subjek…" autocomplete="off">
        </div>
    </div>

    <div class="lr-card">
        <div class="table-responsive">
            <table class="lr-table" id="lr-table">
                <thead>
                    <tr>
                        <th style="width: 10%;"># ID</th>
                        <th style="width: 30%;">Nama / Jenis Templat</th>
                        <th style="width: 45%;">Format Baris Subjek (Subject)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="lr-tbody">
                    <?php if (!empty($letterTemplates) && count($letterTemplates) > 0): ?>
                        <?php foreach ($letterTemplates as $i => $letterTemplate): ?>
                        <tr data-search="<?= strtolower(h($letterTemplate->title ?? '') . ' ' . h($letterTemplate->subject_line ?? '')) ?>">

                            <td style="font-weight:700;color:#6366f1;font-size:12px">
                                #<?= $this->Number->format($letterTemplate->template_id) ?>
                            </td>

                            <td style="font-weight:700;color:#1e293b;font-size:13px">
                                <?= h($letterTemplate->title) ?>
                            </td>

                            <td>
                                <span class="subject-badge">
                                    <?= h($letterTemplate->subject_line ?: 'Tiada subjek ditetapkan') ?>
                                </span>
                            </td>

                            <td>
                                <div class="act-group">
                                    <?= $this->Html->link(
                                        '<i class="fa-solid fa-eye"></i> Lihat',
                                        ['action' => 'view', $letterTemplate->template_id],
                                        ['class' => 'act-btn act-view', 'escape' => false]
                                    ) ?>
                                    <?= $this->Html->link(
                                        '<i class="fa-solid fa-pen"></i> Edit',
                                        ['action' => 'edit', $letterTemplate->template_id],
                                        ['class' => 'act-btn act-edit', 'escape' => false]
                                    ) ?>
                                    <button class="act-btn act-del"
                                            onclick="openDelModal('<?= h($letterTemplate->template_id) ?>','<?= h(addslashes($letterTemplate->title ?? 'templat ini')) ?>','<?= $this->Url->build(['action' => 'delete', $letterTemplate->template_id]) ?>')">
                                        <i class="fa-solid fa-trash-can"></i> Padam
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="empty-row">
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fa-solid fa-folder-open"></i>
                                    <p>Tiada rekod templat surat dijumpai buat masa ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="filter-empty" style="display:none">
            <div class="empty-state">
                <i class="fa-solid fa-filter-circle-xmark"></i>
                <p>Tiada rekod sepadan dengan carian anda.</p>
            </div>
        </div>
    </div>

    <div class="lr-pagination">
        <span class="pager-info">
            <?= $this->Paginator->counter(__('Halaman {{page}} daripada {{pages}}, menunjukkan {{current}} rekod.')) ?>
        </span>
        <ul class="pagination">
            <?= $this->Paginator->prev('‹') ?>
            <?= $this->Paginator->numbers(['modulus' => 4]) ?>
            <?= $this->Paginator->next('›') ?>
        </ul>
    </div>

</div>

<div class="del-modal-overlay" id="del-overlay">
    <div class="del-modal">
        <div class="del-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h6>Padam Templat Surat?</h6>
        <p id="del-msg">Adakah anda pasti mahu memadam templat ini? Tindakan ini tidak boleh dibatalkan.</p>
        <div class="modal-actions">
            <button class="modal-btn-cancel" onclick="closeDelModal()">Batal</button>
            <form id="del-form" method="post" style="flex:1;display:flex">
                <input type="hidden" name="_method" value="POST">
                <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken') ?? '']) ?>
                <button type="submit" class="modal-btn-confirm" style="width:100%">
                    <i class="fa-solid fa-trash-can" style="margin-right:5px"></i>Ya, Padam
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===== ROW STAGGER ANIMATION ===== */
    var rows = document.querySelectorAll('#lr-tbody tr');
    rows.forEach(function (row, i) {
        row.style.animationDelay = (i * 45) + 'ms';
    });

    /* ===== INSTANT SEARCH FILTER ===== */
    var search = document.getElementById('search-input');
    var filterEmpty = document.getElementById('filter-empty');

    function applyFilters() {
        var q = search.value.trim().toLowerCase();
        var visible = 0;

        rows.forEach(function (row) {
            if (row.id === 'empty-row') return;
            var sr = row.dataset.search || '';
            var searchOk = !q || sr.includes(q);

            if (searchOk) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });

        filterEmpty.style.display = visible === 0 ? 'block' : 'none';
    }

    if (search) {
        search.addEventListener('input', applyFilters);
    }
});

/* ===== SAFE OVERLAY DELETE MODAL ===== */
function openDelModal(id, name, url) {
    document.getElementById('del-msg').textContent =
        'Adakah anda pasti mahu memadam templat "' + name + '"? Tindakan ini tidak boleh dibatalkan.';
    document.getElementById('del-form').action = url;
    document.getElementById('del-overlay').classList.add('open');
}

function closeDelModal() {
    document.getElementById('del-overlay').classList.remove('open');
}

/* Close on backdrop click */
document.getElementById('del-overlay').addEventListener('click', function (e) {
    if (e.target === this) closeDelModal();
});

/* Close on Escape key */
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDelModal();
});
</script>