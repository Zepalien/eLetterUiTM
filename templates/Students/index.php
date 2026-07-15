<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $students
 * @var string|null $search
 * @var int $totalStudents
 */
?>
<style>
/* ===================================================
   DESIGN TOKENS
=================================================== */
:root {
    --brand:        #4c1d95;
    --brand-dark:   #3b1478;
    --brand-light:  #ede9fe;
    --brand-glow:   rgba(76,29,149,.14);

    --surface:      #ffffff;
    --bg:           #f4f5f7;
    --border:       #e4e6ea;
    --border-focus: #a78bfa;

    --text-primary:   #111827;
    --text-secondary: #6b7280;
    --text-muted:     #9ca3af;

    --radius-sm:  6px;
    --radius-md:  10px;
    --radius-lg:  14px;
    --radius-xl:  20px;

    --shadow-card: 0 1px 4px rgba(0,0,0,.06), 0 6px 20px rgba(0,0,0,.05);
    --shadow-btn:  0 1px 3px rgba(0,0,0,.1);

    --transition: 0.18s cubic-bezier(.4,0,.2,1);
    --transition-slow: 0.32s cubic-bezier(.4,0,.2,1);
}

/* ===================================================
   PAGE ENTRY ANIMATIONS
=================================================== */
@keyframes fadeDown {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes rowFade {
    from { opacity: 0; transform: translateX(-5px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(.94) translateY(8px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes overlayIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}

.anim-down { opacity: 0; animation: fadeDown var(--transition-slow) forwards; }
.anim-up   { opacity: 0; animation: fadeUp var(--transition-slow) 0.1s forwards; }

/* ===================================================
   LAYOUT
=================================================== */
.page-root {
    background: var(--bg);
    min-height: 100vh;
    padding: 28px 24px;
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
}

/* ===================================================
   PAGE HEADER
=================================================== */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}
.page-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 3px;
    letter-spacing: -.3px;
}
.page-breadcrumb {
    font-size: 12.5px;
    color: var(--text-muted);
    margin: 0;
}
.count-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--brand);
    color: #fff;
    font-size: 12.5px;
    font-weight: 600;
    padding: 7px 16px;
    border-radius: 99px;
    letter-spacing: .01em;
    box-shadow: 0 4px 14px var(--brand-glow);
    white-space: nowrap;
}
.count-badge svg { opacity: .75; }

/* ===================================================
   MAIN CARD
=================================================== */
.main-card {
    background: var(--surface);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-card);
    border: 1px solid var(--border);
    overflow: hidden;
}
.main-card-body { padding: 24px; }

