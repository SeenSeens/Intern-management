
<div class="wrap">
    <h1 class="wp-heading-inline"><?= esc_html__('Member List', 'tbay_intern') ?></h1>
    <a href="<?= admin_url("/user-new.php") ?>" class="page-title-action"><?= esc_html__('Add new member', 'tbay_intern') ?></a>
    <hr class="wp-header-end">
    <div>
        <h2><?= esc_html__('List of interns', 'tbay_intern') ?></h2>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Avatar', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('User name', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Display name', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('E-mail', 'tbay_intern') ?></strong></th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 0; foreach ($interns as $intern): ?>
                    <tr>
                        <td><?= esc_html( ++$index ) ?></td>
                        <td><?= get_avatar( $intern->ID, 32 ) ?></td>
                        <td>
                            <?= esc_html($intern->user_nicename) ?>
                            <div class="row-actions">
                                <span class="edit">
                                    <a href="<?= admin_url('user-edit.php?user_id=' . $intern->ID) ?>"><?= esc_html__('Edit', 'tbay_intern') ?></a> |
                                </span>
                                <span class="trash">
                                    <a href="<?= wp_nonce_url(admin_url("users.php?action=delete&user={$intern->ID}"), 'bulk-users') ?>"><?= esc_html__('Delete', 'tbay_intern') ?></a> |
                                </span>
                                <span class="view">
                                    <a href="<?= admin_url("") ?>"><?= esc_html__('View profile', 'tbay_intern') ?></a>
                                </span>
                            </div>
                        </td>
                        <td><?= esc_html($intern->display_name) ?></td>
                        <td>
                            <?= esc_html($intern->user_email) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div>
        <h2><?= esc_html__('List of mentors', 'tbay_intern') ?></h2>
        <table class="widefat fixed striped">
            <thead>
            <tr>
                <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Avatar', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('User name', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Display name', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('E-mail', 'tbay_intern') ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php $index = 0; foreach ($mentors as $mentor): ?>
                <tr>
                    <td><?= esc_html( ++$index ) ?></td>
                    <td><?= get_avatar( $mentor->ID, 32 ) ?></td>
                    <td>
                        <?= esc_html($mentor->user_nicename) ?>
                        <div class="row-actions">
                                <span class="edit">
                                    <a href="<?= admin_url('user-edit.php?user_id=' . $mentor->ID) ?>"><?= esc_html__('Edit', 'tbay_intern') ?></a> |
                                </span>
                            <span class="trash">
                                    <a href="<?= wp_nonce_url(admin_url("users.php?action=delete&user={$mentor->ID}"), 'bulk-users') ?>"><?= esc_html__('Delete', 'tbay_intern') ?></a> |
                                </span>
                            <span class="view">
                                    <a href="<?= admin_url("") ?>"><?= esc_html__('View profile', 'tbay_intern') ?></a>
                                </span>
                        </div>
                    </td>
                    <td><?= esc_html($mentor->display_name) ?></td>
                    <td>
                        <?= esc_html($mentor->user_email) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div>
        <h2><?= esc_html__('List of project managers', 'tbay_intern') ?></h2>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Avatar', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('User name', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('Display name', 'tbay_intern') ?></strong></th>
                    <th><strong><?= esc_html__('E-mail', 'tbay_intern') ?></strong></th>
                </tr>
            </thead>
            <tbody>
            <?php $index = 0; foreach ($project_managers as $project_manager): ?>
                <tr>
                    <td><?= esc_html( ++$index ) ?></td>
                    <td><?= get_avatar( $project_manager->ID, 32 ) ?></td>
                    <td>
                        <?= esc_html($project_manager->user_nicename) ?>
                        <div class="row-actions">
                                <span class="edit">
                                    <a href="<?= admin_url('user-edit.php?user_id=' . $project_manager->ID) ?>"><?= esc_html__('Edit', 'tbay_intern') ?></a> |
                                </span>
                            <span class="trash">
                                    <a href="<?= wp_nonce_url(admin_url("users.php?action=delete&user={$project_manager->ID}"), 'bulk-users') ?>"><?= esc_html__('Delete', 'tbay_intern') ?></a> |
                                </span>
                            <span class="view">
                                    <a href="<?= admin_url("") ?>"><?= esc_html__('View profile', 'tbay_intern') ?></a>
                                </span>
                        </div>
                    </td>
                    <td><?= esc_html($project_manager->display_name) ?></td>
                    <td>
                        <?= esc_html($project_manager->user_email) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div>
        <h2><?= esc_html__('List of human resources', 'tbay_intern') ?></h2>
        <table class="widefat fixed striped">
            <thead>
            <tr>
                <th style="width: 2.2em;"><strong><?= esc_html__('No', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Avatar', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('User name', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('Display name', 'tbay_intern') ?></strong></th>
                <th><strong><?= esc_html__('E-mail', 'tbay_intern') ?></strong></th>
            </tr>
            </thead>
            <tbody>
            <?php $index = 0; foreach ($hrs as $hr): ?>
                <tr>
                    <td><?= esc_html( ++$index ) ?></td>
                    <td><?= get_avatar( $hr->ID, 32 ) ?></td>
                    <td>
                        <?= esc_html($hr->user_nicename) ?>
                        <div class="row-actions">
                                <span class="edit">
                                    <a href="<?= admin_url('user-edit.php?user_id=' . $hr->ID) ?>"><?= esc_html__('Edit', 'tbay_intern') ?></a> |
                                </span>
                            <span class="trash">
                                    <a href="<?= wp_nonce_url(admin_url("users.php?action=delete&user={$hr->ID}"), 'bulk-users') ?>"><?= esc_html__('Delete', 'tbay_intern') ?></a> |
                                </span>
                            <span class="view">
                                    <a href="<?= admin_url("") ?>"><?= esc_html__('View profile', 'tbay_intern') ?></a>
                                </span>
                        </div>
                    </td>
                    <td><?= esc_html($hr->display_name) ?></td>
                    <td>
                        <?= esc_html($hr->user_email) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>