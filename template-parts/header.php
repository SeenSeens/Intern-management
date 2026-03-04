<!DOCTYPE html>
<html class="light" lang="vi"><head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Quản Lý Thực Tập Sinh - Project List</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#1d4ed8",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                        body: ["Inter", "sans-serif"],
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
        .sidebar-active { border-right: 4px solid #1d4ed8; background: rgba(29, 78, 216, 0.05); }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex">
<aside class="w-64 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex-shrink-0 hidden lg:flex flex-col">
    <div class="p-6">
        <div class="flex items-center gap-2 text-primary font-bold text-xl">
            <span class="material-icons">school</span>
            <span>Intern Manager</span>
        </div>
    </div>
    <nav class="flex-1 px-3 space-y-1">
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group" href="#">
            <span class="material-icons text-slate-400 group-hover:text-primary">dashboard</span>
            <span class="font-medium">Tổng quan</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-primary group sidebar-active" href="#">
            <span class="material-icons">assignment</span>
            <span class="font-medium">Dự án</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group" href="#">
            <span class="material-icons text-slate-400 group-hover:text-primary">people</span>
            <span class="font-medium">Thực tập sinh</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group" href="#">
            <span class="material-icons text-slate-400 group-hover:text-primary">badge</span>
            <span class="font-medium">Mentor</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors group" href="#">
            <span class="material-icons text-slate-400 group-hover:text-primary">task</span>
            <span class="font-medium">Nhiệm vụ</span>
        </a>
    </nav>
    <div class="p-4 border-t border-slate-200 dark:border-slate-800">
        <button class="flex items-center gap-3 px-3 py-2 w-full rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" onclick="document.documentElement.classList.toggle('dark')">
            <span class="material-icons text-slate-400 dark:hidden">dark_mode</span>
            <span class="material-icons text-slate-400 hidden dark:block">light_mode</span>
            <span class="font-medium dark:hidden">Chế độ tối</span>
            <span class="font-medium hidden dark:block">Chế độ sáng</span>
        </button>
    </div>
</aside>
<main class="flex-1 flex flex-col min-w-0">
    <header class="h-16 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex items-center justify-between px-8 sticky top-0 z-10">
        <h1 class="text-xl font-semibold">Danh sách dự án</h1>
        <div class="flex items-center gap-4">
            <div class="relative hidden sm:block">
                <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input class="pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-full text-sm focus:ring-2 focus:ring-primary w-64" placeholder="Tìm kiếm dự án..." type="text"/>
            </div>
            <button class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-sm text-sm font-medium">
                <span class="material-icons text-base">add</span>
                Thêm mới
            </button>
            <div class="h-8 w-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden border border-slate-300 dark:border-slate-600">
                <img alt="Admin Avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOPHioDExZTFq9a1_pCJmzT5gLYbm9xrBXn0WYPqOnAPk7SwQYrr4ffHqiZECpxsFm1QlrMhn2v6OvNxxFEjX9F3jOLs1s-OuSJy8t2tUpxLde-eeb7YEGOKCSRxP2Lzl-9ooyLXVVBCMi_AlA1fcLmnRV6uTUeZPLmtjYnGCQ6G_yZLlRZfd1YJBW2FXl_EnzkdXrmmtRicMTWGcQ7Fb_xJ26eCSt6ihBXXDnQT7fCfq4d4xevazfqkGtpHs9NkD1FzbGGjMpAgI"/>
            </div>
        </div>
    </header>
    <div class="p-8 pb-0">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Tổng dự án</div>
                <div class="text-2xl font-bold">12</div>
            </div>
            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="text-blue-500 dark:text-blue-400 text-xs font-semibold uppercase tracking-wider mb-1">Đang triển khai</div>
                <div class="text-2xl font-bold">5</div>
            </div>
            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="text-amber-500 dark:text-amber-400 text-xs font-semibold uppercase tracking-wider mb-1">Chờ xử lý</div>
                <div class="text-2xl font-bold">3</div>
            </div>
            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="text-emerald-500 dark:text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-1">Đã hoàn thành</div>
                <div class="text-2xl font-bold">4</div>
            </div>
        </div>
    </div>
    <div class="px-8 pb-8 flex-1">
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest w-12">No</th>
                        <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Dự án &amp; Mã</th>
                        <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Người tạo</th>
                        <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Trạng thái</th>
                        <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Bắt đầu</th>
                        <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Kết thúc</th>
                        <th class="px-6 py-2.5 text-[10px] font-semibold text-slate-500 uppercase tracking-widest text-right w-36">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-2.5 text-xs text-slate-500">1</td>
                        <td class="px-6 py-2.5">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-900 dark:text-white text-sm">Xây dựng CRM Intern</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">CRM-01</span>
                            </div>
                        </td>
                        <td class="px-6 py-2.5 text-xs">admin</td>
                        <td class="px-6 py-2.5">
<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    Đang triển khai
                                </span>
                        </td>
                        <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-03</td>
                        <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-17</td>
                        <td class="px-6 py-2.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Thành viên">
                                    <span class="material-icons text-lg">group</span>
                                </button>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Nhiệm vụ">
                                    <span class="material-icons text-lg">assignment_turned_in</span>
                                </button>
                                <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-amber-500 transition-all" title="Sửa">
                                    <span class="material-icons text-lg">edit</span>
                                </button>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xóa">
                                    <span class="material-icons text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-2.5 text-xs text-slate-500">2</td>
                        <td class="px-6 py-2.5">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-900 dark:text-white text-sm">Website Tuyển dụng 2024</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">WEB-HR</span>
                            </div>
                        </td>
                        <td class="px-6 py-2.5 text-xs">admin</td>
                        <td class="px-6 py-2.5">
<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                    Chờ xử lý
                                </span>
                        </td>
                        <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-09</td>
                        <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-25</td>
                        <td class="px-6 py-2.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Thành viên">
                                    <span class="material-icons text-lg">group</span>
                                </button>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Nhiệm vụ">
                                    <span class="material-icons text-lg">assignment_turned_in</span>
                                </button>
                                <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-amber-500 transition-all" title="Sửa">
                                    <span class="material-icons text-lg">edit</span>
                                </button>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xóa">
                                    <span class="material-icons text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-2.5 text-xs text-slate-500">3</td>
                        <td class="px-6 py-2.5">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-900 dark:text-white text-sm">Mobile App Intern Life</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">APP-09</span>
                            </div>
                        </td>
                        <td class="px-6 py-2.5 text-xs">mentor_john</td>
                        <td class="px-6 py-2.5">
<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    Hoàn thành
                                </span>
                        </td>
                        <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-01-15</td>
                        <td class="px-6 py-2.5 text-xs text-slate-600 dark:text-slate-400">2024-02-01</td>
                        <td class="px-6 py-2.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Thành viên">
                                    <span class="material-icons text-lg">group</span>
                                </button>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary transition-all" title="Nhiệm vụ">
                                    <span class="material-icons text-lg">assignment_turned_in</span>
                                </button>
                                <div class="w-px h-4 bg-slate-200 dark:bg-slate-700 mx-1"></div>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-amber-500 transition-all" title="Sửa">
                                    <span class="material-icons text-lg">edit</span>
                                </button>
                                <button class="p-1.5 rounded hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-red-500 transition-all" title="Xóa">
                                    <span class="material-icons text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <span class="text-xs text-slate-500 dark:text-slate-400">Hiển thị 1-3 trong số 12 dự án</span>
                <div class="flex items-center gap-2">
                    <button class="p-1.5 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-white dark:hover:bg-slate-700 disabled:opacity-50" disabled="">
                        <span class="material-icons text-sm">chevron_left</span>
                    </button>
                    <button class="px-2.5 py-1 bg-primary text-white rounded-lg text-xs font-medium">1</button>
                    <button class="px-2.5 py-1 border border-slate-300 dark:border-slate-600 rounded-lg text-xs font-medium hover:bg-white dark:hover:bg-slate-700">2</button>
                    <button class="px-2.5 py-1 border border-slate-300 dark:border-slate-600 rounded-lg text-xs font-medium hover:bg-white dark:hover:bg-slate-700">3</button>
                    <button class="p-1.5 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-white dark:hover:bg-slate-700">
                        <span class="material-icons text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <footer class="p-8 mt-auto border-t border-slate-200 dark:border-slate-800 text-slate-400 text-[10px] flex justify-between items-center">
        <div>
            Cảm ơn bạn đã khởi tạo với <a class="text-primary hover:underline" href="#">WordPress</a>.
        </div>
        <div>Phiên bản 6.9.1</div>
    </footer>
</main>

</body></html>