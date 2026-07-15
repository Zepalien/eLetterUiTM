<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $student
 */
?>
<style>
/* ===================================================
   DESIGN TOKENS (shared with index)
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
    --transition:  0.18s cubic-bezier(.4,0,.2,1);
    --transition-slow: 0.32s cubic-bezier(.4,0,.2,1);
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===================================================
   PAGE SHELL
=================================================== */
.edit-root {
    background: var(--bg);
    min-height: 100vh;
    padding: 32px 20px;
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
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
    margin-bottom: 20px;
    transition: color var(--transition);
    align-self: flex-start;
    max-width: 680px;
    width: 100%;
}
.back-link svg { transition: transform var(--transition); }
.back-link:hover { color: var(--brand); }
.back-link:hover svg { transform: translateX(-3px); }

/* ===================================================
   CARD
=================================================== */
.edit-card {
    background: var(--surface);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-card);
    border: 1px solid var(--border);
    width: 100%;
    max-width: 680px;
    overflow: hidden;
    opacity: 0;
    animation: fadeUp var(--transition-slow) 0.05s forwards;
}

.edit-card-header {
    background: var(--brand);
    padding: 20px 28px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.edit-card-header svg { color: rgba(255,255,255,.7); flex-shrink: 0; }
.edit-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    margin: 0;
    letter-spacing: -.1px;
}
.edit-card-sub {
    font-size: 12.5px;
    color: rgba(255,255,255,.65);
    margin: 2px 0 0;
}

.edit-card-body { padding: 28px; }

/* ===================================================
   FORM CONTROLS
=================================================== */
.field-group { margin-bottom: 20px; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }

.field-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: .55px;
    margin-bottom: 7px;
}
.field-required::after {
    content: '*';
    color: #e11d48;
    margin-left: 3px;
}

.field-input {
    width: 100%;
    padding: 10px 13px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 14px;
    color: var(--text-primary);
    background: var(--surface);
    outline: none;
    transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
    box-sizing: border-box;
}
.field-input::placeholder { color: var(--text-muted); }
.field-input:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(167,139,250,.18);
    background: #fdfcff;
}
.field-input:hover:not(:focus) { border-color: #c4c9d4; }

/* Override CakePHP generated wrappers */
.field-group div, .field-row > div { display: contents; }

/* ===================================================
   DIVIDER
=================================================== */
.section-divider {
    border: none;
    border-top: 1px solid var(--border);
    margin: 24px 0;
}

/* ===================================================
   FORM ACTIONS
=================================================== */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 8px;
}
.btn-cancel {
    padding: 10px 22px;
    background: var(--surface);
    color: var(--text-secondary);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background var(--transition), border-color var(--transition);
    display: inline-flex;
    align-items: center;
}
.btn-cancel:hover { background: var(--bg); border-color: #c4c9d4; color: var(--text-primary); }

.btn-save {
    padding: 10px 26px;
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    box-shadow: 0 2px 8px var(--brand-glow);
    display: inline-flex;
    align-items: center;
    gap: 7px;
}
.btn-save:hover {
    background: var(--brand-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 16px var(--brand-glow);
}
.btn-save:active { transform: translateY(0); }

/* ===================================================
   RESPONSIVE
=================================================== */
@media (max-width: 580px) {
    .edit-root { padding: 20px 12px; }
    .edit-card-body { padding: 20px 18px; }
    .field-row { grid-template-columns: 1fr; gap: 0; }
    .field-row .field-group { margin-bottom: 20px; }
}
@media (prefers-reduced-motion: reduce) {
    .edit-card { animation: none; opacity: 1; }
    * { transition: none !important; }
}
</style>

<div class="edit-root">

    <?= $this->Html->link(
        '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg> Back to List',
        ['action' => 'index'],
        ['class' => 'back-link', 'escape' => false]
    ) ?>

    <div class="edit-card">
        <div class="edit-card-header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            <div>
                <h5 class="edit-card-title">Edit Student Profile</h5>
                <p class="edit-card-sub">Update the details below and save your changes.</p>
            </div>
        </div>

        <div class="edit-card-body">
            <?= $this->Form->create($student, ['novalidate' => false]) ?>

            <!-- Identity -->
            <div class="field-row">
                <div class="field-group">
                    <label class="field-label field-required" for="matrix-id-field">Matrix ID</label>
                    <?= $this->Form->control('matrix_id', [
                        'label'    => false,
                        'id'       => 'matrix-id-field',
                        'class'    => 'field-input',
                        'required' => true,
                    ]) ?>
                </div>
                <div class="field-group">
                    <label class="field-label field-required" for="name-field">Full Name</label>
                    <?= $this->Form->control('name', [
                        'label'    => false,
                        'id'       => 'name-field',
                        'class'    => 'field-input',
                        'required' => true,
                    ]) ?>
                </div>
            </div>

            <!-- Academic -->
            <div class="field-row">
                <div class="field-group">
                    <label class="field-label" for="programme-field">Programme Code</label>
                    <?= $this->Form->control('programme', [
                        'label'       => false,
                        'id'          => 'programme-field',
                        'class'       => 'field-input',
                        'placeholder' => 'e.g. CDIM244',
                    ]) ?>
                </div>
                <div class="field-group">
                    <label class="field-label" for="faculty-field">Faculty</label>
                    <?= $this->Form->control('faculty', [
                        'label'       => false,
                        'id'          => 'faculty-field',
                        'class'       => 'field-input',
                        'placeholder' => 'e.g. Faculty of Engineering',
                    ]) ?>
                </div>
            </div>

            <hr class="section-divider">

            <!-- Contact -->
            <div class="field-group">
                <label class="field-label field-required" for="email-field">Email Address</label>
                <?= $this->Form->control('email', [
                    'label'    => false,
                    'id'       => 'email-field',
                    'class'    => 'field-input',
                    'type'     => 'email',
                    'required' => true,
                ]) ?>
            </div>

            <div class="field-group">
                <label class="field-label field-required" for="phone-field">Phone Number</label>
                <?= $this->Form->control('phone_number', [
                    'label'    => false,
                    'id'       => 'phone-field',
                    'class'    => 'field-input',
                    'type'     => 'tel',
                    'required' => true,
                ]) ?>
            </div>

            <div class="form-actions">
                <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn-cancel']) ?>
                <button type="submit" class="btn-save">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Save Changes
                </button>
            </div>

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>