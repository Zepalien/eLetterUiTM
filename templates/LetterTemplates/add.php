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
                        <i class="fa-solid fa-file-circle-plus me-2 text-primary"></i>Tambah Templat Surat Baru
                    </h5>
                    <?= $this->Html->link(__('<i class="fa-solid fa-arrow-left me-1"></i> Kembali'), ['action' => 'index'], ['class' => 'btn btn-light btn-sm rounded-pill text-secondary border', 'escape' => false]) ?>
                </div>
                <div class="card-body p-4" style="max-height: 80vh; overflow-y: auto;">
                    <?= $this->Form->create($letterTemplate, ['id' => 'templateForm']) ?>
                    
                    <div class="mb-4 p-3 bg-light rounded border-start border-primary border-4">
                        <label class="form-label fw-bold text-dark"><i class="fa-solid fa-signature me-2 text-primary"></i>Tajuk / Nama Templat Surat</label>
                        <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control', 'id' => 'input_title', 'placeholder' => 'Contoh: Surat Pelepasan Kuliah']) ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-building me-2"></i>Maklumat Penerima (Syarikat)</h6>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Name / Company Name</label>
                                <input type="text" class="form-control form-control-sm text-muted bg-light border-dashed" value="{COMPANY_NAME}" readonly style="border-style: dashed;">
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Address (Syarikat)</label>
                                <input type="text" class="form-control form-control-sm mb-1 text-muted bg-light border-dashed" value="{ADDRESS_1}" readonly style="border-style: dashed;">
                                <input type="text" class="form-control form-control-sm mb-1 text-muted bg-light border-dashed" value="{ADDRESS_2}" readonly style="border-style: dashed;">
                                <input type="text" class="form-control form-control-sm text-muted bg-light border-dashed" value="{ADDRESS_3}" readonly style="border-style: dashed;">
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-heading me-2"></i>Tajuk Surat</h6>
                            <label class="form-label text-secondary small fw-bold">Title / Subject Line</label>
                            <?= $this->Form->control('subject_line', ['id' => 'input_subject', 'label' => false, 'class' => 'form-control form-control-sm', 'placeholder' => 'Contoh: PERMOHONAN KEBENARAN MENJALANKAN KAJIAN']) ?>
                        </div>

                        <hr>

                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-graduation-cap me-2"></i>Student Details</h6>
                            <div class="row g-2">
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm text-muted bg-light border-dashed" value="{STUDENT_NAME}" readonly style="border-style: dashed;">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm text-muted bg-light border-dashed" value="{STUDENT_ID}" readonly style="border-style: dashed;">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-paragraph me-2"></i>Kandungan Perenggan Surat</h6>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Paragraph 1 (Perenggan Pengenalan)</label>
                                <?= $this->Form->control('paragraph_1', ['id' => 'input_p1', 'type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => '3']) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Paragraph 2 (Isi Kandungan / Kursus)</label>
                                <?= $this->Form->control('paragraph_2', ['id' => 'input_p2', 'type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => '4']) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Paragraph 3 (Tujuan Kajian & Penutup)</label>
                                <?= $this->Form->control('paragraph_3', ['id' => 'input_p3', 'type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => '3']) ?>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa-solid fa-user-tie me-2"></i>Lecturer Details (Penandatangan)</h6>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Nama Pensyarah / Pegawai</label>
                                <?= $this->Form->control('signatory_name', ['id' => 'input_lecturer_name', 'label' => false, 'class' => 'form-control form-control-sm']) ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Pilihan Skop Jawatan UiTM</label>
                                <?= $this->Form->control('signatory_role', [
                                    'id' => 'input_lecturer_role',
                                    'label' => false, 'type' => 'select', 'class' => 'form-select form-select-sm',
                                    'options' => [
                                        'Pensyarah Kanan' => 'Pensyarah Kanan',
                                        'Koordinator Program' => 'Koordinator Program',
                                        'Ketua Pusat Pengajian' => 'Ketua Pusat Pengajian',
                                        'b/p Dekan Fakulti' => 'b/p Dekan Fakulti'
                                    ]
                                ]) ?>
                            </div>
                            <div class="mb-3" style="display:none;">
                                <?= $this->Form->control('created_by', ['value' => 1]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <?= $this->Html->link(__('Batal'), ['action' => 'index'], ['class' => 'btn btn-light px-4 rounded-pill border']) ?>
                        <?= $this->Form->button(__('Simpan Templat'), ['class' => 'btn btn-primary px-4 rounded-pill shadow-sm fw-bold']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 small fw-bold text-uppercase tracking-wider">
                        <i class="fa-solid fa-eye me-2 text-info"></i>Official Letter Live Preview
                    </h5>
                </div>
                <div class="card-body p-4 bg-white letter-preview-container" style="max-height: 80vh; overflow-y: auto; font-family: 'Arial', sans-serif; color: #000; font-size: 13px; line-height: 1.6; position: relative;">
                    
                    <div class="mb-3 text-center">
                        <?= $this->Html->image('lh.jpeg', ['alt' => 'Letter Head', 'class' => 'img-fluid w-100']) ?>
                    </div>

                    <div class="px-3">
                        <div class="d-flex justify-content-between mb-4 text-dark" style="font-size: 12px;">
                            <div>Ruj. Kami: UiTM/FSKM/2026/(Baru)</div>
                            <div>Tarikh: <?= date('d F Y') ?></div>
                        </div>

                        <div class="mb-3 fw-bold">
                            <div class="text-secondary opacity-75">{COMPANY_NAME}</div>
                            <div class="text-muted fw-normal small">{ADDRESS_1}</div>
                            <div class="text-muted fw-normal small">{ADDRESS_2}</div>
                        </div>

                        <div class="mb-3">Tuan/Puan,</div>

                        <div class="mb-4 fw-bold text-uppercase text-decoration-underline" id="view_subject">[SUBJEK SURAT]</div>

                        <div class="mb-3 text-justify" id="view_p1" style="white-space: pre-line;">[Perenggan 1]</div>
                        <div class="mb-3 text-justify" id="view_p2" style="white-space: pre-line;">[Perenggan 2]</div>

                        <div class="mb-3">
                            <table class="table table-bordered table-sm w-100" style="border-color: #000 !important; font-size: 12px;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border: 1px solid #000 !important;" width="10%">Bil</th>
                                        <th style="border: 1px solid #000 !important;" width="60%">Nama Pelajar</th>
                                        <th style="border: 1px solid #000 !important;" width="30%">No. Pelajar</th>
                                        <th style="border: 1px solid #000 !important;" width="30%">No. Telefon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border: 1px solid #000 !important;">1</td>
                                        <td style="border: 1px solid #000 !important;" class="text-muted font-monospace">{STUDENT_NAME}</td>
                                        <td style="border: 1px solid #000 !important;" class="text-muted font-monospace">{STUDENT_ID}</td>
                                        <td style="border: 1px solid #000 !important;" class="text-muted font-monospace">{PHONE_NUMBER}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-4 text-justify" id="view_p3" style="white-space: pre-line;">[Perenggan 3]</div>

                        <div class="mb-4">
                            Sekian, terima kasih.<br><br>
                            <strong>"MALAYSIA MADANI"</strong><br>
                            <strong>"BERKHIDMAT UNTUK NEGARA"</strong>
                        </div>
                        
                        <div class="mb-4">Saya yang menjalankan amanah,</div>
                        
                        <div class="mt-5 pt-2 mb-5">
                            <div class="fw-bold text-uppercase" id="view_lecturer_name">[NAMA PENSYARAH]</div>
                            <div class="text-muted small lh-1" id="view_lecturer_role">Pensyarah Kanan</div>
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
        $('#view_subject').text($('#input_subject').val() || '[SUBJEK SURAT]');
        $('#view_p1').text($('#input_p1').val() || '[Perenggan 1]');
        $('#view_p2').text($('#input_p2').val() || '[Perenggan 2]');
        $('#view_p3').text($('#input_p3').val() || '[Perenggan 3]');
        $('#view_lecturer_name').text($('#input_lecturer_name').val() || '[NAMA PENSYARAH]');
        $('#view_lecturer_role').text($('#input_lecturer_role').val());
    }
    $(document).on('input change', 'input, textarea, select', function() { updatePreview(); });
    updatePreview();
});
</script>
<style>
.text-purple { color: #6f42c1; }
.border-dashed { border-style: dashed !important; background-color: #f8f9fa !important; color: #6c757d !important; }
.letter-preview-container table td, .letter-preview-container table th { padding: 5px 8px; border: 1px solid #000 !important; }
</style>