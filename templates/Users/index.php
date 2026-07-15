<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $students
 * @var string|null $search
 */
?>
<style>
/* ===== ANIMATIONS & TRANSITIONS ===== */
.animate-down { opacity: 0; animation: slideDown 0.45s ease-out forwards; }
.animate-up { opacity: 0; animation: slideUp 0.5s ease-out 0.15s forwards; }

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes rowIn {
    from { opacity: 0; transform: translateX(-6px); }
    to { opacity: 1; transform: translateX(0); }
}

/* ===== BASE CARD & INTERACTIVE EFFECTS ===== */
.custom-card {
    background: #fff;
    border-radius: 16px !important;
    box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 4px 16px rgba(0,0,0,.04) !important;
    border: none !important;
    overflow: hidden;
}

.table-hover tbody tr {
    opacity: 0;
    animation: rowIn 0.35s ease-out forwards;
    transition: background-color 0.2s ease, transform 0.15s ease;
}
.table-hover tbody tr:hover {
    background-color: #faf9ff !important;
}

/* ===== BADGES & UTILITIES ===== */
.total-badge {
    background: #4c1d95;
    color: white;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 99px;
    box-shadow: 0 4px 12px rgba(76, 29, 149, 0.2);
}

.prog-badge {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    transition: all 0.2s;
    /* FIX UI: Elakkan text terkeluar atau badge pecah hodoh kalau text panjang */
    display: inline-block;
    max-width: 260px;
    white-space: normal;
    word-break: break-word;
    line-height: 1.4;
}
tr:hover .prog-badge {
    background: #e0e7ff;
    border-color: #c7d2fe;
    color: #4338ca;
}

/* ===== BUTTON CONTROLS ===== */
.btn-filter {
    background-color: #4c1d95;
    color: white !important;
    font-weight: 600;
    padding: 8px 20px;
    border-radius: 8px;
    border: none;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(76, 29, 149, 0.2);
}
.btn-filter:hover {
    background-color: #3b0f7a;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(76, 29, 149, 0.3);
}

.btn-clear {
    background: #f1f5f9;
    color: #475569;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.2s;
}
.btn-clear:hover {
    background: #e2e8f0;
    color: #1e293b;
}

