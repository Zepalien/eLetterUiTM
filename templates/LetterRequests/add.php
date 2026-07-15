<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LetterRequest $letterRequest
 * @var \App\Model\Entity\LetterTemplate[] $templates
 */
?>
<div class="container-fluid my-4 px-4">
    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fa-solid fa-file-pen me-2 text-primary"></i>Permohonan Surat Sokongan
                    </h5>
                    <?= $this->Html->link(
                        '<i class="fa-solid fa-arrow-left me-1"></i> Kembali',
                        ['action' => 'index'],
                        ['class' => 'btn btn-light btn-sm rounded-pill text-secondary border', 'escape' => false]
                    ) ?>
                </div>

                <div class="card-body p-4" style="max-height: 80vh; overflow-y: auto;">

                    <div class="d-flex mb-4 border-bottom pb-3">
                        <div class="flex-fill text-center" id="step-indicator-1">
                            <div class="fw-bold small text-primary step-label" style="padding-bottom:6px; border-bottom: 3px solid #0d6efd;">① Pilih Templat</div>
                        </div>
                        <div class="flex-fill text-center" id="step-indicator-2">
                            <div class="fw-bold small text-muted step-label" style="padding-bottom:6px; border-bottom: 3px solid transparent;">② Maklumat</div>
                        </div>
                        <div class="flex-fill text-center" id="step-indicator-3">
                            <div class="fw-bold small text-muted step-label" style="padding-bottom:6px; border-bottom: 3px solid transparent;">③ Semak & Hantar</div>
                        </div>
                    </div>

                    <?= $this->Form->create($letterRequest, ['id' => 'applyForm', 'enctype' => 'multipart/form-data']) ?>

                    <div id="step-1">
                        <div class="mb-3 p-3 bg-light rounded border-start border-primary border-4">
                            <label class="form-label fw-bold text-dark mb-2">
                                <i class="fa-solid fa-file-lines me-2 text-primary"></i>Pilih Jenis Surat
                            </label>
                            <select class="form-select" id="template_selector" name="template_id" required>
                                <option value="">-- Sila Pilih Templat Surat --</option>
                                <?php foreach ($templates as $tpl): ?>
                                    <option value="<?= $tpl->template_id ?>">
                                        <?= h($tpl->title) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div id="template-loading" class="text-center text-muted small py-2" style="display:none;">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                            Memuatkan templat...
                        </div>

                        <div id="template-info-card" class="alert alert-primary border-0 rounded-3 mb-3" style="display:none;">
                            <div class="fw-bold small mb-1"><i class="fa-solid fa-circle-check me-2"></i>Templat dipilih:</div>
                            <div id="template-info-title" class="fw-bold"></div>
                            <div id="template-info-subject" class="small text-muted mt-1"></div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary rounded-pill px-4" id="btn-next-1" disabled>
                                Seterusnya <i class="fa-solid fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div id="step-2" style="display:none;">

                        <div class="mb-4">
                            <h6 class="fw-bold text-purple mb-3">
                                <i class="fa-solid fa-building me-2"></i>Maklumat Organisasi / Syarikat
                            </h6>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Nama Syarikat / Organisasi <span class="text-danger">*</span></label>
                                <?= $this->Form->control('organization_name', [
                                    'id' => 'input_org', 'label' => false,
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'Cth: Sime Darby Berhad', 'required' => true,
                                ]) ?>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Alamat Baris 1 <span class="text-danger">*</span></label>
                                <?= $this->Form->control('address1', [
                                    'id' => 'input_addr1', 'label' => false,
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'No. 12, Jalan Contoh', 'required' => true,
                                ]) ?>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <?= $this->Form->control('address2', [
                                        'id' => 'input_addr2', 'label' => false,
                                        'class' => 'form-control form-control-sm',
                                        'placeholder' => 'Taman / Kawasan',
                                    ]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('address3', [
                                        'id' => 'input_addr3', 'label' => false,
                                        'class' => 'form-control form-control-sm',
                                        'placeholder' => '40150 Shah Alam, Selangor',
                                    ]) ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="fw-bold text-purple mb-3">
                                <i class="fa-solid fa-flask me-2"></i>Maklumat Kajian / Tujuan
                            </h6>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Tujuan / Tajuk Kajian <span class="text-danger">*</span></label>
                                <?= $this->Form->control('purpose', [
                                    'id' => 'input_purpose', 'label' => false,
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'Cth: Kajian Kepuasan Pelanggan', 'required' => true,
                                ]) ?>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Kaedah Kajian <span class="text-danger">*</span></label>
                                <?= $this->Form->control('method', [
                                    'id' => 'input_method', 'label' => false, 'type' => 'select',
                                    'class' => 'form-select form-select-sm',
                                    'options' => [
                                        'interview'          => 'Temubual (Interview)',
                                        'survey'             => 'Soal Selidik (Survey)',
                                        'documents_from_org' => 'Dokumen dari Organisasi',
                                    ],
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Tarikh Kajian <span class="text-danger">*</span></label>
                                <?= $this->Form->control('date', [
                                    'id' => 'input_date', 'label' => false, 'type' => 'date',
                                    'class' => 'form-control form-control-sm', 'required' => true
                                ]) ?>
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Masa Kajian <span class="text-danger">*</span></label>
                                <?= $this->Form->control('time', [
                                    'id' => 'input_time', 'label' => false, 'type' => 'time',
                                    'class' => 'form-control form-control-sm', 'required' => true
                                ]) ?>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Program Pengajian</label>
                                <?= $this->Form->control('program_name', [
                                    'id' => 'input_program', 'label' => false,
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => 'Cth: CS220 - Sarjana Muda Sains Komputer',
                                ]) ?>
                            </div>
                            <div class="mb-2">
                                <label class="form-label text-secondary small fw-bold">Sebab / Huraian Tambahan</label>
                                <?= $this->Form->control('reason', [
                                    'id' => 'input_reason', 'label' => false, 'type' => 'textarea',
                                    'class' => 'form-control form-control-sm', 'rows' => 2,
                                    'placeholder' => 'Terangkan keperluan kajian anda secara ringkas...',
                                ]) ?>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="fw-bold text-purple mb-3">
                                <i class="fa-solid fa-users me-2"></i>Ahli Kumpulan
                            </h6>
                            <p class="text-muted small mb-2">Format: <code>Nama Penuh | No. Pelajar | No. Telefon</code> — satu baris satu ahli</p>
                            <textarea class="form-control form-control-sm" id="input_members" name="group_members" rows="4"
                                placeholder="Ahmad bin Ali | 2022123456 | 012345678910&#10;Siti binti Omar | 2022123457 | 0198765432"></textarea>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="fw-bold text-purple mb-3">
                                <i class="fa-solid fa-paperclip me-2"></i>Dokumen Sokongan (Pilihan)
                            </h6>
                            <?= $this->Form->control('supporting_document', [
                                'type' => 'file', 'label' => false,
                                'class' => 'form-control form-control-sm',
                                'accept' => '.pdf,.jpg,.jpeg,.png',
                            ]) ?>
                            <small class="text-muted">Format diterima: PDF, JPG, PNG (maks. 5MB)</small>
                        </div>

                        <?= $this->Form->hidden('status', ['value' => 'Pending']) ?>
                        <?= $this->Form->hidden('admin_id', ['value' => null]) ?>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <button type="button" class="btn btn-light rounded-pill border px-4" id="btn-back-2">
                                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary rounded-pill px-4" id="btn-next-2">
                                Semak Permohonan <i class="fa-solid fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div id="step-3" style="display:none;">
                        <div class="alert alert-info border-0 rounded-3 mb-3">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            Sila semak maklumat di panel pratonton sebelum menghantar.
                            Permohonan yang dihantar akan disemak oleh pensyarah.
                        </div>

                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="row g-2 small">
                                <div class="col-5 text-muted">Templat Surat:</div>
                                <div class="col-7 fw-bold" id="sum-template">—</div>
                                <div class="col-5 text-muted">Organisasi:</div>
                                <div class="col-7 fw-bold" id="sum-org">—</div>
                                <div class="col-5 text-muted">Tujuan Kajian:</div>
                                <div class="col-7 fw-bold" id="sum-purpose">—</div>
                                <div class="col-5 text-muted">Kaedah:</div>
                                <div class="col-7 fw-bold" id="sum-method">—</div>
                                <div class="col-5 text-muted">Status:</div>
                                <div class="col-7">
                                    <span class="badge bg-warning text-dark">Menunggu Kelulusan</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <button type="button" class="btn btn-light rounded-pill border px-4" id="btn-back-3">
                                <i class="fa-solid fa-arrow-left me-1"></i> Edit Semula
                            </button>
                            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                                <i class="fa-solid fa-paper-plane me-2"></i>Hantar Permohonan
                            </button>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 small fw-bold text-uppercase">
                        <i class="fa-solid me-2 text-info"></i>Pratonton Surat — Langsung
                    </h5>
                </div>
                <div class="card-body p-4 bg-white letter-preview-container"
                    style="max-height: 80vh; overflow-y: auto; font-family: 'Arial', sans-serif; color: #000; font-size: 13px; line-height: 1.6;">

                    <div class="mb-3 text-center">
                        <img src="<?= $this->Url->image('lh.jpeg') ?>" alt="Letter Head" class="img-fluid w-100">
                    </div>

                    <div class="px-3">
                        <div class="d-flex justify-content-end mb-4">
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

                        <div class="mb-3 fw-bold" id="pv_recipient">
                            <div class="text-secondary opacity-75">{NAMA_SYARIKAT}</div>
                            <div class="text-muted fw-normal small">{ALAMAT_1}</div>
                            <div class="text-muted fw-normal small">{ALAMAT_2}</div>
                        </div>

                        <div class="mb-3">Tuan/Puan,</div>

                        <div class="mb-4 fw-bold text-uppercase text-decoration-underline" id="pv_subject">
                            [TAJUK SURAT]
                        </div>

                        <div class="mb-3 text-justify" id="pv_p1" style="white-space: pre-line;">[Perenggan 1]</div>
                        <div class="mb-3 text-justify" id="pv_p2" style="white-space: pre-line;">[Perenggan 2]</div>

                        <div class="mb-3">
                            <table class="table table-bordered table-sm w-100" style="border-color:#000 !important; font-size:12px;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border:1px solid #000 !important;" width="10%">Bil</th>
                                        <th style="border:1px solid #000 !important;" width="40%">Nama Pelajar</th>
                                        <th style="border:1px solid #000 !important;" width="25%">No. Pelajar</th>
                                        <th style="border:1px solid #000 !important;" width="25%">No. Telefon</th>
                                    </tr>
                                </thead>
                                <tbody id="pv_members_table">
                                    <tr>
                                        <td style="border:1px solid #000 !important;">1</td>
                                        <td style="border:1px solid #000 !important;" class="text-muted font-monospace">{NAMA_PELAJAR}</td>
                                        <td style="border:1px solid #000 !important;" class="text-muted font-monospace">{NO_PELAJAR}</td>
                                        <td style="border:1px solid #000 !important;" class="text-muted font-monospace">{NO_TEL}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-4 text-justify" id="pv_p3" style="white-space: pre-line;">[Perenggan 3]</div>

                        <div class="mb-4">
                            Sekian, terima kasih.<br><br>
                            <strong>"MALAYSIA MADANI"</strong><br>
                            <strong>"BERKHIDMAT UNTUK NEGARA"</strong>
                        </div>

                        <div class="mb-4">Saya yang menjalankan amanah,</div>

                        <div class="mt-5 pt-2 mb-5">
                            <div class="fw-bold text-uppercase" id="pv_lecturer_name">[NAMA PENSYARAH]</div>
                            <div class="text-muted small lh-1" id="pv_lecturer_role">Pensyarah Kanan</div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <img src="<?= $this->Url->image('lf.jpeg') ?>" alt="Letter Footer" class="img-fluid w-100"
                             onerror="this.style.display='none'">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    window.activeTemplate = {};

    function fillPlaceholders(text) {
        if (!text) return '';
        var org  = $('#input_org').val()     || '{COMPANY_NAME}';
        var a1   = $('#input_addr1').val()   || '{ADDRESS_1}';
        var a2   = $('#input_addr2').val()   || '{ADDRESS_2}';
        var a3   = $('#input_addr3').val()   || '{ADDRESS_3}';
        var purp = $('#input_purpose').val() || '{PURPOSE}';
        var prog = $('#input_program').val() || '{PROGRAM_NAME}';
        
        var methodText = $('#input_method option:selected').text() || '{METHOD}';
        var rawDate    = $('#input_date').val() || '{DATE}';
        var rawTime    = $('#input_time').val() || '{TIME}';

        return text
            .replace(/\{COMPANY_NAME\}/g,  org)
            .replace(/\{ADDRESS_1\}/g,     a1)
            .replace(/\{ADDRESS_2\}/g,     a2)
            .replace(/\{ADDRESS_3\}/g,     a3)
            .replace(/\{PURPOSE\}/g,       purp)
            .replace(/\{PROGRAM_NAME\}/g,  prog)
            .replace(/\{METHOD\}/g,        methodText)
            .replace(/\{DATE\}/g,          rawDate)
            .replace(/\{TIME\}/g,          rawTime);
    }

    function updatePreview() {
        var tpl = window.activeTemplate || {};

        var org = $('#input_org').val()   || '{NAMA_SYARIKAT}';
        var a1  = $('#input_addr1').val() || '{ALAMAT_1}';
        var a2  = [$('#input_addr2').val(), $('#input_addr3').val()]
                    .filter(Boolean).join(', ') || '{ALAMAT_2}';

        $('#pv_recipient').html(
            '<div class="fw-bold">' + org + '</div>' +
            '<div class="fw-normal small text-muted">' + a1 + '</div>' +
            '<div class="fw-normal small text-muted">' + a2 + '</div>'
        );

        $('#pv_subject').text(fillPlaceholders(tpl.subject_line || '[TAJUK SURAT]'));
        $('#pv_p1').text(fillPlaceholders(tpl.paragraph_1      || '[Perenggan 1]'));
        $('#pv_p2').text(fillPlaceholders(tpl.paragraph_2      || '[Perenggan 2]'));
        $('#pv_p3').text(fillPlaceholders(tpl.paragraph_3      || '[Perenggan 3]'));
        $('#pv_lecturer_name').text(tpl.signatory_name         || '[NAMA PENSYARAH]');
        $('#pv_lecturer_role').text(tpl.signatory_role         || 'Pensyarah Kanan');

        var rawMembers = $('#input_members').val().trim();
        if (rawMembers) {
            var rows = rawMembers.split('\n').filter(Boolean).map(function (line, i) {
                var parts = line.split('|');
                var name  = (parts[0] || '').trim() || '—';
                var id    = (parts[1] || '').trim() || '—';
                var phone = (parts[2] || '').trim() || '—';
                return '<tr>' +
                    '<td style="border:1px solid #000 !important;">' + (i + 1) + '</td>' +
                    '<td style="border:1px solid #000 !important;">' + name + '</td>' +
                    '<td style="border:1px solid #000 !important;">' + id   + '</td>' +
                    '<td style="border:1px solid #000 !important;">' + phone  + '</td>' +
                '</tr>';
            });
            $('#pv_members_table').html(rows.join(''));
        } else {
            $('#pv_members_table').html(
                '<tr>' +
                '<td style="border:1px solid #000 !important;">1</td>' +
                '<td style="border:1px solid #000 !important;" class="text-muted font-monospace">{NAMA_PELAJAR}</td>' +
                '<td style="border:1px solid #000 !important;" class="text-muted font-monospace">{NO_PELAJAR}</td>' +
                '<td style="border:1px solid #000 !important;" class="text-muted font-monospace">{NO_TEL}</td>' +
                '</tr>'
            );
        }
    }

    // AJAX: load template dari DB
    $('#template_selector').on('change', function () {
        var id    = $(this).val();
        var title = $(this).find('option:selected').text().trim();

        window.activeTemplate = {};
        $('#template-info-card').hide();
        $('#btn-next-1').prop('disabled', true);
        updatePreview();

        if (!id) return;

        $('#template-loading').show();

        $.ajax({
            url: '/eletter/letter-templates/get-template/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                window.activeTemplate = data;
                $('#template-info-title').text(title);
                $('#template-info-subject').text(data.subject_line || '(Tiada subjek ditetapkan)');
                $('#template-info-card').show();
                $('#btn-next-1').prop('disabled', false);
                updatePreview();
            },
            error: function () {
                alert('Gagal memuatkan templat. Sila cuba lagi atau hubungi admin.');
            },
            complete: function () {
                $('#template-loading').hide();
            }
        });
    });

    // Step navigation
    function setStep(n) {
        $('#step-1, #step-2, #step-3').hide();
        $('#step-' + n).show();
        [1, 2, 3].forEach(function (i) {
            var $div = $('#step-indicator-' + i + ' .step-label');
            $div.removeClass('text-primary text-success text-muted');
            $div.css('border-bottom-color', 'transparent');
            if (i < n) {
                $div.addClass('text-success').css('border-bottom-color', '#198754');
            } else if (i === n) {
                $div.addClass('text-primary').css('border-bottom-color', '#0d6efd');
            } else {
                $div.addClass('text-muted');
            }
        });
    }

    $('#btn-next-1').on('click', function () {
        if (!$('#template_selector').val()) {
            alert('Sila pilih templat surat terlebih dahulu.');
            return;
        }
        setStep(2);
    });

    $('#btn-back-2').on('click', function () { setStep(1); });

    $('#btn-next-2').on('click', function () {
        if (!$('#input_org').val() || !$('#input_addr1').val() || !$('#input_purpose').val()) {
            alert('Sila lengkapkan maklumat yang wajib diisi (*).');
            return;
        }
        $('#sum-template').text($('#template_selector option:selected').text());
        $('#sum-org').text($('#input_org').val());
        $('#sum-purpose').text($('#input_purpose').val());
        $('#sum-method').text($('#input_method option:selected').text());
        setStep(3);
    });

    $('#btn-back-3').on('click', function () { setStep(2); });

    $(document).on('input change', '#step-2 input, #step-2 textarea, #step-2 select', function () {
        updatePreview();
    });

    setStep(1);
    updatePreview();
});
</script>

<style>
.text-purple { color: #6f42c1; }
.step-label  { transition: border-color 0.2s, color 0.2s; }
.letter-preview-container table td,
.letter-preview-container table th { padding: 5px 8px; border: 1px solid #000 !important; }
</style>