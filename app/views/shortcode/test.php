<div class="intern-task-dashboard">

    <!-- Sidebar -->
    <aside class="task-sidebar">
        <div class="sidebar-header">
            <h2>🎓 Intern Tasks</h2>
        </div>
        <nav class="task-menu">
            <ul>
                <li class="active"><span>📋</span> Tất cả nhiệm vụ</li>
                <li><span>📅</span> Hôm nay</li>
                <li><span>⏰</span> Sắp đến hạn</li>
                <li><span>✅</span> Đã hoàn thành</li>
                <li><span>📁</span> Theo dự án</li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <button class="btn-add-task">＋ Thêm nhiệm vụ</button>
        </div>
    </aside>

    <!-- Main content -->
    <main class="task-main">
        <div class="task-header">
            <div class="task-title">
                <h1>📋 Danh sách nhiệm vụ</h1>
                <span class="task-count">(3 nhiệm vụ)</span>
            </div>
            <div class="task-controls">
                <input type="search" class="task-search" placeholder="Tìm kiếm nhiệm vụ..." />
                <select class="task-filter-status">
                    <option value="all">Tất cả</option>
                    <option value="doing">Đang làm</option>
                    <option value="done">Hoàn thành</option>
                </select>
                <button class="btn-report">📊 Báo cáo</button>
            </div>
        </div>

        <section class="task-groups">
            <div class="task-group">
                <h2 class="group-title">📅 Hôm nay (16/07/2025)</h2>
                <ul class="task-list">
                    <li class="task-item">
                        <div class="task-left">
                            <input type="checkbox" />
                            <div class="task-info">
                                <strong>Gửi báo cáo tuần</strong>
                                <div class="task-meta">Dự án: Website CMS • Hạn: 16/07/2025</div>
                            </div>
                        </div>
                        <div class="task-right">
                            <button class="btn-edit">✏️</button>
                            <button class="btn-delete">🗑️</button>
                        </div>
                    </li>
                    <li class="task-item">
                        <div class="task-left">
                            <input type="checkbox" />
                            <div class="task-info">
                                <strong>Làm giao diện đăng nhập</strong>
                                <div class="task-meta">Dự án: Intern Portal • Hạn: 16/07/2025</div>
                            </div>
                        </div>
                        <div class="task-right">
                            <button class="btn-edit">✏️</button>
                            <button class="btn-delete">🗑️</button>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="task-group">
                <h2 class="group-title">⏳ Sắp đến hạn</h2>
                <ul class="task-list">
                    <li class="task-item">
                        <div class="task-left">
                            <input type="checkbox" />
                            <div class="task-info">
                                <strong>Thiết kế dashboard quản lý</strong>
                                <div class="task-meta">Dự án: Quản lý intern • Hạn: 18/07/2025</div>
                            </div>
                        </div>
                        <div class="task-right">
                            <button class="btn-edit">✏️</button>
                            <button class="btn-delete">🗑️</button>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </main>
</div>

<style>
    body {
        margin: 0;
        font-family: "Segoe UI", sans-serif;
        background: #f8fafc;
        color: #333;
    }

    .intern-task-dashboard {
        display: flex;
        height: 100vh;
    }

    /* Sidebar */
    .task-sidebar {
        width: 250px;
        background: #ffffff;
        border-right: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        padding: 20px;
    }

    .sidebar-header h2 {
        margin: 0 0 20px;
        font-size: 20px;
        color: #0b74de;
    }

    .task-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .task-menu li {
        padding: 10px;
        cursor: pointer;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
    }

    .task-menu li:hover,
    .task-menu li.active {
        background: #e6f0ff;
        color: #0b74de;
    }

    .sidebar-footer {
        margin-top: auto;
        padding-top: 20px;
    }

    .btn-add-task {
        width: 100%;
        padding: 10px;
        background: #0b74de;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    /* Main content */
    .task-main {
        flex: 1;
        padding: 30px;
        overflow-y: auto;
        background: #f9fbfd;
    }

    .task-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .task-title h1 {
        margin: 0;
        font-size: 24px;
    }

    .task-controls {
        display: flex;
        gap: 10px;
    }

    .task-search,
    .task-filter-status {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .btn-report {
        background: #10b981;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
    }

    /* Task group */
    .task-group {
        margin-bottom: 40px;
    }

    .group-title {
        font-size: 18px;
        margin-bottom: 10px;
        color: #555;
    }

    .task-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .task-item {
        background: #ffffff;
        padding: 12px 16px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .task-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .task-info strong {
        font-size: 16px;
    }

    .task-meta {
        font-size: 13px;
        color: #666;
    }

    .task-right button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        margin-left: 6px;
        color: #555;
    }

    .task-right button:hover {
        color: #0b74de;
    }

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.querySelector('.task-search');
        const taskItems = document.querySelectorAll('.task-item');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            taskItems.forEach(item => {
                const title = item.querySelector('strong').innerText.toLowerCase();
                item.style.display = title.includes(keyword) ? 'flex' : 'none';
            });
        });

        // Example add task click
        document.querySelector('.btn-add-task').addEventListener('click', function () {
            alert('Hiện modal tạo nhiệm vụ mới');
        });
    });

</script>