<div class="wrap">
    <h1 class="wp-heading-inline"><?= esc_html__('Task list', 'tbay_intern') ?></h1>
    <a href="" class="page-title-action"><?= esc_html__('Thêm task mới', 'tbay_intern') ?></a>
    <hr class="wp-header-end">
    <h2><?php esc_html__('Danh sách nhiệm vụ trong dự án', 'tbay_intern') ?></h2>
    <table class="widefat fixed striped">
        <thead>
        <tr>
            <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
            <th><strong><?= esc_html__('Task name', 'tbay_intern') ?></strong></th>
            <th><strong><?= esc_html__('Date of creation', 'tbay_intern') ?></strong></th>
            <th><strong><?= esc_html__('End date', 'tbay_intern') ?></strong></th>
            <th><strong><?= esc_html__('Project name', 'tbay_intern') ?></strong></th>
            <th><strong><?= esc_html__('Actions', 'tbay_intern') ?></strong></th>
        </tr>
        </thead>
        <tbody>
        <?php $index = 0; foreach ($tasks as $task): ?>
            <tr>
                <td><?= esc_html( ++$index ) ?></td>
                <td><?= esc_html($task->title) ?></td>
                <td><?= esc_html($task->start_date) ?></td>
                <td><?= esc_html($task->end_date) ?></td>
                <td><?= esc_html($task->name) ?></td>
                <td>
                    <a href="<?= admin_url("admin.php?page=intern-task&action=assigned&task_id={$task->id}&project_id={$task->project_id}") ?>"><?= esc_html__('Assign work', 'tbay_intern') ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
