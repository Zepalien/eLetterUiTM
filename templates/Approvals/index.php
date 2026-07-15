<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LetterRequest> $requests
 */
$currentStatus = $status ?? 'Pending';
?>
<style>
/* ===================================================
   DESIGN TOKENS
=================================================== */
:root {
    --brand:         #4c1d95;
    --brand-dark:    #3b1478;
    --brand-light:   #ede9fe;
    --brand-glow:    rgba(76,29,149,.15);

    --surface:       #ffffff;
    --bg:            #f4f5f7;
    --border:        #e4e6ea;
    --border-focus:  #a78bfa;

    --text-primary:   #111827;
    --text-secondary: #6b7280;
    --text-muted:     #9ca3af;

    --pending-bg:    #fffbeb;
    --pending-text:  #92400e;
    --pending-dot:   #f59e0b;
    --pending-tab:   #fef3c7;
    --pending-border:#fcd34d;

    --approved-bg:   #f0fdf4;
    --approved-text: #14532d;
    --approved-dot:  #22c55e;
    --approved-tab:  #dcfce7;
    --approved-border:#86efac;

    --rejected-bg:   #fff1f2;
    --rejected-text: #881337;
    --rejected-dot:  #f43f5e;
    --rejected-tab:  #ffe4e6;
    --rejected-border:#fda4af;

    --radius-sm:  6px;
    --radius-md:  10px;
    --radius-lg:  14px;
    --radius-xl:  20px;

    --shadow-card: 0 1px 4px rgba(0,0,0,.06), 0 6px 20px rgba(0,0,0,.05);
    --transition:  0.18s cubic-bezier(.4,0,.2,1);
    --transition-slow: 0.32s cubic-bezier(.4,0,.2,1);
}

/* ===================================================
   ANIMATIONS
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
    from { opacity: 0; transform: translateX(-4px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes modalIn {
    from { opacity: 0; transform: scale(.95) translateY(10px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

.anim-down { opacity: 0; animation: fadeDown var(--transition-slow) forwards; }
.anim-up   { opacity: 0; animation: fadeUp  var(--transition-slow) 0.08s forwards; }

/* ===================================================
   PAGE SHELL
=================================================== */
.appr-root {
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
    display: flex;
    align-items: center;
    gap: 5px;
}
.page-breadcrumb svg { opacity: .6; }

/* ===================================================
   STATUS TABS
=================================================== */
.tab-card {
    background: var(--surface);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-card);
    padding: 8px;
    margin-bottom: 16px;
}
.tab-list {
    display: flex;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.tab-list li { flex: 1; }

.tab-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 11px 16px;
    border-radius: var(--radius-lg);
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    color: var(--text-secondary);
    background: transparent;
    border: 1.5px solid transparent;
    transition: background var(--transition), color var(--transition), border-color var(--transition);
    white-space: nowrap;
}
.tab-link:hover { background: var(--bg); color: var(--text-primary); }

/* Status dot */
.tab-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
    transition: transform var(--transition);
}
.tab-link:hover .tab-dot { transform: scale(1.25); }

/* Count pill */
.tab-count {
    font-size: 11.5px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 99px;
    margin-left: 2px;
}

/* Active states */
.tab-pending.tab-active  { background: var(--pending-tab);  color: var(--pending-text);  border-color: var(--pending-border); }
.tab-approved.tab-active { background: var(--approved-tab); color: var(--approved-text); border-color: var(--approved-border); }
.tab-rejected.tab-active { background: var(--rejected-tab); color: var(--rejected-text); border-color: var(--rejected-border); }

.tab-pending  .tab-dot { background: var(--pending-dot); }
.tab-approved .tab-dot { background: var(--approved-dot); }
.tab-rejected .tab-dot { background: var(--rejected-dot); }

