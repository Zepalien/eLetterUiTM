<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LetterRequest $letterRequest
 */

// Nama fail PDF ikut nama pelajar
$studentName = $letterRequest->hasValue('user') ? $letterRequest->user->full_name : 'Surat_Rasmi';
$pdfFilename = 'Surat_' . preg_replace('/[^A-Za-z0-9_]/', '_', strtoupper($studentName)) . '_' . $letterRequest->id;
?>
<style>
    .view-container { padding: 25px; background-color: #f1f5f9; font-family: 'Segoe UI', system-ui, sans-serif; }
    .action-card { background: #fff; padding: 18px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }

    .btn-action { padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; transition: all 0.2s; }
    .btn-back  { background-color: #64748b; color: white !important; }
    .btn-edit  { background-color: #0284c7; color: white !important; }
    .btn-pdf   { background-color: #10b981; color: white !important; }
    .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-action:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .main-grid { display: grid; grid-template-columns: 1fr 1.3fr; gap: 25px; }
    @media (max-width: 1100px) { .main-grid { grid-template-columns: 1fr; } }

    .meta-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: fit-content; }
    .meta-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .meta-table th, .meta-table td { padding: 12px 10px; text-align: left; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
    .meta-table th { color: #475569; width: 35%; font-weight: 600; }

    .badge { padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: bold; text-transform: uppercase; display: inline-block; }
    .badge-pending  { background-color: #fef3c7; color: #d97706; }
    .badge-approved { background-color: #dcfce7; color: #15803d; }
    .badge-rejected { background-color: #fee2e2; color: #b91c1c; }

    /* Preview panel */
    .letter-preview-outer  { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .letter-preview-header { background: #1e293b; color: white; padding: 14px 20px; }
    .letter-preview-header h5 { margin: 0; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

    .letter-preview-container {
        background: #cbd5e1;
        padding: 20px 15px;
        max-height: 82vh;
        overflow-y: auto;
    }

    /* ====== SURAT A4 — ini yang akan di-capture jadi PDF ====== */
    #official-letter-content {
        background: #fff;
        width: 794px;          /* A4 at 96dpi */
        min-height: 1123px;
        margin: 0 auto;
        padding: 40px 55px;
        font-family: 'Arial', sans-serif;
        font-size: 13px;
        color: #000;
        line-height: 1.6;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        box-sizing: border-box;
    }
    #official-letter-content .lh-img { width: 100%; height: auto; display: block; margin-bottom: 20px; }
    #official-letter-content .lf-img { width: 100%; height: auto; display: block; margin-top: 30px; }
    #official-letter-content .letter-subject { font-weight: bold; text-transform: uppercase; text-decoration: underline; margin-bottom: 14px; }
    #official-letter-content .letter-body { white-space: pre-line; text-align: justify; margin-bottom: 14px; }
    #official-letter-content .student-table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 12.5px; }
    #official-letter-content .student-table th,
    #official-letter-content .student-table td { border: 1px solid #000; padding: 5px 9px; text-align: left; }
    #official-letter-content .student-table th { background-color: #f8fafc; font-weight: bold; }
    #official-letter-content .scope-box { border: 1px solid #000; padding: 8px 10px; margin: 5px 0 18px 0; white-space: pre-line; text-align: justify; }
    #official-letter-content .signoff-slogan { font-weight: bold; margin-bottom: 8px; font-size: 12px; }
</style>

<div class="view-container">

    <!-- Action Buttons -->
    <div class="action-card">
        <?= $this->Html->link(__('← Senarai Rekod'), ['action' => 'index'], ['class' => 'btn-action btn-back']) ?>
        <?= $this->Html->link(__('📝 Kemaskini Draf'), ['action' => 'edit', $letterRequest->id], ['class' => 'btn-action btn-edit']) ?>

        <?php if (strtoupper($letterRequest->status) === 'APPROVED'): ?>
        <button id="btn-download-pdf" class="btn-action btn-pdf"
                data-filename="<?= h($pdfFilename) ?>">
            ⬇️ Muat Turun PDF
        </button>
        <?php endif; ?>
    </div>

    <div class="main-grid">

        <!-- LEFT: Ringkasan -->
        <div class="meta-card">
            <h3 style="margin-top:0; color:#1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">📋 Ringkasan Permohonan</h3>
            <table class="meta-table">
                <tr><th>ID Sistem</th><td><strong>#<?= h($letterRequest->id) ?></strong></td></tr>
                <tr>
                    <th>Pemohon (Pelajar)</th>
                    <td><?= $letterRequest->hasValue('user') ? h($letterRequest->user->full_name) : '<span style="color:#94a3b8;">Tiada Rekod</span>' ?></td>
                </tr>
                <tr>
                    <th>No. Matrik</th>
                    <td><?= $letterRequest->hasValue('user') ? h($letterRequest->user->matrix_id) : '-' ?></td>
                </tr>
                <tr>
                    <th>Jenis Templat</th>
                    <td><?= $letterRequest->hasValue('letter_template') ? h($letterRequest->letter_template->title) : 'Templat Am' ?></td>
                </tr>
                <tr>
                    <th>Status Kelulusan</th>
                    <td>
                        <?php
                            $status = strtoupper($letterRequest->status);
                            $badgeClass = 'badge-pending';
                            if ($status === 'APPROVED') $badgeClass = 'badge-approved';
                            if ($status === 'REJECTED') $badgeClass = 'badge-rejected';
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= h($status) ?></span>
                    </td>
                </tr>
                <tr>
                    <th>Dokumen Sokongan</th>
                    <td>
                        <?php if (isset($letterRequest->supporting_document) && trim($letterRequest->supporting_document) !== ''): ?>
                            <a href="<?= $this->Url->build('/files/' . $letterRequest->supporting_document) ?>" target="_blank" style="color: #10b981; font-weight: bold; text-decoration: underline;">
                                📄 Lihat Lampiran
                            </a>
                        <?php else: ?>
                            <span style="color: #94a3b8; font-style: italic;">Tiada Lampiran</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <?php if (!empty($letterRequest->admin_remarks)): ?>
                <div style="margin-top:20px; padding:15px; background:#f8fafc; border-left:4px solid #4c1d95; border-radius:4px;">
                    <strong style="color:#4c1d95; display:block; margin-bottom:5px;">💬 Catatan Admin:</strong>
                    <p style="margin:0; font-size:13px; color:#475569;"><?= h($letterRequest->admin_remarks) ?></p>
                </div>
            <?php endif; ?>
      
        </div>

        <!-- RIGHT: Preview Surat -->
        <div>
            <h3 style="margin-top:0; color:#1e293b; margin-bottom:15px;">Dokumen Rasmi</h3>
            <div class="letter-preview-outer">
                <div class="letter-preview-header">
                    <h5>
                    Pratonton Surat Rasmi</h5>
                </div>
                <div class="letter-preview-container">

                    <!-- ===== INI SAHAJA YANG AKAN JADI PDF ===== -->
                    <div id="official-letter-content">

                        <!-- Letterhead -->
                        <?= $this->Html->image('lh.jpeg', ['class' => 'lh-img']) ?>

                        <!-- Rujukan & Tarikh -->
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

                        <!-- Penerima -->
                        <div style="margin-bottom:18px;">
                            <strong><?= h($letterRequest->organization_name ?: '[Nama Organisasi]') ?></strong><br>
                            <?php
                                $addrLines = array_filter([
                                    $letterRequest->address1 ?? null,
                                    $letterRequest->address2 ?? null,
                                    $letterRequest->address3 ?? null,
                                ]);
                                foreach ($addrLines as $line):
                            ?>
                                <span style="font-size:12px;"><?= h($line) ?></span><br>
                            <?php endforeach; ?>
                        </div>

                        <div style="margin-bottom:16px;">Tuan/Puan,</div>

                        <!-- Tajuk -->
                        <div class="letter-subject">
                            <?php if ($letterRequest->hasValue('letter_template') && !empty($letterRequest->letter_template->subject_line)): ?>
                                <?= h(strtoupper($letterRequest->letter_template->subject_line)) ?>
                            <?php else: ?>
                                PERMOHONAN KEBENARAN UNTUK MENJALANKAN KAJIAN/PROJEK: <?= h(strtoupper($letterRequest->program_name ?? '')) ?>
                            <?php endif; ?>
                        </div>

                        <!-- Body paragraf dari template -->
                        <?php
                            $org  = $letterRequest->organization_name ?? '';
                            $a1   = $letterRequest->address1 ?? '';
                            $a2   = $letterRequest->address2 ?? '';
                            $a3   = $letterRequest->address3 ?? '';
                            $purp = $letterRequest->purpose ?? '';
                            $prog = $letterRequest->program_name ?? '';

                            function fillPH($text, $org, $a1, $a2, $a3, $purp, $prog) {
                                return strtr($text, [
                                    '{COMPANY_NAME}' => $org, '{ADDRESS_1}' => $a1,
                                    '{ADDRESS_2}'    => $a2,  '{ADDRESS_3}' => $a3,
                                    '{PURPOSE}'      => $purp,'{PROGRAM_NAME}' => $prog,
                                ]);
                            }

                            if ($letterRequest->hasValue('letter_template')):
                                $tpl = $letterRequest->letter_template;
                                if (!empty($tpl->paragraph_1)):
                        ?>
                            <div class="letter-body"><?= h(fillPH($tpl->paragraph_1, $org, $a1, $a2, $a3, $purp, $prog)) ?></div>
                        <?php   endif;
                                if (!empty($tpl->paragraph_2)):
                        ?>
                            <div class="letter-body"><?= h(fillPH($tpl->paragraph_2, $org, $a1, $a2, $a3, $purp, $prog)) ?></div>
                        <?php   endif;
                            else:
                        ?>
                            <div class="letter-body">Dengan hormatnya perkara di atas adalah dirujuk.

2. Adalah dimaklumkan bahawa pihak fakulti menyokong permohonan rasmi yang dikemukakan oleh pelajar kami untuk menjalankan urusan kajian akademik di organisasi pihak tuan.</div>
                        <?php endif; ?>

                        <!-- Jadual Pelajar -->
                        <table class="student-table">
                            <thead>
                                <tr>
                                    <th width="10%">Bil</th>
                                    <th width="55%">Nama Pelajar</th>
                                    <th width="35%">No. Pelajar (Matrik)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $membersRendered = false;
                                    if (!empty($letterRequest->group_members)):
                                        $lines = array_filter(explode("\n", $letterRequest->group_members));
                                        $i = 1;
                                        foreach ($lines as $line):
                                            $parts = explode('|', $line);
                                            $mName = trim($parts[0] ?? '');
                                            $mId   = trim($parts[1] ?? '');
                                            if ($mName || $mId): $membersRendered = true;
                                ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><strong><?= h($mName ?: '—') ?></strong></td>
                                    <td><?= h($mId ?: '—') ?></td>
                                </tr>
                                <?php       endif; endforeach; endif;
                                    if (!$membersRendered): ?>
                                <tr>
                                    <td>1</td>
                                    <td><strong><?= $letterRequest->hasValue('user') ? h($letterRequest->user->full_name) : '—' ?></strong></td>
                                    <td><?= $letterRequest->hasValue('user') ? h($letterRequest->user->matrix_id) : '—' ?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <?php if ($letterRequest->hasValue('letter_template') && !empty($tpl->paragraph_3)): ?>
                            <div class="letter-body" style="margin-top:12px;"><?= h(fillPH($tpl->paragraph_3, $org, $a1, $a2, $a3, $purp, $prog)) ?></div>
                        <?php endif; ?>

                        <!-- Tujuan/Skop -->
                        <?php if (!empty($letterRequest->purpose)): ?>
                            <p style="margin-top:14px;"><strong>Tujuan/Skop Projek:</strong></p>
                            <div class="scope-box"><?= h($letterRequest->purpose) ?></div>
                        <?php endif; ?>

                        <!-- Signoff -->
                        <div style="margin-top:20px; line-height:1.4;">
                            <p>Sekian, terima kasih.</p>
                            <div class="signoff-slogan">"MALAYSIA MADANI"<br>"BERKHIDMAT UNTUK NEGARA"</div>
                            <p>Saya yang menjalankan amanah,</p>
                            <div style="margin:15px 0; height:35px; font-style:italic; color:#888; font-size:12px;">
                                [Dokumen ini ditandatangani secara digital/elektronik]
                            </div>
                            <p style="margin:0;">
                                <strong><?= h($letterRequest->signatory_name ?: (($letterRequest->hasValue('letter_template') && !empty($letterRequest->letter_template->signatory_name)) ? $letterRequest->letter_template->signatory_name : 'PROF. MADYA DR. ASIAH ALIAS')) ?></strong><br>
                                <?= h($letterRequest->signatory_position ?: (($letterRequest->hasValue('letter_template') && !empty($letterRequest->letter_template->signatory_role)) ? $letterRequest->letter_template->signatory_role : 'Dekan')) ?><br>
                                Fakulti Pengurusan Maklumat<br>
                                Universiti Teknologi MARA
                            </p>
                        </div>

                        <!-- Footer letterhead -->
                        <?= $this->Html->image('lf.jpeg', ['class' => 'lf-img']) ?>

                    </div><!-- /#official-letter-content -->

                </div><!-- /.letter-preview-container -->
            </div><!-- /.letter-preview-outer -->
        </div>

    </div>
</div>

<!-- ===== jsPDF + html2canvas CDN ===== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('btn-download-pdf');
    if (!btn) return;

    btn.addEventListener('click', function () {
        var filename  = btn.getAttribute('data-filename') || 'Surat_Rasmi';
        var element   = document.getElementById('official-letter-content');

        // Tunjuk loading state
        btn.disabled    = true;
        btn.textContent = '⏳ Menjana PDF...';

        // Scroll surat ke atas dulu sebelum capture
        element.scrollIntoView();

        html2canvas(element, {
            scale: 2,           // 2x untuk kualiti tinggi
            useCORS: true,      // Benarkan cross-origin image (lh.jpeg, lf.jpeg)
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
            windowWidth: element.scrollWidth,
            width: element.offsetWidth,
            height: element.scrollHeight
        }).then(function (canvas) {

            var { jsPDF } = window.jspdf;
            var pdf = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            var pageW  = pdf.internal.pageSize.getWidth();   // 210mm
            var pageH  = pdf.internal.pageSize.getHeight();  // 297mm
            var imgW   = pageW;
            var imgH   = (canvas.height * pageW) / canvas.width;

            var imgData = canvas.toDataURL('image/jpeg', 0.95);

            // Kalau surat lebih panjang dari 1 page — auto split
            if (imgH <= pageH) {
                pdf.addImage(imgData, 'JPEG', 0, 0, imgW, imgH);
            } else {
                var heightLeft = imgH;
                var position   = 0;
                pdf.addImage(imgData, 'JPEG', 0, position, imgW, imgH);
                heightLeft -= pageH;

                while (heightLeft > 0) {
                    position = heightLeft - imgH;
                    pdf.addPage();
                    pdf.addImage(imgData, 'JPEG', 0, position, imgW, imgH);
                    heightLeft -= pageH;
                }
            }

            pdf.save(filename + '.pdf');

            // Reset butang
            btn.disabled    = false;
            btn.textContent = '⬇️ Muat Turun PDF';

        }).catch(function (err) {
            console.error('PDF error:', err);
            btn.disabled    = false;
            btn.textContent = '⬇️ Muat Turun PDF';
            alert('Gagal menjana PDF. Sila cuba lagi.');
        });
    });
});
</script>