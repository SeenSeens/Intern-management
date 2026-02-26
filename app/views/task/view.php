<div class="wrap">
    <div class="container">
        <h1 class="wp-heading-inline"><?= esc_html__('Mission details: ', 'tbay_intern') ?><strong><?= esc_html($task->title) ?></strong></h1>
        <div class="task-details">
            <h2>Thông tin Nhiệm vụ</h2>
            <div class="detail-item">
                <strong>Tên nhiệm vụ:</strong> <span id="task-title"><?= esc_html($task->title) ?></span>
            </div>
            <div class="detail-item">
                <strong>Mô tả:</strong> <span id="task-description"><?=  wp_kses_post(nl2br($task->description)) ?></span>
            </div>
            <div class="detail-item">
                <strong>Dự án ID:</strong> <span id="project-id"><?= esc_html($task->project_id) ?></span>
            </div>
            <div class="detail-item">
                <strong>Ưu tiên:</strong>
                <span id="task-priority" class="task-priority">
                    <?php
                    $priority_labels = [
                        'low' => 'Thấp',
                        'medium' => 'Trung bình',
                        'high' => 'Cao',
                        'critical' => 'Khẩn cấp',
                    ];
                    echo esc_html($priority_labels[$task->priority] ?? $task->priority);
                    ?>
                </span>
            </div>
            <div class="detail-item">
                <strong>Trạng thái:</strong>
                <span id="task-status" class="task-status">
                     <?php
                     $status_labels = [
                         'pending' => 'Chờ xử lý',
                         'in_progress' => 'Đang thực hiện',
                         'completed' => 'Hoàn thành',
                     ];
                     echo esc_html($status_labels[$task->status] ?? $task->status);
                     ?>
                </span>
            </div>
            <div class="detail-item">
                <strong>Người giao:</strong> <span id="assigned-by-id">
                    <?php
                    $assigned_by_user = get_userdata($task->assigned_by);
                    echo esc_html($assigned_by_user->display_name ?? 'Chưa xác định');
                    ?>
                </span>
            </div>
            <div class="detail-item">
                <strong>Thời gian:</strong>
                Từ: <strong><?= esc_html(date('d/m/Y', strtotime($task->start_date))) ?></strong>
                đến: <strong><?= esc_html(date('d/m/Y', strtotime($task->end_date))) ?></strong>
            </div>
        </div>
        <div class="assigned-interns">
            <h2>Thực tập sinh được giao</h2>
            <?php if (!empty($internsAssignTask)): ?>
                <ul class="intern-list" id="interns-list-container">
                    <?php foreach ($internsAssignTask as $intern): ?>
                    <li class="intern-item">
                        <div class="intern-avatar"><?= esc_html(strtoupper($intern->display_name[0])) ?></div>
                        <div class="intern-info">
                            <strong><?= esc_html($intern->display_name) ?></strong>
                            <span><?= esc_html($intern->user_email) ?></span>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="no-interns">
                    <p>Chưa có thực tập sinh nào được giao cho công việc này.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <div>
        <h2>Bảng subtask</h2>
        <a href="<?= admin_url("admin.php?page=intern-task&action=new-subtask&task_id=". $task->id ) ?>" class="page-title-action"><?= esc_html__('Thêm sub task', 'tbay_intern') ?></a>
        <table class="wp-list-table widefat fixed striped">
            <thead>
            <tr>
                <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Title', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Description', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Status', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Actions', 'tbay_intern') ?></strong></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <p>
        <a href="<?= admin_url('admin.php?page=intern-task&project_id=' . $task->project_id) ?>" class="button">← Quay về danh sách công việc</a>
    </p>
</div>





<style>
    .container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 30px;
        margin: 20px auto;
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    h1 {
        text-align: center;
        width: 100%;
        font-size: 2.2em;
    }
    h2 {
        margin-bottom: 20px;
        border-bottom: 2px solid #ecf0f1;
        padding-bottom: 10px;
        font-size: 1.6em;
        width: 100%;
    }
    .task-details, .assigned-interns {
        flex: 1;
        min-width: 350px;
    }
    .detail-item {
        margin-bottom: 15px;
        line-height: 1.6;
    }
    .detail-item strong {
        display: inline-block;
        width: 120px; /* Adjust as needed for alignment */
    }
    .detail-item span {
        color: #000;
    }
    .task-priority {
        font-weight: bold;
    }
    .task-status {
        font-weight: bold;
    }
    .intern-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .intern-item {
        background-color: #ecf0f1;
        border-left: 5px solid #3498db;
        margin-bottom: 10px;
        padding: 15px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .intern-item:hover {
        background-color: #dde1e2;
        cursor: pointer;
    }
    .intern-avatar {
        width: 40px;
        height: 40px;
        background-color: #3498db;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1em;
        text-transform: uppercase;
    }
    .intern-info {
        flex-grow: 1;
    }
    .intern-info strong {
        display: block;
        color: #2c3e50;
        margin-bottom: 3px;
    }
    .intern-info span {
        font-size: 0.9em;
        color: #666;
    }
    .no-interns {
        text-align: center;
        color: #7f8c8d;
        padding: 20px;
        border: 1px dashed #ccc;
        border-radius: 5px;
    }
</style>