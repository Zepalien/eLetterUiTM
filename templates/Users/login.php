<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - UiTM e-Letter Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            display: flex;
            flex-direction: column; /* Menguruskan susunan banner atas dan kandungan tengah */
            justify-content: space-between;
            overflow: hidden;
            background-color: #210444;
        }

        /* Menggunakan imej latar belakang ungu damask kegemaran awak */
        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?= $this->Url->image('bg.png') ?>');
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        /* 📣 Feature Bar Teks Bergerak di Bahagian Atas */
        .announcement-banner {
            background: rgba(74, 20, 140, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 10px 0;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            z-index: 20;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Kontainer Utama Tengah */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 20px;
        }

        /* Kad Login Frosted Glass Terpusat (Centered) */
        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 3.5rem 2.5rem;
            
            /* Kesan Kaca Lutsinar yang Lembut */
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px; /* Bucu bulat yang elegan */
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            
            z-index: 10;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Rekabentuk Butang Log Masuk */
        .btn-uitm {
            background: linear-gradient(135deg, #4A148C 0%, #320B63 100%);
            color: white;
            border: none;
            border-radius: 8px !important;
            padding-top: 12px;
            padding-bottom: 12px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 20, 140, 0.4);
        }
        .btn-uitm:hover {
            background: linear-gradient(135deg, #320B63 0%, #210444 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 20, 140, 0.6);
        }

        /* Label Input */
        .form-label {
            font-size: 11px;
            letter-spacing: 1px;
            color: #ffffff;
            font-weight: 600;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        /* Input Group Custom */
        .input-group {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        
        .input-group-text {
            background-color: #ffffff;
            border: none;
            color: #4A148C;
            padding-left: 15px;
        }

        .input-group-text i {
            width: 20px;
            text-align: center;
        }
        
        /* Kotak Input Fields */
        .form-control {
            background-color: #ffffff;
            border: none;
            padding-top: 12px;
            padding-bottom: 12px;
            font-size: 14px;
            color: #2b2b2b;
        }
        
        .form-control:focus {
            background-color: #ffffff;
            box-shadow: none;
        }

        /* Dropdown Peranan */
        .form-select {
            background-color: #ffffff !important;
            border: none !important;
            padding-top: 12px;
            padding-bottom: 12px;
            font-size: 13px;
            font-weight: 600;
            color: #4A148C;
            cursor: pointer;
        }
        .form-select:focus {
            box-shadow: none;
        }
        
        /* Tipografi Tajuk Portal */
        .uitm-logo-text {
            color: #ffffff;
            font-size: 30px;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.5);
        }
        
        .uitm-sub-text {
            color: #f1f1f1;
            font-size: 12px;
            font-weight: 400;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.6);
        }

        /* Footer Zon */
        .footer-zone {
            width: 100%;
            padding: 15px 0;
            z-index: 10;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.6) !important;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

<div class="background-overlay"></div>

<div class="announcement-banner">
    <marquee behavior="scroll" direction="left" scrollamount="6">
        <i class="fa-solid fa-circle-info me-2"></i> 
        Selamat Datang ke <strong>UiTM e-Letter Portal (Sistem Pengurusan Surat Rasmi Pelajar)</strong>. 
        Sistem ini dibangunkan untuk memudahkan pelajar memohon, mengemas kini, dan menjana surat rasmi pelepasan kuliah atau aktiviti universiti secara digital. 
        <span class="mx-4">|</span> 
        <i class="fa-solid fa-shield-halved me-2"></i> 
        Sila pastikan anda memilih peranan (Role) yang betul sebelum memasukkan maklumat log masuk anda.
    </marquee>
</div>

<div class="main-container">
    <div class="login-card">
        
        <div class="text-center mb-5">
            <h3 class="fw-bold uitm-logo-text mb-1">UiTM e-Letter</h3>
            <p class="uitm-sub-text small mb-0">Sistem Pengurusan Surat Rasmi Pelajar</p>
        </div>

        <div class="mb-3">
            <?= $this->Flash->render() ?>
        </div>

        <?= $this->Form->create(null, [
            'templates' => [
                'inputContainer' => '{{content}}'
            ]
        ]) ?>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-uppercase">Log Masuk Sebagai</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                    <?= $this->Form->select('role_id', [
                        '1' => 'ADMINISTRATOR',
                        '2' => 'STUDENT'
                    ], [
                        'class' => 'form-select form-control',
                        'empty' => '-- SILA PILIH ROLE --',
                        'required' => true
                    ]) ?>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-uppercase">ID Matrik / Staff ID</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <?= $this->Form->text('matrix_id', [
                        'class' => 'form-control',
                        'placeholder' => 'Contoh: 2026xxxxxx',
                        'required' => true
                    ]) ?>
                </div>
            </div>

            <div class="mb-5">
                <label class="form-label fw-bold text-uppercase">Kata Laluan</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <?= $this->Form->control('password', [
        'type' => 'password',
        'label' => false,
        'class' => 'form-control',
        'placeholder' => '••••••••',
        'required' => true,
        'value' => '' // Memastikan ia tidak diletakkan topeng watak bintang beralas
    ]) ?>
                </div>
            </div>

            <button type="submit" class="btn btn-uitm w-100 py-3 fw-semibold rounded-3 shadow-sm text-uppercase">
                Log Masuk
            </button>
            
        <?= $this->Form->end() ?>
        
    </div>
</div>

<div class="footer-zone text-center">
    <small class="footer-text text-uppercase" style="font-size: 10px; letter-spacing: 1px;">
        Together Towards Excellence
    </small>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>