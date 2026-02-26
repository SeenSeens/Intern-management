<div class="wrap">
    <h1><?= esc_html__('Project Details:', 'tbay_intern') ?> <?= esc_html($project->name ?? '') ?></h1>
    <a href="<?= admin_url("admin.php?page=intern-project&action=edit&project_id={$project->id}") ?>" class="page-title-action"><?= esc_html__('Edit', 'tbay_intern') ?></a>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- Cột trái: Thông tin dự án -->
            <div id="post-body-content">
                <div class="postbox">
                    <h2><?= esc_html__('Project information', 'tbay_intern') ?></h2>
                    <div class="inside">
                        <table class="form-table">
                            <tbody>
                            <tr>
                                <th scope="row"><?= esc_html__('Project name:', 'tbay_intern') ?></th>
                                <td><?= esc_html($project->name) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= esc_html__('Describe:', 'tbay_intern') ?></th>
                                <td><?= esc_html($project->description) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= esc_html__('Project Manager:', 'tbay_intern') ?></th>
                                <td><?= get_userdata($project->manager_id)->display_name ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= esc_html__('Status:', 'tbay_intern') ?></th>
                                <td>
                                    <code>
                                        <?php
                                        $status_labels = [
                                            'in_progress' => 'Đang triển khai',
                                            'waiting' => 'Chờ xử lý',
                                            'on_hold' => 'Tạm giữ',
                                            'completed' => 'Hoàn thành'
                                        ];
                                        echo esc_html($status_labels[$project->status] ?? $project->status);
                                        ?>
                                    </code>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?= esc_html__('Date created:', 'tbay_intern') ?></th>
                                <td><?= esc_html($project->start_date) ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?= esc_html__('Update date:', 'tbay_intern') ?></th>
                                <td><?= esc_html($project->end_date) ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Danh sách thực tập sinh -->
            <div id="postbox-container-1" class="postbox-container">
                <!-- Chưa phân công -->
                <div class="postbox">
                    <h2><?= esc_html__('Add members to the project.', 'tbay_intern') ?></h2>
                    <div class="inside">
                        <a href="<?= admin_url("admin.php?page=intern-project-user&action=new&id={$project->id}")?>">
                            <?= esc_html__('Add members to the project.', 'tbay_intern') ?>
                        </a>
                    </div>
                </div>
                <!-- Người hướng dẫn đã được phân công -->
                <div class="postbox">
                    <h2><?= esc_html__('Mentors have been assigned', 'tbay_intern') ?></h2>
                    <div class="inside">
                        <?php if (!empty($mentors)): ?>
                            <table class="wp-list-table widefat fixed striped">
                                <thead>
                                    <tr>
                                        <th scope="row"><?= esc_html__('Name', 'tbay_intern') ?></th>
                                        <th><?= esc_html__('Project join date', 'tbay_intern') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($mentors as $mentor): ?>
                                    <tr>
                                        <td><?= esc_html($mentor->display_name) ?></td>
                                        <td><?= esc_html($mentor->created_at) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p><?= esc_html__('No instructor has been assigned yet.', 'tbay_intern') ?></p>
                        <?php endif; ?>
                        <button type="button" id="add-mentor-btn">
                            <?= esc_html__('Add mentors to the project.', 'tbay_intern') ?>
                        </button>
                    </div>
                </div>
                <!-- Thực tập sinh đã được phân công -->
                <div class="postbox">
                    <h2><?= esc_html__('Interns have been assigned', 'tbay_intern') ?></h2>
                    <div class="inside">
                        <?php if (!empty($interns)): ?>
                            <table class="wp-list-table widefat fixed striped">
                                <thead>
                                <tr>
                                    <th><?= esc_html__('Name', 'tbay_intern') ?></th>
                                    <th><?= esc_html__('Project join date', 'tbay_intern') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($interns as $intern): ?>
                                    <tr>
                                        <td><?= esc_html($intern->display_name) ?></td>
                                        <td><?= esc_html($intern->created_at) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p><?= esc_html__('No interns have been assigned yet.', 'tbay_intern') ?></p>
                        <?php endif; ?>
                        <button type="button" id="add-intern-btn">
                            <?= esc_html__('Add interns to the project.', 'tbay_intern') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div> <!-- /post-body -->
        <br class="clear" />
    </div>
    <?php require_once plugin_dir_path(INTERN_MANAGEMENT_MAIN_FILE) . '/app/template-part/task.php'; ?>

