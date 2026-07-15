<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <?= $this->Flash->render() ?>

            <div class="card shadow-sm">
                <div class="card-header text-center py-3" style="background-color: #5b1a7a; color: white;">
                    <h4 class="mb-0">KEMASKINI PROFIL (<?= $user->role_id == 1 ? 'ADMIN' : 'PELAJAR' ?>)</h4>
                </div>
                
                <div class="card-body p-4">
                    <?= $this->Form->create($user) ?>
                        
                                        <div class="row">
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('matrix_id', [
                            'label' => 'No. Matrik / Staff ID',
                            'class' => 'form-control bg-light',
                            'readonly' => true
                        ]) ?>
                    </div>
                    
                    <?php if ($user->role_id != 1): ?>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('ic_number', [
                                'label' => 'No. Kad Pengenalan',
                                'class' => 'form-control bg-light',
                                'readonly' => true
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </div>

                        <hr>

                        <div class="mb-3">
                            <?= $this->Form->control('full_name', [
                                'label' => 'Nama Penuh',
                                'class' => 'form-control',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="mb-3">
                            <?= $this->Form->control('email', [
                                'label' => 'Alamat Emel',
                                'class' => 'form-control',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <?= $this->Form->control('phone_number', [
                                    'label' => 'No. Telefon',
                                    'class' => 'form-control'
                                ]) ?>
                            </div>
                            
                            <?php if ($user->role_id != 1): ?>
                                <div class="col-md-6 mb-3">
                                    <?= $this->Form->control('program_code', [
                                        'label' => 'Kod Program (cth: CS262)',
                                        'class' => 'form-control'
                                    ]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($user->role_id != 1): ?>
                            <div class="mb-3">
                                <?= $this->Form->control('faculty', [
                                    'label' => 'Fakulti',
                                    'class' => 'form-control'
                                ]) ?>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <?= $this->Form->control('password', [
                                'label' => 'Kata Laluan Baru (Biarkan kosong jika tak mahu ubah)',
                                'class' => 'form-control',
                                'value' => '', // Dikosongkan demi keselamatan supaya teks hash asal database tak bocor
                                'type' => 'password',
                                'required' => false
                            ]) ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <?= $this->Html->link(__('Kembali'), ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'btn btn-secondary me-md-2']) ?>
                            <?= $this->Form->button(__('Simpan Perubahan'), ['class' => 'btn text-white px-4', 'style' => 'background-color: #5b1a7a;']) ?>
                        </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>

        </div>
    </div>
</div>