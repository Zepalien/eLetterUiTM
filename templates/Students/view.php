<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $student
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

    --text-primary:   #111827;
    --text-secondary: #6b7280;
    --text-muted:     #9ca3af;

    --radius-sm:  6px;
    --radius-md:  10px;
    --radius-lg:  14px;
    --radius-xl:  20px;

    --shadow-card: 0 1px 4px rgba(0,0,0,.06), 0 6px 20px rgba(0,0,0,.05);
    --transition:  0.18s cubic-bezier(.4,0,.2,1);
    --transition-slow: 0.32s cubic-bezier(.4,0,.2,1);
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeLeft {
    from { opacity: 0; transform: translateX(-12px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes rowFade {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===================================================
   PAGE SHELL
=================================================== */
.view-root {
    background: var(--bg);
    min-height: 100vh;
    padding: 28px 24px;
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
}

/* ===================================================
   BACK LINK
=================================================== */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    text-decoration: none;
    margin-bottom: 22px;
    transition: color var(--transition);
}
.back-link svg { transition: transform var(--transition); }
.back-link:hover { color: var(--brand); }
.back-link:hover svg { transform: translateX(-3px); }

/* ===================================================
   GRID LAYOUT
=================================================== */
.view-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 20px;
    align-items: start;
}

/* ===================================================
   PROFILE CARD (LEFT)
=================================================== */
.profile-card {
    background: var(--surface);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    opacity: 0;
    animation: fadeLeft var(--transition-slow) 0.05s forwards;
}

.profile-header {
    background: linear-gradient(145deg, var(--brand) 0%, #6d28d9 100%);
    padding: 30px 24px 24px;
    text-align: center;
}
.profile-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: rgba(255,255,255,.2);
    color: #fff;
    font-size: 26px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
    border: 2.5px solid rgba(255,255,255,.35);
    letter-spacing: -.5px;
}
.profile-name {
    font-size: 17px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 4px;
    letter-spacing: -.2px;
}
.profile-role {
    font-size: 12px;
    color: rgba(255,255,255,.65);
    margin: 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .6px;
}

.profile-body { padding: 22px 22px 24px; }

.info-item { margin-bottom: 16px; }
.info-item:last-child { margin-bottom: 0; }
.info-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.info-label svg { color: var(--text-muted); opacity: .7; }
.info-value {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-primary);
    word-break: break-word;
}
.info-value-muted { color: var(--text-muted); font-weight: 500; }

.profile-divider {
    border: none;
    border-top: 1px solid var(--border);
    margin: 18px 0;
}

/* ===================================================
   HISTORY CARD (RIGHT)
=================================================== */
.history-card {
    background: var(--surface);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-card);
    overflow: hidden;
    opacity: 0;
    animation: fadeUp var(--transition-slow) 0.12s forwards;
}

.history-header {
    padding: 18px 24px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.history-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 9px;
}
.history-title svg { color: var(--brand); }
.history-count {
    font-size: 12px;
    font-weight: 600;
    color: var(--brand);
    background: var(--brand-light);
    padding: 4px 12px;
    border-radius: 99px;
}

.history-body { padding: 0; }

/* ===================================================
   TABLE
=================================================== */
.hist-table {
    width: 100%;
    border-collapse: collapse;
}
.hist-table thead tr {
    background: var(--bg);
    border-bottom: 1px solid var(--border);
}
.hist-table thead th {
    padding: 11px 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: var(--text-secondary);
    white-space: nowrap;
}