/* ===================================================
   SEARCH / FILTER BAR
=================================================== */
.filter-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.search-wrap {
    position: relative;
    flex: 1;
    min-width: 220px;
    max-width: 380px;
}
.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
    width: 16px;
    height: 16px;
}
.search-input {
    width: 100%;
    padding: 9px 12px 9px 36px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 13.5px;
    color: var(--text-primary);
    background: var(--surface);
    outline: none;
    transition: border-color var(--transition), box-shadow var(--transition);
}
.search-input::placeholder { color: var(--text-muted); }
.search-input:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(167,139,250,.18);
}
.btn-primary-brand {
    padding: 9px 20px;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: background var(--transition), box-shadow var(--transition), transform var(--transition);
    box-shadow: 0 2px 8px var(--brand-glow);
    white-space: nowrap;
}
.btn-primary-brand:hover {
    background: var(--brand-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px var(--brand-glow);
}
.btn-primary-brand:active { transform: translateY(0); }

.btn-ghost {
    padding: 9px 16px;
    background: transparent;
    color: var(--text-secondary);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background var(--transition), border-color var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.btn-ghost:hover {
    background: var(--bg);
    border-color: #c4c9d4;
    color: var(--text-primary);
}

/* ===================================================
   DATA TABLE
=================================================== */
.data-table {
    width: 100%;
    border-collapse: collapse;
}
.data-table thead tr {
    background: var(--bg);
    border-bottom: 1px solid var(--border);
}
.data-table thead th {
    padding: 11px 14px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .7px;
    text-transform: uppercase;
    color: var(--text-secondary);
    white-space: nowrap;
}
.data-table thead th:first-child { border-radius: var(--radius-sm) 0 0 var(--radius-sm); padding-left: 16px; }
.data-table thead th:last-child  { border-radius: 0 var(--radius-sm) var(--radius-sm) 0; padding-right: 16px; }

/* Sortable headers */
.data-table thead th a {
    color: var(--text-secondary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: color var(--transition);
}
.data-table thead th a:hover { color: var(--brand); }
.data-table thead th a::after {
    content: '';
    display: inline-block;
    width: 8px;
    height: 12px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='12' viewBox='0 0 8 12'%3E%3Cpath d='M4 0L8 5H0L4 0z' fill='%23c9ced8'/%3E%3Cpath d='M4 12L0 7H8L4 12z' fill='%23c9ced8'/%3E%3C/svg%3E");
    opacity: 0.7;
    margin-left: 2px;
}
.data-table thead th a.asc::after {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='12' viewBox='0 0 8 12'%3E%3Cpath d='M4 0L8 5H0L4 0z' fill='%234c1d95'/%3E%3Cpath d='M4 12L0 7H8L4 12z' fill='%23c9ced8'/%3E%3C/svg%3E");
    opacity: 1;
}
.data-table thead th a.desc::after {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='12' viewBox='0 0 8 12'%3E%3Cpath d='M4 0L8 5H0L4 0z' fill='%23c9ced8'/%3E%3Cpath d='M4 12L0 7H8L4 12z' fill='%234c1d95'/%3E%3C/svg%3E");
    opacity: 1;
}

/* Rows */
.data-table tbody tr {
    border-bottom: 1px solid #f1f3f5;
    opacity: 0;
    animation: rowFade 0.3s ease-out forwards;
    transition: background var(--transition);
}
.data-table tbody tr:last-child { border-bottom: none; }
.data-table tbody tr:hover { background: #fafbfc; }

.data-table tbody td {
    padding: 14px 14px;
    font-size: 13.5px;
    color: var(--text-primary);
    vertical-align: middle;
}
.data-table tbody td:first-child { padding-left: 16px; }
.data-table tbody td:last-child  { padding-right: 16px; }

/* Avatar */
.avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(99,102,241,.25);
}
.cell-name { display: flex; align-items: center; gap: 10px; }
.name-text  { font-weight: 600; color: var(--text-primary); }

.cell-id    { font-weight: 700; font-size: 13px; color: var(--text-primary); font-variant-numeric: tabular-nums; }
.cell-email { color: var(--text-secondary); font-size: 13px; }
.cell-prog  { color: var(--text-secondary); font-size: 13px; max-width: 200px; }
.row-num    { color: var(--text-muted); font-size: 12.5px; font-weight: 600; font-variant-numeric: tabular-nums; }

/* ===================================================
   ACTION BUTTONS
=================================================== */
.act-group { display: inline-flex; gap: 6px; }
.act-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 13px;
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    letter-spacing: .01em;
}
.act-btn:hover { transform: translateY(-1px); }
.act-btn:active { transform: translateY(0); }

.act-view { background: #eef2ff; color: #4338ca; }
.act-view:hover { background: #e0e7ff; }

.act-edit { background: #fffbeb; color: #b45309; }
.act-edit:hover { background: #fef3c7; }

.act-del  { background: #fff1f2; color: #be123c; }
.act-del:hover  { background: #ffe4e6; }

/* ===================================================
   EMPTY STATE
=================================================== */
.empty-state {
    padding: 56px 24px;
    text-align: center;
    color: var(--text-muted);
}
.empty-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 14px;
    opacity: .35;
}
.empty-title { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 0 0 4px; }
.empty-sub   { font-size: 13px; margin: 0; }

/* ===================================================
   PAGINATION
=================================================== */
.pagination-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 18px;
    margin-top: 14px;
    border-top: 1px solid var(--border);
    flex-wrap: wrap;
    gap: 12px;
}
.pagination-info { font-size: 13px; color: var(--text-muted); font-weight: 500; }

/* Wrapper */
.custom-pagination-group {
    display: inline-flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 4px;
    align-items: center;
}

/* Every <li> → invisible, just a flex container */
.custom-pagination-group li {
    margin: 0;
    padding: 0;
    list-style: none;
}

/* All clickable page links and current-page spans */
.custom-pagination-group li a,
.custom-pagination-group li span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 10px;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    border: 1.5px solid var(--border);
    background: var(--surface);
    color: var(--text-secondary);
    transition: background var(--transition), color var(--transition), border-color var(--transition);
    white-space: nowrap;
    line-height: 1;
}

/* Hover on normal page links */
.custom-pagination-group li a:hover {
    background: var(--brand-light);
    color: var(--brand);
    border-color: #c4b5fd;
}

/* Active / current page */
.custom-pagination-group li.active span,
.custom-pagination-group li.active a {
    background: var(--brand);
    color: #fff;
    border-color: var(--brand);
    font-weight: 700;
    box-shadow: 0 2px 8px var(--brand-glow);
}

/* Disabled (prev on page 1, next on last page) */
.custom-pagination-group li.disabled span,
.custom-pagination-group li.disabled a {
    color: var(--text-muted);
    background: var(--bg);
    border-color: var(--border);
    cursor: not-allowed;
    pointer-events: none;
    opacity: 0.6;
}

/* Prev / Next — slightly wider pill */
.custom-pagination-group li:first-child a,
.custom-pagination-group li:first-child span,
.custom-pagination-group li:last-child a,
.custom-pagination-group li:last-child span {
    padding: 0 14px;
    font-weight: 600;
}

/* ===================================================
   DELETE MODAL
=================================================== */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(10,15,28,.5);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
}
.modal-overlay.open { display: flex; animation: overlayIn 0.2s ease; }

.del-modal {
    background: var(--surface);
    border-radius: var(--radius-xl);
    padding: 32px 28px 28px;
    width: 100%;
    max-width: 390px;
    text-align: center;
    box-shadow: 0 24px 64px rgba(0,0,0,.22);
    animation: modalIn 0.25s cubic-bezier(.34,1.56,.64,1) forwards;
}
.del-modal-icon-wrap {
    width: 52px;
    height: 52px;
    background: #fff1f2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}
.del-modal-icon-wrap svg { color: #e11d48; width: 24px; height: 24px; }
.del-modal h6 { font-size: 16px; font-weight: 700; color: var(--text-primary); margin: 0 0 8px; }
.del-modal p  { font-size: 13.5px; color: var(--text-secondary); margin: 0 0 26px; line-height: 1.55; }
.del-modal-actions { display: flex; gap: 10px; }
.btn-cancel-modal {
    flex: 1;
    padding: 11px;
    border-radius: var(--radius-md);
    border: 1.5px solid var(--border);
    background: var(--surface);
    color: var(--text-secondary);
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: background var(--transition), border-color var(--transition);
}
.btn-cancel-modal:hover { background: var(--bg); border-color: #c4c9d4; }
.btn-confirm-del {
    flex: 1;
    padding: 11px;
    border-radius: var(--radius-md);
    border: none;
    background: #e11d48;
    color: #fff;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition);
}
.btn-confirm-del:hover { background: #be123c; transform: translateY(-1px); }
.btn-confirm-del:active { transform: translateY(0); }

/* ===================================================
   RESPONSIVE
=================================================== */
@media (max-width: 768px) {
    .page-root { padding: 16px 14px; }
    .main-card-body { padding: 16px; }
    .data-table { font-size: 12.5px; }
    .act-btn { padding: 5px 10px; font-size: 11.5px; }
}
@media (prefers-reduced-motion: reduce) {
    *, .data-table tbody tr { animation: none !important; transition: none !important; }
}
</style>

<div class="page-root">

    <!-- PAGE HEADER -->
    <div class="page-header anim-down">
        <div>
            <h1 class="page-title">Student Records</h1>
            <p class="page-breadcrumb">Dashboard &rsaquo; Student Records</p>
        </div>
        <span class="count-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <?= $this->Number->format($totalStudents) ?> Registered Students
        </span>
    </div>

    <!-- MAIN CARD -->
    <div class="main-card anim-up">
        <div class="main-card-body">

            <!-- FILTER BAR -->
            <?= $this->Form->create(null, ['type' => 'get', 'style' => 'margin:0;']) ?>
            <div class="filter-bar">
                <div class="search-wrap">
                    <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <?= $this->Form->control('search', [
                        'label'       => false,
                        'class'       => 'search-input',
                        'placeholder' => 'Search by name, matrix ID, or programme…',
                        'value'       => $search,
                    ]) ?>
                </div>
                <button type="submit" class="btn-primary-brand">Search</button>
                <?php if (!empty($search)): ?>
                    <?= $this->Html->link('Clear', ['action' => 'index'], ['class' => 'btn-ghost text-decoration-none']) ?>
                <?php endif; ?>
            </div>
            <?= $this->Form->end() ?>

            <!-- TABLE -->
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:6%;"><?= $this->Paginator->sort('id', 'No.') ?></th>
                            <th style="width:14%;"><?= $this->Paginator->sort('matrix_id', 'Matrix ID') ?></th>
                            <th style="width:24%;"><?= $this->Paginator->sort('full_name', 'Student Name') ?></th>
                            <th style="width:22%;"><?= $this->Paginator->sort('email', 'Email') ?></th>
                            <th style="width:20%;"><?= $this->Paginator->sort('faculty', 'Faculty / Programme') ?></th>
                            <th style="width:14%; text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($students->count() > 0): ?>
                            <?php foreach ($students as $student): ?>
                                <tr class="student-row">
                                    <td class="row-num"><?= $this->Number->format($student->id) ?></td>
                                    <td><span class="cell-id"><?= h($student->matrix_id) ?></span></td>
                                    <td>
                                        <div class="cell-name">
                                            <div class="avatar">
                                                <?= !empty($student->full_name) ? strtoupper(substr($student->full_name, 0, 1)) : '?' ?>
                                            </div>
                                            <span class="name-text"><?= h($student->full_name ?? 'N/A') ?></span>
                                        </div>
                                    </td>
                                    <td><span class="cell-email"><?= h($student->email) ?></span></td>
                                    <td><span class="cell-prog"><?= h($student->faculty ?? '—') ?></span></td>
                                    <td style="text-align:center;">
                                        <div class="act-group">
                                            <?= $this->Html->link('View', ['action' => 'view', $student->id], ['class' => 'act-btn act-view']) ?>
                                            <?= $this->Html->link('Edit', ['action' => 'edit', $student->id], ['class' => 'act-btn act-edit']) ?>
                                            <button type="button" class="act-btn act-del"
                                                onclick="openDelModal(
                                                    '<?= h($student->id) ?>',
                                                    '<?= h(addslashes($student->full_name ?? 'this student')) ?>',
                                                    '<?= $this->Url->build(['action' => 'delete', $student->id]) ?>'
                                                )">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                                        </svg>
                                        <p class="empty-title">No students found</p>
                                        <p class="empty-sub"><?= !empty($search) ? 'Try a different search term.' : 'No student records have been added yet.' ?></p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <?php if ($totalStudents > 5): ?>
                <div class="pagination-bar">
                    <p class="pagination-info">
                        <?= $this->Paginator->counter('Showing {{start}}–{{end}} of {{count}} entries') ?>
                    </p>
                    <nav aria-label="Pagination">
                        <ul class="custom-pagination-group">
                            <?= $this->Paginator->prev('Prev', [
                                'tag'         => 'li',
                                'class'       => 'page-item',
                                'disabledTag' => 'li',
                                'disabledClass' => 'page-item disabled',
                            ]) ?>
                            <?= $this->Paginator->numbers([
                                'tag'          => 'li',
                                'class'        => 'page-item',
                                'separator'    => '',
                                'currentClass' => 'active',
                                'currentTag'   => 'span',
                            ]) ?>
                            <?= $this->Paginator->next('Next', [
                                'tag'         => 'li',
                                'class'       => 'page-item',
                                'disabledTag' => 'li',
                                'disabledClass' => 'page-item disabled',
                            ]) ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal-overlay" id="del-overlay" role="dialog" aria-modal="true" aria-labelledby="del-title">
    <div class="del-modal">
        <div class="del-modal-icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
            </svg>
        </div>
        <h6 id="del-title">Remove Student Record?</h6>
        <p id="del-msg">This action cannot be undone. The student record will be permanently removed.</p>
        <div class="del-modal-actions">
            <button type="button" class="btn-cancel-modal" onclick="closeDelModal()">Cancel</button>
            <form id="del-form" method="post" style="flex:1; display:flex;">
                <input type="hidden" name="_method" value="POST">
                <?= $this->Form->hidden('_csrfToken', ['value' => $this->request->getAttribute('csrfToken') ?? '']) ?>
                <button type="submit" class="btn-confirm-del" style="width:100%;">Remove</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.student-row').forEach(function (row, i) {
        row.style.animationDelay = (i * 35) + 'ms';
    });
});

function openDelModal(id, name, url) {
    document.getElementById('del-msg').textContent =
        'Are you sure you want to remove the record for "' + name + '"? This action cannot be undone.';
    document.getElementById('del-form').action = url;
    document.getElementById('del-overlay').classList.add('open');
    document.querySelector('.btn-cancel-modal').focus();
}

function closeDelModal() {
    document.getElementById('del-overlay').classList.remove('open');
}

document.getElementById('del-overlay').addEventListener('click', function (e) {
    if (e.target === this) closeDelModal();
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeDelModal();
});
</script>