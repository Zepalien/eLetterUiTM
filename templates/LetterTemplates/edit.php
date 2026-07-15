<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LetterTemplate $letterTemplate
 */
?>
<div class="container-fluid my-4 px-4">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fa-solid fa-file-pen me-2 text-warning"></i>Kemaskini Templat Surat
                    </h5>
                    <div class="d-flex gap-2">
                        <?= $this->Form->postLink(
                            __('<i class="fa-solid fa-trash me-1"></i> Padam'),
                            ['action' => 'delete', $letterTemplate->id],
                            ['confirm' => __('Adakah anda pasti mahu memadam templat ini?'), 'class' => 'btn btn-outline-danger btn-sm rounded-pill', 'escape' => false]
                        ) ?>
                        <?= $this->Html->link(__('<i class="fa-solid fa-arrow-left me-1"></i> Kembali'), ['action' => 'index'], ['class' => 'btn btn-light btn-sm rounded-pill text-secondary border', 'escape' => false]) ?>
                    </div>
                </div>
                <div class="card-body p-4" style="max-height: 80vh; overflow-y: auto;">
                    <?= $this->Form->create($letterTemplate, ['id' => 'templateForm']) ?>
                    
                    <div class="mb-4 p-3 bg-light rounded border-start border-warning border-4">
                        <label class="form-label fw-bold text-dark">Tajuk / Nama Templat Surat</label>
                        <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control', 'id' => 'input_title']) ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-building me-2"></i>Maklumat Penerima (Syarikat)</h6>
                            <input type="text" class="form-control form-control-sm text-muted bg-light border-dashed mb-2" value="{COMPANY_NAME}" readonly style="border-style: dashed;">
                            <input type="text" class="form-control form-control-sm text-muted bg-light border-dashed" value="{ADDRESS_1}" readonly style="border-style: dashed;">
                        </div>

                        <hr>

                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-heading me-2"></i>Tajuk Surat</h6>
                            <?= $this->Form->control('subject_line', ['id' => 'input_subject', 'label' => false, 'class' => 'form-control form-control-sm']) ?>
                        </div>

                        <hr>

                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-paragraph me-2"></i>Kandungan Perenggan Surat</h6>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Paragraph 1</label>
                                <?= $this->Form->control('paragraph_1', ['id' => 'input_p1', 'type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => '3']) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Paragraph 2</label>
                                <?= $this->Form->control('paragraph_2', ['id' => 'input_p2', 'type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => '4']) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Paragraph 3</label>
                                <?= $this->Form->control('paragraph_3', ['id' => 'input_p3', 'type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => '3']) ?>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-user-tie me-2"></i>Lecturer Details</h6>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Nama Pensyarah / Pegawai</label>
                                <?= $this->Form->control('signatory_name', ['id' => 'input_lecturer_name', 'label' => false, 'class' => 'form-control form-control-sm']) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Pilihan Skop Jawatan UiTM</label>
                                <?= $this->Form->control('signatory_role', ['id' => 'input_lecturer_role', 'label' => false, 'type' => 'select', 'class' => 'form-select form-select-sm', 'options' => ['Pensyarah Kanan'=>'Pensyarah Kanan', 'Koordinator Program'=>'Koordinator Program', 'Ketua Pusat Pengajian'=>'Ketua Pusat Pengajian', 'b/p Dekan Fakulti'=>'b/p Dekan Fakulti']]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <?= $this->Form->button(__('Kemaskini Templat'), ['class' => 'btn btn-warning text-dark px-4 rounded-pill shadow-sm fw-bold']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 small fw-bold text-uppercase tracking-wider"><i class="fa-solid fa-eye me-2 text-info"></i>Official Letter Live Preview</h5>
                    <span class="badge bg-warning text-dark">ID: <?= h($letterTemplate->id) ?></span>
                </div>
                <div class="card-body p-4 bg-white letter-preview-container" style="max-height: 80vh; overflow-y: auto; font-family: 'Arial', sans-serif; color: #000; font-size: 13px; line-height: 1.6;">
                    
                    <div class="mb-3 text-center">
                        <?= $this->Html->image('lh.jpeg', ['alt' => 'Letter Head', 'class' => 'img-fluid w-100']) ?>
                    </div>

                    <div class="px-3">
                        <div class="d-flex justify-content-between mb-4 text-dark" style="font-size: 12px;">
                            <div>Ruj. Kami: UiTM/FSKM/2026/(<?= h($letterTemplate->id) ?>)</div>
                            <div>Tarikh: <?= date('d F Y') ?></div>
                        </div>
                        <div class="mb-3 fw-bold text-secondary">{COMPANY_NAME}</div>
                        <div class="mb-3">Tuan/Puan,</div>
                        <div class="mb-4 fw-bold text-uppercase text-decoration-underline" id="view_subject"><?= h($letterTemplate->subject_line) ?></div>
                        <div class="mb-3 text-justify" id="view_p1" style="white-space: pre-line;"><?= h($letterTemplate->paragraph_1) ?></div>
                        <div class="mb-3 text-justify" id="view_p2" style="white-space: pre-line;"><?= h($letterTemplate->paragraph_2) ?></div>
                        
                        <div class="mb-3">
                            <table class="table table-bordered table-sm w-100" style="border: 1px solid #000 !important;">
                                <thead><tr><th>Bil</th><th>Nama Pelajar</th><th>No. Pelajar</th></tr></thead>
                                <tbody><tr><td>1</td><td class="text-muted">{STUDENT_NAME}</td><td class="text-muted">{STUDENT_ID}</td></tr></tbody>
                            </table>
                        </div>

                        <div class="mb-4 text-justify" id="view_p3" style="white-space: pre-line;"><?= h($letterTemplate->paragraph_3) ?></div>
                        
                        <div class="mt-5 pt-2 mb-5">
                            <div class="fw-bold text-uppercase" id="view_lecturer_name"><?= h($letterTemplate->signatory_name) ?></div>
                            <div class="text-muted small" id="view_lecturer_role"><?= h($letterTemplate->signatory_role) ?></div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                         <?= $this->Html->image('lf.jpeg', ['alt' => 'Letter Footer', 'class' => 'img-fluid w-100']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function updatePreview() {
        $('#view_subject').text($('#input_subject').val() || '');
        $('#view_p1').text($('#input_p1').val() || '');
        $('#view_p2').text($('#input_p2').val() || '');
        $('#view_p3').text($('#input_p3').val() || '');
        $('#view_lecturer_name').text($('#input_lecturer_name').val() || '');
        $('#view_lecturer_role').text($('#input_lecturer_role').val());
    }
    $(document).on('input change', 'input, textarea, select', function() { updatePreview(); });
    updatePreview();
});
</script>