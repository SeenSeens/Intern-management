<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <title>Hệ thống IMS</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#3b82f6",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .active-nav {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }#sidebar {
             transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
         }
        .sidebar-expanded { width: 16rem; }
        .sidebar-collapsed { width: 5rem; }.sidebar-collapsed .nav-label,
                                           .sidebar-collapsed .logo-text,
                                           .sidebar-collapsed .user-info,
                                           .sidebar-collapsed .section-header {
                                               display: none;
                                           }
        .sidebar-collapsed .nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        .sidebar-collapsed .logo-container {
            justify-content: center;
        }
    </style>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/vue-router@4.6.4/dist/vue-router.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="<?= INTERN_MANAGEMENT_URL . 'assets/frontend/css/ims-style.css' ?>">
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen overflow-hidden">
<div class="flex h-screen" id="app">
    <?php require_once INTERN_MANAGEMENT_PATH . 'template-parts/sidebar.php';  ?>
    <div class="flex-1 flex flex-col min-w-0">
        <?php require_once INTERN_MANAGEMENT_PATH . 'template-parts/header.php';  ?>
        <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-background-light dark:bg-background-dark">
            <div>
                <RouterView />
            </div>
            <?php require_once INTERN_MANAGEMENT_PATH . 'template-parts/footer.php'; ?>
        </main>
    </div>
</div>
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    toggleBtn.addEventListener('click', () => {
        if (sidebar.classList.contains('sidebar-expanded')) {
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
        }
    });
</script>
<script src="<?= INTERN_MANAGEMENT_URL. 'assets/frontend/js/ims-app.js' ?>"></script>
</body>
</html>