.hist-table tbody tr {
    border-bottom: 1px solid #f1f3f5;
    opacity: 0;
    animation: rowFade 0.3s ease-out forwards;
    transition: background var(--transition);
}
.hist-table tbody tr:last-child { border-bottom: none; }
.hist-table tbody tr:hover { background: #fafbfc; }

.hist-table tbody td {
    padding: 14px 16px;
    font-size: 13.5px;
    color: var(--text-primary);
    vertical-align: middle;
}

.td-date { color: var(--text-secondary); font-size: 13px; white-space: nowrap; }
.td-org  { font-weight: 600; color: var(--text-primary); }
.td-purpose { color: var(--text-secondary); font-size: 13px; max-width: 180px; }

/* STATUS BADGES */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 11px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}
.status-badge::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}
.badge-pending  { background: #fffbeb; color: #b45309; }
.badge-pending::before  { background: #f59e0b; }
.badge-approved { background: #f0fdf4; color: #15803d; }
.badge-approved::before { background: #22c55e; }
.badge-rejected { background: #fff1f2; color: #be123c; }
.badge-rejected::before { background: #f43f5e; }

/* ACTION LINK */
.btn-view-letter {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 13px;
    background: var(--brand-light);
    color: var(--brand);
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: background var(--transition), transform var(--transition);
}
.btn-view-letter:hover {
    background: #ddd6fe;
    transform: translateY(-1px);
}

/* ===================================================
   EMPTY STATE
=================================================== */
.empty-history {
    padding: 52px 24px;
    text-align: center;
    color: var(--text-muted);
}
.empty-history svg { width: 44px; height: 44px; opacity: .3; margin-bottom: 14px; display: block; margin-left: auto; margin-right: auto; }
.empty-history-title { font-size: 14.5px; font-weight: 600; color: var(--text-secondary); margin: 0 0 5px; }
.empty-history-sub   { font-size: 13px; margin: 0; }

/* ===================================================
   RESPONSIVE
=================================================== */
@media (max-width: 900px) {
    .view-grid { grid-template-columns: 1fr; }
    .profile-card { animation-name: fadeUp; }
}
@media (max-width: 600px) {
    .view-root { padding: 16px 14px; }
    .hist-table thead { display: none; }
    .hist-table tbody td { display: block; padding: 6px 14px; }
    .hist-table tbody td::before {
        content: attr(data-label);
        font-size: 10.5px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .5px;
        display: block;
        margin-bottom: 2px;
    }
    .hist-table tbody tr { border-bottom: 1px solid var(--border); padding: 10px 0; }
}
@media (prefers-reduced-motion: reduce) {
    .profile-card, .history-card, .hist-table tbody tr { animation: none; opacity: 1; }
    * { transition: none !important; }
}
</style>

<div class="view-root">

    <?= $this->Html->link(
        '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg> Back to List',
        ['action' => 'index'],
        ['class' => 'back-link', 'escape' => false]
    ) ?>

    <div class="view-grid">

        <!-- LEFT: PROFILE CARD -->
        <aside class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?= strtoupper(substr($student->full_name ?? 'S', 0, 1)) ?>
                </div>
                <h4 class="profile-name"><?= h($student->full_name) ?></h4>
                <p class="profile-role">Student</p>
            </div>

            <div class="profile-body">

                <div class="info-item">
                    <div class="info-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        Matrix ID
                    </div>
                    <div class="info-value"><?= h($student->matrix_id) ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        IC Number
                    </div>
                    <div class="info-value"><?= h($student->ic_number ?? '—') ?></div>
                </div>

                <hr class="profile-divider">

                <div class="info-item">
                    <div class="info-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email Address
                    </div>
                    <div class="info-value"><?= h($student->email ?? '—') ?></div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13 19.79 19.79 0 0 1 1.61 4.38 2 2 0 0 1 3.58 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Phone Number
                    </div>
                    <div class="info-value"><?= h($student->phone_number ?? '—') ?></div>
                </div>

                <hr class="profile-divider">

                <div class="info-item">
                    <div class="info-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Programme Code
                    </div>
                    <div class="info-value <?= empty($student->program_code) ? 'info-value-muted' : '' ?>">
                        <?= h($student->program_code ?? 'Not assigned') ?>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Faculty
                    </div>
                    <div class="info-value <?= empty($student->faculty) ? 'info-value-muted' : '' ?>">
                        <?= h($student->faculty ?? 'Not assigned') ?>
                    </div>
                </div>

            </div>
        </aside>

        <!-- RIGHT: LETTER REQUEST HISTORY -->
        <div class="history-card">
            <div class="history-header">
                <h5 class="history-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Letter Request History
                </h5>
                <?php if (!empty($student->letter_requests)): ?>
                    <span class="history-count"><?= count($student->letter_requests) ?> <?= count($student->letter_requests) === 1 ? 'Request' : 'Requests' ?></span>
                <?php endif; ?>
            </div>

            <div class="history-body">
                <?php if (!empty($student->letter_requests)): ?>
                    <div style="overflow-x: auto;">
                        <table class="hist-table">
                            <thead>
                                <tr>
                                    <th>Date Applied</th>
                                    <th>Organization</th>
                                    <th>Purpose</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:center;">Letter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($student->letter_requests as $request): ?>
                                    <tr class="hist-row">
                                        <td class="td-date" data-label="Date Applied">
                                            <?= $request->created_at ? h($request->created_at->format('d M Y')) : '—' ?>
                                        </td>
                                        <td class="td-org" data-label="Organization"><?= h($request->organization_name) ?></td>
                                        <td class="td-purpose" data-label="Purpose"><?= h($request->purpose) ?></td>
                                        <td style="text-align:center;" data-label="Status">
                                            <?php
                                                $cls = 'badge-pending';
                                                if ($request->status === 'Approved') $cls = 'badge-approved';
                                                if ($request->status === 'Rejected') $cls = 'badge-rejected';
                                            ?>
                                            <span class="status-badge <?= $cls ?>"><?= h($request->status) ?></span>
                                        </td>
                                        <td style="text-align:center;" data-label="Letter">
                                            <?= $this->Html->link(
                                                '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> View',
                                                ['controller' => 'LetterRequests', 'action' => 'viewLetter', $request->id],
                                                ['class' => 'btn-view-letter', 'escape' => false]
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-history">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
                        </svg>
                        <p class="empty-history-title">No letter requests yet</p>
                        <p class="empty-history-sub">This student has not submitted any letter requests.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.hist-row').forEach(function (row, i) {
        row.style.animationDelay = (i * 40) + 'ms';
    });
});
</script>