<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LetterTemplate $letterTemplate
 */
?>
<style>
    body { background-color: #f8f9fa; }
    .letter-page {
        background: white; width: 210mm; min-height: 297mm; padding: 15mm 20mm; margin: 20px auto;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08); position: relative; font-family: "Arial", sans-serif; font-size: 11pt; line-height: 1.6; color: #000;
        display: flex; flex-direction: column; justify-content: space-between;
    }
    .letter-contents { padding: 0 10mm; }
    .placeholder-box { background-color: #f3f4f6; color: #374151; padding: 2px 5px; border-radius: 4px; font-family: monospace; font-size: 10pt; border: 1px solid #d1d5db; }
    .action-bar { max-width: 210mm; margin: 20px auto 0 auto; display: flex; gap: 10px; }
    
    /* Memastikan reka bentuk kekal kemas semasa dicetak */
    @media print {
        body { background: none; padding: 0; margin: 0; }
        .letter-page { box-shadow: none; margin: 0; width: 100%; height: 100%; padding: 10mm 15mm; }
        .action-bar { display: none !important; }
    }
</style>

<div class="action-bar d-print-none">
    <?= $this->Html->link(__('← Kembali ke Senarai'), ['action' => 'index'], ['class' => 'btn btn-secondary rounded-pill px-4']) ?>
    <?= $this->Html->link(__('📝 Edit Templat'), ['action' => 'edit', $letterTemplate->template_id], ['class' => 'btn btn-warning text-dark rounded-pill px-4 fw-bold']) ?>
    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4">🖨️ Cetak Surat</button>
</div>

<div class="letter-page">
    <div>
        <div class="text-center mb-4">
           <?= $this->Html->image('lh.jpeg', ['alt' => 'Letter Head', 'class' => 'img-fluid w-100']) ?>
        </div>

        <div class="letter-contents">
            <div class="d-flex justify-content-end font-monospace small mb-4">
                <table>
                    <tr><td>Ruj. Kami</td><td>: UiTM/FSKM/2026/(<?= h($letterTemplate->template_id) ?>)</td></tr>
                    <tr><td>Tarikh</td><td>: <?= date('d F Y') ?></td></tr>
                </table>
            </div>

            <div class="mb-4 fw-bold">
                <span class="placeholder-box">{COMPANY_NAME}</span><br>
                <div class="fw-normal text-muted small mt-1">
                    <span class="placeholder-box">{ADDRESS_1}</span>
                </div>
            </div>

            <div class="mb-3">Tuan/Puan,</div>
            <div class="fw-bold text-uppercase text-decoration-underline mb-4"><?= h($letterTemplate->subject_line) ?></div>
            
            <div class="mb-3 text-justify" style="white-space: pre-line;"><?= h($letterTemplate->paragraph_1) ?></div>
            <div class="mb-3 text-justify" style="white-space: pre-line;"><?= h($letterTemplate->paragraph_2) ?></div>

            <div class="my-4">
                <table class="table table-bordered table-sm w-100" style="border: 1px solid #000 !important;">
                    <thead class="table-light">
                        <tr>
                            <th style="border: 1px solid #000 !important;">Bil</th>
                            <th style="border: 1px solid #000 !important;">Nama Pelajar</th>
                            <th style="border: 1px solid #000 !important;">No. Pelajar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #000 !important;">1</td>
                            <td style="border: 1px solid #000 !important;"><span class="placeholder-box">{STUDENT_NAME}</span></td>
                            <td style="border: 1px solid #000 !important;"><span class="placeholder-box">{STUDENT_ID}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mb-4 text-justify" style="white-space: pre-line;"><?= h($letterTemplate->paragraph_3) ?></div>
            <div class="mb-4">Sekian, terima kasih.<br><br><strong>"MALAYSIA MADANI"</strong><br><strong>"BERKHIDMAT UNTUK NEGARA"</strong></div>

            <div class="mt-5 pt-3">
                <div class="fw-bold text-uppercase"><?= h($letterTemplate->signatory_name) ?></div>
                <div class="text-muted small"><?= h($letterTemplate->signatory_role) ?></div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <?= $this->Html->image('lf.jpeg', ['alt' => 'Letter Footer', 'class' => 'img-fluid w-100']) ?>
</div>