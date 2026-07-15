<?php
/**
 * CakePHP Application Layout Induk (Default)
 * UI Refined Version - Glassmorphism Header/Footer & Clean Admin Profile Pill
 * Ralat Struktur Tag Aside & Kontainer Diperbetulkan
 */

// Ambil data user yang sedang login dari Authentication Component
$currentUser = $this->request->getAttribute('identity');
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?> - UiTM e-Letter Portal</title>
    <?= $this->Html->meta('icon') ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <style>
        body {
            background-color: #f8fafc; /* Latar belakang kelabu lembut premium */
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            margin: 0;
            overflow-x: hidden;
        }

        /* 🏢 SIDEBAR DENGAN GAMBAR + OVERLAY GELAP */
        .app-sidebar {
            width: 260px;
            /* Memanggil gambar dari webroot/img/sidebar.png sesuai kod asal */
            background-image: linear-gradient(rgba(36, 6, 71, 0.85), rgba(156, 39, 176, 0.85)), url('<?= $this->Url->webroot('img/sidebar.png') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); /* Animasi smooth toggle */
        }

        /* Kelas apabila sidebar ditutup/disembunyikan */
        .app-sidebar.collapsed {
            transform: translateX(-260px);
        }

        .sidebar-brand {
            padding: 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-menu {
            padding: 1.5rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .menu-category {
            font-size: 11px;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.6) !important;
            font-weight: 700;
            padding: 0 1.5rem;
            margin-top: 1rem;
            margin-bottom: 0.6rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14.5px;
            border-left: 4px solid transparent;
            margin-bottom: 2px;
        }

        .menu-item i {
            width: 24px;
            font-size: 1.15rem;
            margin-right: 0.8rem;
            opacity: 0.9;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding-left: 1.75rem; /* Efek anjakan bila digeser */
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.18);
            color: #fff;
            font-weight: 600;
            border-left-color: #FFB300; /* Indikator Kuning UiTM */
            box-shadow: inset 3px 0 0 rgba(255,255,255,0.1);
        }

        /* 💻 MAIN CONTAINER */
        .app-container {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .app-container.expanded {
            margin-left: 0;
        }

        /* 👑 HEADER: TRANSMITTAL SEMI-TRANSPARENT (GLASSMORPHISM) */
        .app-header {
            height: 75px;
            background-color: rgba(36, 6, 71, 0.88); 
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Butang Hamburger Emas Kontras */
        .hamburger-btn {
            background: rgba(255, 255, 255, 0.08);
            border: none;
            color: #FFB300;
            font-size: 1.2rem;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 12px;
            transition: all 0.2s ease;
        }
        
        .hamburger-btn:hover {
            background-color: rgba(255, 255, 255, 0.18);
            color: #ffffff;
            transform: scale(1.02);
        }

        /* 👤 FIX KOTAK ADMIN: KAPSUL PROFIL YANG KEMAS & TERATUR */
        .user-profile-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.07);
            padding: 6px 8px 6px 16px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: background 0.2s ease;
        }

        .user-profile-pill:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .user-profile-pill p.user-name {
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
            letter-spacing: 0.2px;
        }

        .user-profile-pill small.user-role {
            color: #FFB300 !important;
            font-size: 10.5px;
            font-weight: 600;
            display: block;
            margin-top: 1px;
        }

        /* Kemasan Saiz Bulatan Avatar */
        .user-avatar {
            width: 36px;
            height: 36px;
            background-color: #FFB300;
            color: #240647;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* 📂 MAIN CONTENT SPACE */
        .app-content {
            padding: 2.5rem 2rem;
            flex: 1;
        }

        /* 🪟 FOOTER */
        .app-footer {
            background-color: rgba(26, 4, 51, 0.92);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 1.2rem 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: rgba(255, 255, 255, 0.65);
            font-size: 13px;
        }

        .app-footer .footer-slogan {
            color: #FFB300 !important;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 0.6px;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(2px);
            z-index: 1030;
        }

        @media (max-width: 992px) {
            .app-sidebar { transform: translateX(-260px); }
            .app-sidebar.active-mobile { transform: translateX(0); }
            .app-container { margin-left: 0 !important; }
            .sidebar-overlay.active-mobile { display: block; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="app-sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-envelope-open-text me-2" style="color: #FFB300;"></i>
                <span class="fw-bold">UiTM e-Letter</span>
            </div>
            <button class="btn p-0 text-white d-lg-none" id="closeSidebarMobile"><i class="fa-solid fa-xmark fs-5"></i></button>
        </div>
        
        <div class="sidebar-menu">
            <?php if (isset($currentUser->role_id) && $currentUser->role_id == 1): ?>
                <div class="menu-category">Main Menu</div>
                <a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'Dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-house"></i> <span>Dashboard</span>
                </a>

                <div class="menu-category">Letter Management</div>
                <a href="<?= $this->Url->build(['controller' => 'LetterRequests', 'action' => 'index']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'LetterRequests' && $this->request->getParam('action') === 'index' ? 'active' : '' ?>">
                    <i class="fa-solid fa-file-invoice"></i> <span>Letter Requests</span>
                </a>
                <a href="<?= $this->Url->build(['controller' => 'LetterTemplates', 'action' => 'index']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'LetterTemplates' ? 'active' : '' ?>">
                    <i class="fa-solid fa-file-lines"></i> <span>Letter Templates</span>
                </a>
            

                <div class="menu-category">Records & Reports</div>
                <a href="<?= $this->Url->build(['controller' => 'Students', 'action' => 'index']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'Students' ? 'active' : '' ?>">
                    <i class="fa-solid fa-users"></i> <span>Student Records</span>
                </a>
                <a href="<?= $this->Url->build(['controller' => 'Reports', 'action' => 'index']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'Reports' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-line"></i> <span>Reports</span>
                </a>

            <?php else: ?>
                <div class="menu-category">Main Menu</div>
                <a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'Dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-house"></i> <span>Dashboard</span>
                </a>

                <div class="menu-category">Services</div>
                <a href="<?= $this->Url->build(['controller' => 'LetterRequests', 'action' => 'add']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'LetterRequests' && $this->request->getParam('action') === 'add' ? 'active' : '' ?>">
                    <i class="fa-solid fa-file-pen"></i> <span>Generate Letter</span>
                </a>
                <a href="<?= $this->Url->build(['controller' => 'LetterRequests', 'action' => 'index']) ?>" 
                   class="menu-item <?= $this->request->getParam('controller') === 'LetterRequests' && $this->request->getParam('action') === 'index' ? 'active' : '' ?>">
                    <i class="fa-solid fa-table-list"></i> <span>My Requests</span>
                </a>
            <?php endif; ?>

            <div class="menu-category mt-4">Account</div>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" class="menu-item fw-semibold" style="background: rgba(220, 53, 69, 0.12);">
                <i class="fa-solid fa-user"></i> <span>Profile</span>
            </a>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="menu-item text-danger fw-semibold" style="background: rgba(220, 53, 69, 0.12);">
                <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
            </a>
        </div>
    </aside>

    <div class="app-container" id="appContainer">
        
        <header class="app-header">
            <div class="d-flex align-items-center">
                <button class="hamburger-btn me-3" id="sidebarToggle" title="Buka/Tutup Menu">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <h5 class="mb-0 fw-bold text-white" style="font-size: 15px; letter-spacing: -0.1px;">UiTM e-Letter Portal v1.0</h5>
            </div>
            
            <div class="user-profile-pill">
                <div class="text-end d-none d-sm-block">
                    <p class="user-name"><?= h($currentUser->matrix_id ?? 'Pengguna') ?></p>
                    <small class="user-role">
                        <?= isset($currentUser->role_id) && $currentUser->role_id == 1 ? 'Administrator' : 'Student' ?>
                    </small>
                </div>
                <div class="user-avatar">
                    <?= strtoupper(substr(h($currentUser->matrix_id ?? 'U'), 0, 1)) ?>
                </div>
            </div>
        </header>

        <main class="app-content">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>

        <footer class="app-footer">
            <span class="fw-medium">&copy; <?= date('Y') ?> Universiti Teknologi MARA. Hak Cipta Terpelihara.</span>
            <span class="footer-slogan text-uppercase d-none d-md-inline">Together Towards Excellence</span>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('appSidebar');
            const container = document.getElementById('appContainer');
            const overlay = document.getElementById('sidebarOverlay');
            const closeMobileBtn = document.getElementById('closeSidebarMobile');

            toggleBtn.addEventListener('click', function () {
                if (window.innerWidth > 992) {
                    sidebar.classList.toggle('collapsed');
                    container.classList.toggle('expanded');
                } else {
                    sidebar.classList.toggle('active-mobile');
                    overlay.classList.toggle('active-mobile');
                }
            });

            function closeMobileSidebar() {
                sidebar.classList.remove('active-mobile');
                overlay.classList.remove('active-mobile');
            }

            if(overlay) overlay.addEventListener('click', closeMobileSidebar);
            if(closeMobileBtn) closeMobileBtn.addEventListener('click', closeMobileSidebar);
        });
    </script>
</body>
</html>