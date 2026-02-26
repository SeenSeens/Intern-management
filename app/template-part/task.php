<div>
    <h2><?= esc_html__('Tasks for this project', 'tbay_intern') ?></h2>
    <button type="button" id="add-new-task-btn"><?= esc_html__('Add new task', 'tbay_intern') ?></button>
    <a href="<?= admin_url("admin.php?page=intern-task&action=new&project_id={$project->id}") ?>" class="page-title-action"><?= esc_html__('Add new task', 'tbay_intern') ?></a>

    <div id="task-popup" class="popup" style="display: none;">
        <div class="popup-overlay"></div>
        <div class="popup-content">
            <h2><?= esc_html__('Add task to project', 'tbay_intern') ?></h2>
            <form method="post" action="<?= admin_url('admin-post.php') ?>" id="post">
                <input type="hidden" name="action" value="save_project">
                <?php wp_nonce_field('save_project_action'); ?>
                <input type="hidden" name="id" value="<?= esc_attr( $project->id ?? '' ) ?>">

                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content" style="position: relative;">
                            <div id="titlediv">
                                <div id="titlewrap">
                                    <input type="text" name="name" value="<?= esc_attr($project->name ?? '') ?>" id="title" placeholder="<?= esc_html__('Project name', 'tbay_intern') ?>" required>
                                </div>
                            </div>
                            <div id="postdivrich" class="postarea wp-editor-expand" style="padding-top: 55px;">
                                <?php
                                wp_editor(
                                    $project->description ?? '',
                                    'description',
                                    [
                                        'textarea_name' => 'description',
                                        'textarea_rows' => 10,
                                        'media_buttons' => true,
                                    ],
                                );
                                ?>
                            </div>
                        </div>
                        <div id="postbox-container-1" class="postbox-container">
                            <div class="postbox">
                                <div class="postbox-header">
                                    <h2><?= esc_html__('Status','tbay_intern') ?></h2>
                                </div>
                                <div class="inside">
                                    <select name="status" style="width: 100%">
                                        <?php
                                        $statuses = ['waiting' => 'Chờ xử lý', 'in_progress' => 'Đang triển khai', 'on_hold' => 'Tạm hoãn', 'completed' => 'Hoàn thành'];
                                        foreach ($statuses as $key => $label) {
                                            $selected = ($project->status ?? '') === $key ? 'selected' : '';
                                            echo "<option value='{$key}' {$selected}>{$label}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="postbox">
                                <div class="postbox-header">
                                    <h2><?= esc_attr__('Start date', 'tbay_intern') ?></h2>
                                </div>
                                <div class="inside">
                                    <input type="date" name="start_date" id="start_date" style="width: 100%" value="<?= esc_attr($project->start_date ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="postbox">
                                <div class="postbox-header">
                                    <h2><?= esc_attr__('End date', 'tbay_intern') ?></h2>
                                </div>
                                <div class="inside">
                                    <input type="date" name="end_date" id="end_date" style="width: 100%" value="<?= esc_attr($project->end_date ?? '') ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <button type="button" id="close-task-popup" class="button"><?= esc_html__('Close', 'tbay_intern') ?></button>
        </div>
    </div>


    <hr class="wp-header-end">
    <?php if (!empty($tasks)): ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Task Name', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Date of creation', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('End date', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Task recipient', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Actions', 'tbay_intern') ?></strong></th>
                </tr>
            </thead>
            <tbody>
            <?php $index = 0; foreach ($tasks as $task): var_dump($task); ?>
                <tr>
                    <td><?= esc_html( ++$index ) ?></td>
                    <td>
                        <?= esc_html($task->title) ?>
                        <div class="row-actions">
                            <span class="edit">
                                <a href="<?= admin_url("admin.php?page=intern-task&action=edit&task_id={$task->id}") ?>"><?= esc_html__('Edit', 'tbay_intern') ?></a> |
                            </span>
                                <span class="trash">
                                <a href="<?= wp_nonce_url(admin_url("admin-post.php?action=delete_project&task_id={$task->id}"), 'delete_task_action') ?>" onclick="return confirm('Xác nhận xoá?')"><?= esc_html__('Delete', 'tbay_intern') ?></a> |
                            </span>
                                <span class="view">
                                <a href="<?= admin_url("admin.php?page=intern-task&action=view&task_id={$task->id}") ?>"><?= esc_html__('View', 'tbay_intern') ?></a>
                            </span>
                        </div>
                    </td>
                    <td><?= esc_html($task->start_date) ?></td>
                    <td><?= esc_html($task->end_date) ?></td>
                    <td>
                        <?php foreach ($internAssignedByTask[$task->id] as $intern): ?>
                            <?= esc_html($intern->display_name) ?> <br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <button type="button" id="assign-work-btn"><?= esc_html__('Assign work', 'tbay_intern') ?></button>
                        <a href="<?= admin_url("admin.php?page=intern-task&action=assigned&task_id={$task->id}&project_id={$task->project_id}") ?>"><?= esc_html__('Assign work', 'tbay_intern') ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p><?= esc_html__('No tasks have been created for this project.', 'tbay_intern') ?></p>
    <?php endif; ?>
</div>