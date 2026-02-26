<div class="wrap">
    <h1><?= esc_html__('Edit project members:', 'tbay_intern') ?><?= esc_html($project->name) ?></h1>
    <form method="post" action="<?= admin_url('admin-post.php') ?>">
        <input type="hidden" name="action" value="update_project_members">
        <input type="hidden" name="project_id" value="<?= esc_attr($project->id) ?>">
        <?php wp_nonce_field('update_project_members_action'); ?>
        <table class="form-table">
            <tr>
                <th><?= esc_html__('Mentors', 'tbay_intern') ?></th>
                <td>
                    <select name="mentor_ids[]" class="select2" multiple>
                        <?php foreach ($allMentors as $mentor): ?>
                            <option value="<?= $mentor->ID ?>" <?= in_array($mentor->ID, $currentMentorIds) ? 'selected' : '' ?>>
                                <?= esc_html($mentor->display_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><?= esc_html__('Interns', 'tbay_intern') ?></th>
                <td>
                    <select name="intern_ids[]" class="select2" multiple>
                        <?php foreach ($allInterns as $intern): ?>
                            <option value="<?= $intern->ID ?>" <?= in_array($intern->ID, $currentInternIds) ? 'selected' : '' ?>>
                                <?= esc_html($intern->display_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php submit_button( esc_html__('Update Member', 'tbay_intern') ); ?>
    </form>
    <ul>
        <?php foreach ($allMentors as $mentor): ?>
            <li>
                <?= esc_html($mentor->display_name) ?>
                <a href="<?= wp_nonce_url(admin_url("admin.php?page=intern-project&action=remove_mentor&project_id={$project->id}&mentor_id={$mentor->ID}"), 'remove_project_member_action') ?>" onclick="return confirm('Xoá mentor này?')">Xoá</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <ul>
        <?php foreach ($allInterns as $intern): ?>
            <li>
                <?= esc_html($intern->display_name) ?>
                <a href="<?= wp_nonce_url(admin_url("admin.php?page=intern-project&action=remove_intern&project_id={$project->id}&intern_id={$intern->ID}"), 'remove_project_member_action') ?>" onclick="return confirm('Xoá intern này?')">Xoá</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