</div>

<div id="mentor-popup" class="popup" style="display: none;">
    <div class="popup-overlay"></div>
    <div class="popup-content">
        <h2><?= esc_html__('Add mentor to project', 'tbay_intern') ?></h2>
        <form method="post" action="<?= admin_url('admin-post.php') ?>">
            <input type="hidden" name="action" value="project_mentor">
            <?php wp_nonce_field('project_mentor_action'); ?>
            <input type="hidden" name="project_id" value="<?= $project->id ?>">
            <label for="mentor"><?= esc_html__('Mentor', 'tbay_intern') ?></label>
            <select id="mentor" name="mentor_ids[]" class="select2 mentor" multiple>
                <?php foreach ($allMentors as $mentor): ?>
                    <option value="<?= $mentor->ID ?>" <?= in_array($mentor->ID, $currentMentorIds) ? 'selected' : '' ?>>
                        <?= esc_html($mentor->display_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php submit_button( esc_attr__('Save' , 'tbay_intern') ); ?>
        </form>
        <button type="button" id="close-mentor-popup" class="button"><?= esc_html__('Close', 'tbay_intern') ?></button>
    </div>
</div>

<div id="intern-popup" class="popup" style="display: none;">
    <div class="popup-overlay"></div>
    <div class="popup-content">
        <h2><?= esc_html__('Add intern to project', 'tbay_intern') ?></h2>
        <form method="post" action="<?= admin_url('admin-post.php') ?>">
            <input type="hidden" name="action" value="project_intern">
            <?php wp_nonce_field('project_intern_action'); ?>
            <input type="hidden" name="project_id" value="<?= $project->id ?>">
            <label for="intern"><?= esc_html__('Intern', 'tbay_intern') ?></label>
            <select id="intern" name="intern_ids[]" class="select2 intern" multiple>
                <?php foreach ($allInterns as $intern): ?>
                    <option value="<?= $intern->ID ?>" <?= in_array($intern->ID, $currentInternIds) ? 'selected' : '' ?>>
                        <?= esc_html($intern->display_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php submit_button( esc_attr__('Save' , 'tbay_intern') ); ?>
        </form>
        <button type="button" id="close-intern-popup" class="button"><?= esc_html__('Close', 'tbay_intern') ?></button>
    </div>
</div>


<script>

    document.addEventListener('DOMContentLoaded', function () {
        const mentorPopup = new PopupWithSelect2({
            openBtn: '#add-mentor-btn',
            popup: '#mentor-popup',
            closeBtn: '#close-mentor-popup',
            selectSelector: '.mentor.select2',       // class của <select>
            dropdownParent: '#mentor-popup .popup-content'         // container của popup
        });
        const internPopup = new PopupWithSelect2({
            openBtn: '#add-intern-btn',
            popup: '#intern-popup',
            closeBtn: '#close-intern-popup',
            selectSelector: '.intern.select2',       // class của <select>
            dropdownParent: '#intern-popup .popup-content'         // container của popup
        });
        const taskPopup = new PopupWithSelect2({
            openBtn: '#add-new-task-btn',
            popup: '#task-popup',
            closeBtn: '#close-task-popup',
            selectSelector: '.task.select2',       // class của <select>
            dropdownParent: '#task-popup .popup-content'         // container của popup
        });
    });

    // Close popup on ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            mentorPopup.hidePopup();
            internPopup.hidePopup();
        }
    });

</script>

