<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LetterRequest $letterRequest
 * @var string[]|\Cake\Collection\CollectionInterface $letterTemplates
 * @var array $signatories
 */
?>
<style>
    .edit-container { padding: 25px; background-color: #f1f5f9; font-family: 'Segoe UI', system-ui, sans-serif; }
    .page-title { color: #1e293b; margin-top: 0; margin-bottom: 20px; font-weight: 700; }

    .split-layout { display: grid; grid-template-columns: 1fr 1.3fr; gap: 25px; align-items: start; }
    @media (max-width: 1100px) { .split-layout { grid-template-columns: 1fr; } }

    .form-card { background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-weight: 600; color: #334155; margin-bottom: 6px; font-size: 14px; }
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box; background-color: #fff; transition: border-color 0.2s, box-shadow 0.2s; }
    .form-control:focus { border-color: #4c1d95; outline: none; box-shadow: 0 0 0 3px rgba(76, 29, 149, 0.1); }
    .form-control:disabled { background-color: #f8fafc; color: #64748b; cursor: not-allowed; }

    .addr-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

    .btn-actions { display: flex; gap: 12px; margin-top: 25px; }
    .btn-save { background: #4c1d95; color: #ffffff; border: none; padding: 12px 20px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.2s; }
    .btn-save:hover { background: #351569; }
    .btn-back { background: #e2e8f0; color: #475569; padding: 12px 20px; border-radius: 6px; font-weight: 600; font-size: 14px; text-decoration: none; text-align: center; transition: background 0.2s; }
    .btn-back:hover { background: #cbd5e1; }

    /* Gaya komponen fail sokongan */
    .file-box { background: #f8fafc; border: 1px dashed #cbd5e1; padding: 12px; border-radius: 6px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
    .file-link { color: #0284c7; text-decoration: none; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; }
    .file-link:hover { text-decoration: underline; }
    .remove-btn-label { font-size: 12px; color: #ef4444; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; border: 1px solid #fee2e2; padding: 4px 8px; background: #fff5f5; border-radius: 4px; }

    .sticky-preview { position: sticky; top: 25px; }
    .letter-preview-outer { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
    .letter-preview-header { background: #1e293b; color: white; padding: 14px 20px; }
    .letter-preview-header h5 { margin: 0; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

    .letter-preview-container {
        background: #fff;
        padding: 25px;
        max-height: 82vh;
        overflow-y: auto;
        font-family: 'Arial', sans-serif;
        color: #000;
        font-size: 13px;
        line-height: 1.6;
    }
    .letter-preview-container .lh-img { width: 100%; height: auto; display: block; margin-bottom: 12px; }
    .letter-preview-container .lf-img { width: 100%; height: auto; display: block; margin-top: 20px; }
    .letter-preview-container .letter-subject { font-weight: bold; text-transform: uppercase; text-decoration: underline; margin-bottom: 12px; }
    .letter-preview-container .student-table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 12px; }
    .letter-preview-container .student-table th,
    .letter-preview-container .student-table td { border: 1px solid #000 !important; padding: 5px 8px; }
    .letter-preview-container .student-table th { background-color: #f8fafc; }
    .letter-preview-container .scope-box { border: 1px solid #000; padding: 8px 10px; margin: 5px 0 15px 0; font-size: 13px; white-space: pre-line; text-align: justify; }
    .signoff-slogan { font-weight: bold; margin-bottom: 10px; font-size: 12px; }
</style>

<div class="edit-container">
    <h2 class="page-title">✏️ Kemaskini Permohonan Surat</h2>

    <?= $this->Form->create($letterRequest, ['type' => 'file']) ?>
    <div class="split-layout">

        <div class="form-card">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b; font-size:16px; border-bottom:1px solid #e2e8f0; padding-bottom:10px;">📋 Butiran Permohonan</h3>

            <?php
                $userRoleId = $this->request->getSession()->read('Auth.role_id');
                $isAdmin = ($userRoleId == 1);
            ?>

            <div class="form-group">
                <label>Jenis Surat</label>
                <?= $this->Form->control('template_id', [
                    'options' => $letterTemplates,
                    'class' => 'form-control',
                    'label' => false,
                    'id' => 'select-template'
                ]) ?>
            </div>

            <div class="form-group">
                <label>Nama Program / Aktiviti</label>
                <?= $this->Form->control('program_name', [
                    'class' => 'form-control',
                    'label' => false,
                    'id' => 'input-program'
                ]) ?>
            </div>

            <div class="form-group">
                <label>Nama Organisasi / Penerima</label>
                <?= $this->Form->control('organization_name', [
                    'class' => 'form-control',
                    'label' => false,
                    'id' => 'input-org-name'
                ]) ?>
            </div>

            <div class="form-group">
                <label>Alamat Baris 1 <span style="color:#ef4444;">*</span></label>
                <?= $this->Form->control('address1', [
                    'class' => 'form-control',
                    'label' => false,
                    'id' => 'input-addr1',
                    'placeholder' => 'No. 12, Jalan Contoh'
                ]) ?>
            </div>
            <div class="form-group addr-row">
                <div>
                    <label>Taman / Kawasan</label>
                    <?= $this->Form->control('address2', [
                        'class' => 'form-control',
                        'label' => false,
                        'id' => 'input-addr2',
                        'placeholder' => 'Taman Sri Muda'
                    ]) ?>
                </div>
                <div>
                    <label>Poskod, Bandar & Negeri</label>
                    <?= $this->Form->control('address3', [
                        'class' => 'form-control',
                        'label' => false,
                        'id' => 'input-addr3',
                        'placeholder' => '40150 Shah Alam, Selangor'
                    ]) ?>
                </div>
            </div>

            <div class="form-group">
                <label>Tujuan / Skop Kajian</label>
                <?= $this->Form->control('purpose', [
                    'type' => 'textarea',
                    'rows' => 3,
                    'class' => 'form-control',
                    'label' => false,
                    'id' => 'input-purpose'
                ]) ?>
            </div>

            <div class="form-group">
                <label>Pegawai Penandatangan</label>
                <?= $this->Form->control('signatory_info', [
                    'type' => 'select',
                    'options' => $signatories,
                    'empty' => '-- Pilih Pegawai Penandatangan --',
                    'class' => 'form-control',
                    'label' => false,
                    'id' => 'select-signatory'
                ]) ?>
            </div>

            <div class="form-group">
               <label>Dokumen Sokongan Semasa</label>
<?php if (!empty($letterRequest->supporting_document)): ?>
    <div class="file-box">
        <?= $this->Html->link(
            '📁 Lihat Fail Semasa',
            '/files/' . $letterRequest->supporting_document,
            ['target' => '_blank', 'class' => 'file-link']
        ) ?>
        <label class="remove-btn-label">
            <?= $this->Form->checkbox('delete_supporting_document', ['id' => 'delete-file']) ?>
            <span>🗑️ Buang Fail</span>
        </label>
    </div>
                <?php else: ?>
                    <div style="font-size:13px; color:#64748b; font-style:italic; margin-bottom:8px;">Tiada dokumen sokongan dilampirkan.</div>
                <?php endif; ?>

                <label style="margin-top: 10px;">Muat Naik / Ganti Dokumen Sokongan</label>
                <?= $this->Form->control('supporting_document', [
                    'type' => 'file',
                    'label' => false,
                    'class' => 'form-control',
                    'accept' => '.pdf,.jpg,.jpeg,.png',
                ]) ?>
                <small style="color:#64748b; display:block; margin-top:4px;">Format diterima: PDF, JPG, PNG (maks. 5MB)</small>
            </div>

            <div class="form-group">
                <label>Status Permohonan</label>
                <?= $this->Form->control('status', [
                    'type' => 'select',
                    'options' => [
                        'Pending'     => 'Pending',
                        'In Progress' => 'In Progress',
                        'Approved'    => 'Approved',
                        'Rejected'    => 'Rejected'
                    ],
                    'class' => 'form-control',
                    'label' => false,
                    'disabled' => !$isAdmin
                ]) ?>
            </div>

            <?php if ($isAdmin): ?>
            <div class="form-group">
                <label>Catatan Admin (Remarks)</label>
                <?= $this->Form->control('admin_remarks', [
                    'type' => 'textarea',
                    'rows' => 2,
                    'class' => 'form-control',
                    'label' => false,
                    'placeholder' => 'Contoh: Sila kemaskini alamat organisasi...'
                ]) ?>
            </div>
            <?php endif; ?>

            <div class="btn-actions">
                <button type="submit" class="btn-save">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M15.854 .146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329 .124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314 .037a.5.5 0 0 1 .54 .11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm-.707 .707L1.43 7.93l4.338 2.761v.085Z"/></svg>
                    Simpan Perubahan
                </button>
                <?= $this->Html->link(__('← Senarai Rekod'), ['action' => 'index'], ['class' => 'btn-back']) ?>
            </div>
        </div>

        <div class="sticky-preview">
            <div class="letter-preview-outer">
                <div class="letter-preview-header">
                    <h5> Pratonton Surat — Langsung</h5>
                </div>

                <div class="letter-preview-container">
                    <div class="mb-3">
                        <?= $this->Html->image('lh.jpeg', ['class' => 'lh-img']) ?>
                    </div>

                    <div class="px-2">
                        <<div class="d-flex justify-content-end mb-4">
                            <div style="width: 280px; font-size: 12px;">
                                <div class="row gx-0 text-start">
                                    <div class="col-4">Ruj. Kami</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-7 text-start">UiTM/PuncakPerdana/600-<?= h($letterRequest->id) ?></div>
                                </div>
                                <div class="row gx-0 text-start mt-1">
                                    <div class="col-4">Tarikh</div>
                                    <div class="col-1 text-center">:</div>
                                    <div class="col-7 text-start"><?= $letterRequest->created_at ? h($letterRequest->created_at->format('d F Y')) : date('d F Y') ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 fw-bold">
                            <div id="pv-org-name" style="font-weight:bold;"><?= h($letterRequest->organization_name ?: '[Nama Organisasi]') ?></div>
                            <div id="pv-addr1" style="font-size:12px; font-weight:normal;"><?= h($letterRequest->address1 ?? '') ?></div>
                            <div id="pv-addr2" style="font-size:12px; font-weight:normal;"><?= h($letterRequest->address2 ?? '') ?></div>
                            <div id="pv-addr3" style="font-size:12px; font-weight:normal;"><?= h($letterRequest->address3 ?? '') ?></div>
                        </div>

                        <div class="mb-3">Tuan/Puan,</div>

                        <div class="letter-subject mb-4" id="pv-subject">
                            PERMOHONAN KEBENARAN UNTUK MENJALANKAN KAJIAN/PROJEK: <?= h(strtoupper($letterRequest->program_name ?? '')) ?>
                        </div>

                        <div id="pv-p1" style="white-space:pre-line; text-align:justify; margin-bottom:12px;"></div>
                        <div id="pv-p2" style="white-space:pre-line; text-align:justify; margin-bottom:12px;"></div>

                        <table class="student-table">
                            <thead>
                                <tr>
                                    <th width="10%">Bil</th>
                                    <th width="55%">Nama Pelajar</th>
                                    <th width="35%">No. Pelajar (Matrik)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?= $letterRequest->hasValue('user') ? h($letterRequest->user->full_name) : '—' ?></td>
                                    <td><?= $letterRequest->hasValue('user') ? h($letterRequest->user->matrix_id) : '—' ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div id="pv-p3" style="white-space:pre-line; text-align:justify; margin: 12px 0;"></div>

                        <p style="font-size:13px; margin-top:12px;"><strong>Tujuan/Skop Projek:</strong></p>
                        <div class="scope-box" id="pv-purpose"><?= h($letterRequest->purpose ?? '') ?></div>

                        <div style="margin-top:20px; line-height:1.4;">
                            <p>Sekian, terima kasih.</p>
                            <div class="signoff-slogan">"MALAYSIA MADANI"<br>"BERKHIDMAT UNTUK NEGARA"</div>
                            <p>Saya yang menjalankan amanah,</p>
                            <div style="margin:15px 0; height:35px; font-style:italic; color:#a1a1aa; font-size:12px;">[Dokumen ini ditandatangani secara digital/elektronik]</div>
                            <p style="margin:0;">
                                <strong id="pv-officer-name" style="text-transform:uppercase;"><?= h($letterRequest->signatory_name ?? '[Nama Pegawai]') ?></strong><br>
                                <span id="pv-officer-post" style="font-size:12px; color:#475569;"><?= h($letterRequest->signatory_position ?? '[Jawatan Pegawai]') ?></span><br>
                                Fakulti Pengurusan Maklumat<br>
                                Universiti Teknologi MARA
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <?= $this->Html->image('lf.jpeg', ['class' => 'lf-img']) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?= $this->Form->end() ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function val(id) {
        var el = document.getElementById(id);
        return el ? el.value.trim() : '';
    }

    var activeTemplate = {};

    function fillPH(text) {
        if (!text) return '';
        return text
            .replace(/\{COMPANY_NAME\}/g,  val('input-org-name')  || '{NAMA_SYARIKAT}')
            .replace(/\{ADDRESS_1\}/g,     val('input-addr1')     || '{ALAMAT_1}')
            .replace(/\{ADDRESS_2\}/g,     val('input-addr2')     || '{ALAMAT_2}')
            .replace(/\{ADDRESS_3\}/g,     val('input-addr3')     || '{ALAMAT_3}')
            .replace(/\{PURPOSE\}/g,       val('input-purpose')   || '{TUJUAN}')
            .replace(/\{PROGRAM_NAME\}/g,  val('input-program')   || '{PROGRAM}');
    }

    function updatePreview() {
        var orgName  = val('input-org-name')  || '[Nama Organisasi]';
        var addr1    = val('input-addr1');
        var addr2    = val('input-addr2');
        var addr3    = val('input-addr3');
        var program  = val('input-program');
        var purpose  = val('input-purpose');

        document.getElementById('pv-org-name').textContent = orgName;
        document.getElementById('pv-addr1').textContent    = addr1;
        document.getElementById('pv-addr2').textContent    = addr2;
        document.getElementById('pv-addr3').textContent    = addr3;
        document.getElementById('pv-purpose').textContent  = purpose;

        document.getElementById('pv-subject').textContent =
            (activeTemplate.subject_line
                ? activeTemplate.subject_line.toUpperCase()
                : 'PERMOHONAN KEBENARAN UNTUK MENJALANKAN KAJIAN/PROJEK: ' + program.toUpperCase());

        document.getElementById('pv-p1').textContent = fillPH(activeTemplate.paragraph_1 || '');
        document.getElementById('pv-p2').textContent = fillPH(activeTemplate.paragraph_2 || '');
        document.getElementById('pv-p3').textContent = fillPH(activeTemplate.paragraph_3 || '');
    }

    var selectTemplate = document.getElementById('select-template');
    if (selectTemplate) {
        selectTemplate.addEventListener('change', function () {
            var id = this.value;
            activeTemplate = {};
            updatePreview();
            if (!id) return;

            fetch('/eletter/letter-templates/get-template/' + id)
                .then(function(r){ return r.json(); })
                .then(function(data){
                    activeTemplate = data;
                    updatePreview();
                })
                .catch(function(){ console.warn('Gagal load templat'); });
        });

        if (selectTemplate.value) {
            selectTemplate.dispatchEvent(new Event('change'));
        }
    }

    ['input-org-name','input-addr1','input-addr2','input-addr3','input-program','input-purpose'].forEach(function(id){
        var el = document.getElementById(id);
        if (el) el.addEventListener('input', updatePreview);
    });

    var selectSignatory = document.getElementById('select-signatory');
    if (selectSignatory) {
        selectSignatory.addEventListener('change', function () {
            var parts = this.value ? this.value.split('|') : [];
            document.getElementById('pv-officer-name').textContent = parts[0] || '[Nama Pegawai]';
            document.getElementById('pv-officer-post').textContent = parts[1] || '[Jawatan Pegawai]';
        });
        selectSignatory.dispatchEvent(new Event('change'));
    }

    updatePreview();
});
</script>