.tab-pending  .tab-count { background: rgba(245,158,11,.15); color: var(--pending-text); }
.tab-approved .tab-count { background: rgba(34,197,94,.15);  color: var(--approved-text); }
.tab-rejected .tab-count { background: rgba(244,63,94,.15);  color: var(--rejected-text); }

/* ===================================================
   SEARCH BAR
=================================================== */
.search-card {
    background: var(--surface);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-card);
    padding: 16px 20px;
    margin-bottom: 16px;
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}
.search-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
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
    padding: 10px 12px 10px 38px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 13.5px;
    color: var(--text-primary);
    background: var(--bg);
    outline: none;
    transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
    box-sizing: border-box;
}
.search-input::placeholder { color: var(--text-muted); }
.search-input:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(167,139,250,.18);
    background: var(--surface);
}
.btn-search {
    padding: 10px 24px;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    box-shadow: 0 2px 8px var(--brand-glow);
    white-space: nowrap;
}
.btn-search:hover {
    background: var(--brand-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px var(--brand-glow);
}
.btn-search:active { transform: translateY(0); }

/* ===================================================
   MAIN TABLE CARD
=================================================== */
.table-card {
    background: var(--surface);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}

/* ===================================================
   TABLE
=================================================== */
.appr-table {
    width: 100%;
    border-collapse: collapse;
}
.appr-table thead tr {
    background: var(--bg);
    border-bottom: 1px solid var(--border);
}
.appr-table thead th {
    padding: 12px 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .65px;
    text-transform: uppercase;
    color: var(--text-secondary);
    white-space: nowrap;
}
.appr-table thead th:first-child { padding-left: 24px; }
.appr-table thead th:last-child  { padding-right: 24px; }

.appr-table tbody tr {
    border-bottom: 1px solid #f1f3f5;
    opacity: 0;
    animation: rowFade 0.28s ease-out forwards;
    transition: background var(--transition);
}
.appr-table tbody tr:last-child { border-bottom: none; }
.appr-table tbody tr:hover { background: #fafbfc; }

.appr-table tbody td {
    padding: 15px 16px;
    font-size: 13.5px;
    color: var(--text-primary);
    vertical-align: middle;
}
.appr-table tbody td:first-child { padding-left: 24px; }
.appr-table tbody td:last-child  { padding-right: 24px; }

/* Cell helpers */
.cell-primary   { font-weight: 700; color: var(--text-primary); display: block; }
.cell-secondary { font-size: 12px; color: var(--text-muted); display: block; margin-top: 2px; }
.cell-truncate  { max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; color: var(--text-secondary); }
.cell-date      { font-size: 13px; color: var(--text-secondary); white-space: nowrap; }

/* ===================================================
   STATUS BADGES (in table)
=================================================== */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 13px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}
.status-pill::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}
.pill-pending  { background: var(--pending-bg);  color: var(--pending-text); }
.pill-pending::before  { background: var(--pending-dot); }
.pill-approved { background: var(--approved-bg); color: var(--approved-text); }
.pill-approved::before { background: var(--approved-dot); }
.pill-rejected { background: var(--rejected-bg); color: var(--rejected-text); }
.pill-rejected::before { background: var(--rejected-dot); }

/* ===================================================
   ACTION BUTTON (Review)
=================================================== */
.btn-review {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    background: var(--brand-light);
    color: var(--brand);
    border: 1.5px solid #c4b5fd;
    border-radius: var(--radius-md);
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    transition: background var(--transition), border-color var(--transition), transform var(--transition);
    white-space: nowrap;
}
.btn-review:hover {
    background: #ddd6fe;
    border-color: #a78bfa;
    transform: translateY(-1px);
}
.btn-review:active { transform: translateY(0); }

/* ===================================================
   EMPTY STATE
=================================================== */
.empty-state {
    padding: 60px 24px;
    text-align: center;
    color: var(--text-muted);
}
.empty-state svg { width: 44px; height: 44px; opacity: .28; margin: 0 auto 14px; display: block; }
.empty-title { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 0 0 5px; }
.empty-sub   { font-size: 13px; margin: 0; }