/* ===== ACTION BUTTONS ===== */
.act-group { display: inline-flex; gap: 6px; }
.act-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    font-size: 13px;
    text-decoration: none;
    border: 1.5px solid transparent;
    background: none;
    cursor: pointer;
    transition: all 0.18s;
}
.act-view  { border-color: #e0e7ff; color: #4338ca; background: #eef2ff; }
.act-view:hover  { background: #4338ca; color: #fff; border-color: #4338ca; }
.act-edit  { border-color: #e0f2fe; color: #0369a1; background: #f0f9ff; }
.act-edit:hover  { background: #0369a1; color: #fff; border-color: #0369a1; }
.act-del   { border-color: #fee2e2; color: #b91c1c; background: #fef2f2; }
.act-del:hover   { background: #b91c1c; color: #fff; border-color: #b91c1c; }

/* ===== CUSTOM INPUT GROUP ===== */
.custom-input-group {
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.custom-input-group:focus-within {
    border-color: #a78bfa;
    box-shadow: 0 0 0 3px rgba(124,58,237,.12);
}
.custom-input-group .input-group-text { background: #fff; border: none; color: #94a3b8; }
.custom-input-group .form-control { border: none; font-size: 14px; }
.custom-input-group .form-control:focus { box-shadow: none; }

/* ===== CUSTOM PAGINATION ===== */
.pagination .page-item a, 
.pagination .page-item span {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 32px; height: 32px; padding: 0 10px;
    border-radius: 8px !important; font-size: 13px; font-weight: 500;
    border: 1.5px solid #e2e8f0; text-decoration: none; color: #475569;
    transition: all .15s; margin: 0 2px;
}
.pagination .page-item.active span,
.pagination .page-item a:hover { 
    background: #4c1d95 !important; color: #fff !important; border-color: #4c1d95 !important; 
}

/* ===== CUSTOM DELETE MODAL OVERLAY ===== */
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

<div class="container-fluid py-4" style="background-color: #f8fafc; min-height: 100vh; font-family: 'Segoe UI', system-ui, sans-serif;">
    
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 animate-down">
        <div>
            <h2 class="fw-bold text-dark m-0" style="font-size: 24px;">Students Record</h2>
            <p class="text-muted m-0" style="font-size: 13px;">Dashboard &gt; Students Record</p>
        </div>
        <div>
            <span class="total-badge">
                Total Registered Students: <?= $this->Paginator->param('count') ?>
            </span>
        </div>
    </div>

    <div class="card custom-card animate-up">
        <div class="card-body p-4">
            
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3 mb-4 align-items-center']) ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="input-group custom-input-group">
                    <span class="input-group-text border-0">🔎</span>
                    <?= $this->Form->control('search', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Search name, matrix ID or programme...',
                        'value' => $search
                    ]) ?>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-filter px-4">Filter</button>
                <?php if (!empty($search)): ?>
                    <?= $this->Html->link('Clear', ['action' => 'index'], ['class' => 'btn btn-clear ms-2 text-decoration-none']) ?>
                <?php endif; ?>
            </div>
            <?= $this->Form->end() ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-light text-secondary" style="font-size: 11px; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase;">
                        <tr>
                            <th scope="col" class="ps-3" style="width: 5%;"><?= $this->Paginator->sort('id', 'No') ?></th>
                            <th scope="col" style="width: 15%;"><?= $this->Paginator->sort('matrix_id', 'Matrix ID') ?></th>
                            <th scope="col" style="width: 25%;"><?= $this->Paginator->sort('full_name', 'Student Name') ?></th>
                            <th scope="col" style="width: 25%;"><?= $this->Paginator->sort('email', 'Email Address') ?></th>
                            <th scope="col" style="width: 15%;"><?= $this->Paginator->sort('faculty', 'Programme') ?></th>
                            <th scope="col" class="text-center pe-3" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13.5px; color: #334155;">
                        <?php if ($students->count() > 0): ?>
                            <?php foreach ($students as $index => $student): ?>
                                <tr class="student-row">
                                    <td class="ps-3 text-muted" style="font-weight: 600; font-size: 12px;">
                                        <?= $this->Number->format($student->id) ?>
                                    </td>
                                    <td><span class="fw-bold text-dark"><?= h($student->matrix_id) ?></span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 32px; height: 32px; background-color: #6366f1; font-size: 11.5px; font-weight: bold; box-shadow: 0 2px 6px rgba(99,102,241,0.2); flex-shrink: 0;">
                                                <?= !empty($student->full_name) ? strtoupper(substr($student->full_name, 0, 1)) : '?' ?>
                                            </div>
                                            <div class="fw-semibold text-dark"><?= h($student->full_name ?? 'N/A') ?></div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted"><?= h($student->email) ?></span></td>
                                    <td>
                                        <span class="prog-badge">
                                            <?= h($student->faculty ?? 'Not Set') ?>
                                        </span>
                                    </td>
                                    <td class="text-center pe-3">
                                        <div class="act-group">
                                            <?= $this->Html->link('view', ['action' => 'view', $student->id], ['class' => 'act-btn act-view', 'title' => 'View Profile']) ?>
                                            <?= $this->Html->link('edit', ['action' => 'edit', $student->id], ['class' => 'act-btn act-edit', 'title' => 'Edit Profile']) ?>
                                            <button type="button" class="act-btn act-del" title="Delete Student"
                                                    onclick="openDelModal('<?= h($student->id) ?>','<?= h(addslashes($student->full_name ?? 'pelajar ini')) ?>','<?= $this->Url->build(['action' => 'delete', $student->id]) ?>')">
                                                delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2" style="font-size: 32px; opacity: 0.5;">📂</div>
                                    No student records found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($this->Paginator->hasPage(2)): ?>
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <p class="text-muted m-0" style="font-size: 12.5px;">
                        <?= $this->Paginator->counter('Showing {{start}} to {{end}} of {{count}} students') ?>
                    </p>
                    <nav>
                        <ul class="pagination pagination-sm m-0">
                            <?= $this->Paginator->prev('‹ Prev', ['class' => 'page-item']) ?>
                            <?= $this->Paginator->numbers(['class' => 'page-item']) ?>
                            <?= $this->Paginator->next('Next ›', ['class' => 'page-item']) ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="del-modal-overlay" id="del-overlay">
    <div class="del-modal">
        <div class="del-icon">⚠️</div>
        <h6>Padam Rekod Pelajar?</h6>
        <p id="del-msg">Adakah anda pasti mahu memadam rekod pelajar ini? Tindakan ini tidak boleh dibatalkan.</p>
        <div class="modal-actions">
            <button type="button" class="modal-btn-cancel" onclick="closeDelModal()">Batal</button>
            <form id="del-form" method="post" style="flex:1; display:flex;">
                <input type="hidden" name="_method" value="POST">
                <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken') ?? '']) ?>
                <button type="submit" class="modal-btn-confirm" style="width:100%">Ya, Padam</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    /* Staggered Row Animation */
    var rows = document.querySelectorAll('.student-row');
    rows.forEach(function (row, i) {
        row.style.animationDelay = (i * 40) + 'ms';
    });
});

/* Modal Logic */
function openDelModal(id, name, url) {
    document.getElementById('del-msg').textContent = 'Adakah anda pasti mahu memadam rekod bagi "' + name + '"? Tindakan ini tidak boleh dibatalkan.';
    document.getElementById('del-form').action = url;
    document.getElementById('del-overlay').classList.add('open');
}

function closeDelModal() {
    document.getElementById('del-overlay').classList.remove('open');
}

/* Close on backdrop or escape click */
document.getElementById('del-overlay').addEventListener('click', function (e) {
    if (e.target === this) closeDelModal();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDelModal();
});
</script>