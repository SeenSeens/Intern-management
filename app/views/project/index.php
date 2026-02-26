<div class="wrap">
    <h1 class="wp-heading-inline"><?= esc_html__('Project list', 'tbay_intern') ?></h1>
    <a href="<?= admin_url("admin.php?page=intern-project&action=new") ?>" class="page-title-action"><?= esc_html__('Add new', 'tbay_intern') ?></a>
    <hr class="wp-header-end">
    <table class="wp-list-table widefat fixed striped table-view-list">
        <thead>
            <tr>
                <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Project name', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Creator', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Status', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Start time', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('End time', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Action', 'tbay_intern') ?></strong></th>
            </tr>
        </thead>
        <tbody>
        <?php $index = 0; foreach ($projects as $project): ?>
            <tr>
                <td><?= esc_html( ++$index ) ?></td>
                <td>
                    <?= esc_html($project->name) ?>
                    <div class="row-actions">
                        <span class="edit">
                            <a href="<?= admin_url("admin.php?page=intern-project&action=edit&project_id={$project->id}") ?>"><?= esc_html__('Edit', 'tbay_intern') ?></a> |
                        </span>
                        <span class="trash">
                            <a href="<?= wp_nonce_url(admin_url("admin-post.php?action=delete_project&project_id={$project->id}"), 'delete_project_action') ?>" onclick="return confirm('Xác nhận xoá?')"><?= esc_html__('Delete', 'tbay_intern') ?></a> |
                        </span>
                        <span class="view">
                            <a href="<?= admin_url("admin.php?page=intern-project&action=view&project_id={$project->id}") ?>"><?= esc_html__('View', 'tbay_intern') ?></a>
                        </span>
                    </div>
                </td>
                <td>
                    <?= get_userdata($project->manager_id)->display_name ?? '-' ?>
                </td>
                <td>
                    <?php
                    $status_labels = [
                        'in_progress' => 'Đang triển khai',
                        'waiting' => 'Chờ xử lý',
                        'on_hold' => 'Tạm giữ',
                        'completed' => 'Hoàn thành'
                    ];
                    echo esc_html($status_labels[$project->status] ?? $project->status);
                    ?>
                </td>
                <td><?= esc_html($project->start_date) ?></td>
                <td><?= esc_html($project->end_date) ?></td>
                <td>
                    <a href="<?= admin_url("admin.php?page=intern-project&action=edit&project_id={$project->id}") ?>">Sửa</a> |
                    <a href="<?= wp_nonce_url(admin_url("admin-post.php?action=delete_project&project_id={$project->id}"), 'delete_project_action') ?>" onclick="return confirm('Xác nhận xoá?')">Xoá</a> |
                    <a href="<?= admin_url("admin.php?page=intern-project-user&action=new&id={$project->id}") ?>">Thêm thành viên</a> |
                    <a href="<?= admin_url("admin.php?page=intern-project-user&action=index&id={$project->id}") ?>">Xem thành viên dự án</a> |
                    <a href="<?= admin_url("admin.php?page=intern-project-user&action=edit&project_id={$project->id}") ?>">Chỉnh sửa thành viên</a> |
                    <a href="<?= admin_url("admin.php?page=intern-task&action=new&project_id={$project->id}") ?>">Thêm task</a>
                    <a href="<?= admin_url("admin.php?page=intern-task&project_id={$project->id}") ?>">Xem tất cả task</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