/* ===================================================
   MODAL
=================================================== */
.modal-content {
    border: none !important;
    border-radius: var(--radius-xl) !important;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,.2) !important;
    animation: modalIn 0.25s cubic-bezier(.34,1.2,.64,1) forwards;
}

/* Modal header */
.modal-header-custom {
    background: var(--brand);
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: none;
}
.modal-header-custom svg { color: rgba(255,255,255,.7); flex-shrink: 0; }
.modal-title-custom {
    font-size: 15px;
    font-weight: 700;
    color: #fff;
    margin: 0;
    letter-spacing: -.1px;
}
.modal-title-sub {
    font-size: 12px;
    color: rgba(255,255,255,.6);
    margin: 2px 0 0;
}
.modal-close-btn {
    margin-left: auto;
    background: rgba(255,255,255,.15);
    border: none;
    border-radius: var(--radius-sm);
    color: rgba(255,255,255,.85);
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background var(--transition);
    flex-shrink: 0;
}
.modal-close-btn:hover { background: rgba(255,255,255,.25); }

/* Modal body */
.modal-body-custom { padding: 24px; background: var(--surface); }

/* Info grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 20px;
}
.info-col { padding: 18px 20px; }
.info-col:first-child { border-right: 1px solid var(--border); }

.info-field { margin-bottom: 16px; }
.info-field:last-child { margin-bottom: 0; }
.info-field-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .55px;
    margin-bottom: 4px;
    display: block;
}
.info-field-value {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.5;
}
.info-field-value-light {
    font-size: 13px;
    font-weight: 400;
    color: var(--text-secondary);
    background: var(--bg);
    border-radius: var(--radius-sm);
    padding: 8px 10px;
    margin: 0;
    line-height: 1.55;
}

/* Remarks textarea */
.remarks-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: .55px;
    margin-bottom: 8px;
}
.remarks-textarea {
    width: 100%;
    padding: 11px 13px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 13.5px;
    color: var(--text-primary);
    background: var(--surface);
    resize: vertical;
    min-height: 90px;
    outline: none;
    transition: border-color var(--transition), box-shadow var(--transition);
    font-family: inherit;
    box-sizing: border-box;
}
.remarks-textarea::placeholder { color: var(--text-muted); }
.remarks-textarea:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(167,139,250,.18);
}

/* Modal footer */
.modal-footer-custom {
    padding: 16px 24px;
    background: var(--bg);
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}
.btn-modal-cancel {
    padding: 10px 22px;
    background: var(--surface);
    color: var(--text-secondary);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    transition: background var(--transition), border-color var(--transition);
}
.btn-modal-cancel:hover { background: #e9ecef; border-color: #c4c9d4; color: var(--text-primary); }

.btn-reject {
    padding: 10px 22px;
    background: var(--rejected-bg);
    color: #be123c;
    border: 1.5px solid #fda4af;
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: background var(--transition), border-color var(--transition), transform var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-reject:hover { background: #ffe4e6; border-color: #fb7185; transform: translateY(-1px); }
.btn-reject:active { transform: translateY(0); }

.btn-approve {
    padding: 10px 22px;
    background: #16a34a;
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 2px 8px rgba(22,163,74,.25);
}
.btn-approve:hover { background: #15803d; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(22,163,74,.3); }
.btn-approve:active { transform: translateY(0); }

/* ===================================================
   RESPONSIVE
=================================================== */
@media (max-width: 768px) {
    .appr-root { padding: 16px 14px; }
    .tab-list { flex-direction: column; }
    .info-grid { grid-template-columns: 1fr; }
    .info-col:first-child { border-right: none; border-bottom: 1px solid var(--border); }
    .modal-footer-custom { flex-direction: column-reverse; }
    .btn-reject, .btn-approve, .btn-modal-cancel { width: 100%; justify-content: center; }
}
@media (prefers-reduced-motion: reduce) {
    .anim-down, .anim-up, .appr-table tbody tr { animation: none !important; opacity: 1 !important; }
    * { transition: none !important; }
}
</style>

<div class="appr-root">

    <!-- PAGE HEADER -->
    <div class="page-header anim-down">
        <div>
            <h1 class="page-title">Approval Management</h1>
            <p class="page-breadcrumb">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Dashboard &rsaquo; Approval Management
            </p>
        </div>
    </div>

    <!-- STATUS TABS -->
    <div class="tab-card anim-down" style="animation-delay:.05s;">
        <ul class="tab-list">
            <li>
                <?= $this->Html->link(
                    '<span class="tab-dot"></span>Awaiting Action<span class="tab-count">' . ($pendingCount ?? 0) . '</span>',
                    ['action' => 'index', '?' => ['status' => 'Pending']],
                    [
                        'class'  => 'tab-link tab-pending' . ($currentStatus === 'Pending' ? ' tab-active' : ''),
                        'escape' => false,
                    ]
                ) ?>
            </li>
            <li>
                <?= $this->Html->link(
                    '<span class="tab-dot"></span>Approved<span class="tab-count">' . ($approvedCount ?? 0) . '</span>',
                    ['action' => 'index', '?' => ['status' => 'Approved']],
                    [
                        'class'  => 'tab-link tab-approved' . ($currentStatus === 'Approved' ? ' tab-active' : ''),
                        'escape' => false,
                    ]
                ) ?>
            </li>
            <li>
                <?= $this->Html->link(
                    '<span class="tab-dot"></span>Rejected<span class="tab-count">' . ($rejectedCount ?? 0) . '</span>',
                    ['action' => 'index', '?' => ['status' => 'Rejected']],
                    [
                        'class'  => 'tab-link tab-rejected' . ($currentStatus === 'Rejected' ? ' tab-active' : ''),
                        'escape' => false,
                    ]
                ) ?>
            </li>
        </ul>
    </div>

    <!-- SEARCH -->
    <div class="search-card anim-up" style="animation-delay:.1s;">
        <?= $this->Form->create(null, ['type' => 'get', 'style' => 'display:contents;']) ?>
        <?= $this->Form->hidden('status', ['value' => $currentStatus]) ?>
        <div class="search-wrap">
            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <?= $this->Form->control('search', [
                'label'       => false,
                'class'       => 'search-input',
                'placeholder' => 'Search by matrix ID or organisation name…',
                'value'       => $search ?? '',
            ]) ?>
        </div>
        <button type="submit" class="btn-search">Search</button>
        <?= $this->Form->end() ?>
    </div>

    <!-- TABLE CARD -->
    <div class="table-card anim-up" style="animation-delay:.15s;">
        <div style="overflow-x:auto;">
            <table class="appr-table">
                <thead>
                    <tr>
                        <th>Matrix ID</th>
                        <th>Organisation</th>
                        <th>Purpose</th>
                        <th>Date Applied</th>
                        <th style="text-align:center; width:160px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($requests) && !$requests->isEmpty()): ?>
                        <?php foreach ($requests as $i => $request): ?>
                            <tr class="appr-row" style="animation-delay:<?= $i * 35 ?>ms;">
                                <td>
                                    <span class="cell-primary"><?= h($request->matrix_id) ?></span>
                                    <span class="cell-secondary">Ref #<?= h($request->id) ?></span>
                                </td>
                                <td>
                                    <span class="cell-primary"><?= h($request->organization_name) ?></span>
                                    <span class="cell-secondary"><?= h($request->program_name ?? '—') ?></span>
                                </td>
                                <td>
                                    <span class="cell-truncate" title="<?= h($request->purpose) ?>"><?= h($request->purpose) ?></span>
                                </td>
                                <td>
                                    <span class="cell-date"><?= $request->created_at ? h($request->created_at->format('d M Y, g:i A')) : '—' ?></span>
                                </td>
                                <td style="text-align:center;">
                                    <?php if ($request->status === 'Pending'): ?>
                                        <button type="button" class="btn-review"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reviewModal<?= $request->id ?>">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                            Review
                                        </button>
                                    <?php else: ?>
                                        <?php
                                            $pillClass = 'pill-pending';
                                            if ($request->status === 'Approved') $pillClass = 'pill-approved';
                                            if ($request->status === 'Rejected') $pillClass = 'pill-rejected';
                                        ?>
                                        <span class="status-pill <?= $pillClass ?>"
                                            <?php if (!empty($request->admin_remarks)): ?>
                                            title="<?= h($request->admin_remarks) ?>"
                                            data-bs-toggle="tooltip"
                                            <?php endif; ?>>
                                            <?= h($request->status) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- REVIEW MODAL -->
                            <div class="modal fade" id="reviewModal<?= $request->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header-custom">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                                            </svg>
                                            <div>
                                                <p class="modal-title-custom">Letter Request Review</p>
                                                <p class="modal-title-sub">Reference #<?= h($request->id) ?> &mdash; <?= h($request->matrix_id) ?></p>
                                            </div>
                                            <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                            </button>
                                        </div>

                                        <?= $this->Form->create(null, ['url' => ['action' => 'changeStatus', $request->id], 'type' => 'post']) ?>
                                        <input type="hidden" name="current_status" value="<?= $currentStatus ?>">

                                        <!-- Modal Body -->
                                        <div class="modal-body-custom">
                                            <div class="info-grid">
                                                <div class="info-col">
                                                    <div class="info-field">
                                                        <span class="info-field-label">Student Matrix ID</span>
                                                        <p class="info-field-value" style="font-size:16px;"><?= h($request->matrix_id) ?></p>
                                                    </div>
                                                    <div class="info-field">
                                                        <span class="info-field-label">Organisation</span>
                                                        <p class="info-field-value"><?= h($request->organization_name) ?></p>
                                                    </div>
                                                    <div class="info-field">
                                                        <span class="info-field-label">Address</span>
                                                        <p class="info-field-value-light"><?= h($request->organization_address ?? 'No address provided.') ?></p>
                                                    </div>
                                                </div>
                                                <div class="info-col">
                                                    <div class="info-field">
                                                        <span class="info-field-label">Purpose of Request</span>
                                                        <p class="info-field-value"><?= h($request->purpose) ?></p>
                                                    </div>
                                                    <div class="info-field">
                                                        <span class="info-field-label">Supporting Reason</span>
                                                        <p class="info-field-value-light"><?= h($request->reason ?? 'No additional reason provided.') ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <label class="remarks-label" for="remarks-<?= $request->id ?>">
                                                Administrator Remarks
                                            </label>
                                            <textarea
                                                id="remarks-<?= $request->id ?>"
                                                name="admin_remarks"
                                                class="remarks-textarea"
                                                rows="3"
                                                placeholder="e.g. Documents verified and complete. Student to collect within 3 working days."></textarea>
                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="modal-footer-custom">
                                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                                <button type="submit" name="status_decision" value="Rejected" class="btn-reject"
                                                    onclick="return confirm('Confirm rejection of this request?');">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                                    Reject
                                                </button>
                                                <button type="submit" name="status_decision" value="Approved" class="btn-approve"
                                                    onclick="return confirm('Confirm approval of this letter request?');">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                                    Approve
                                                </button>
                                            </div>
                                        </div>

                                        <?= $this->Form->end() ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /REVIEW MODAL -->

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                    </svg>
                                    <p class="empty-title">No <?= strtolower(h($currentStatus)) ?> requests</p>
                                    <p class="empty-sub">There are no letter requests in this category at the moment.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    /* Bootstrap tooltip init */
    var tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(function (el) {
        new bootstrap.Tooltip(el, { placement: 'top' });
    });
});
</script>