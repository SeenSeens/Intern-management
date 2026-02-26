<?php
//if ( ! current_user_can('edit_intern_projects') ) wp_die(__('Bạn không có quyền truy cập chức năng này.'));
$isEdit = (!empty($currentMentorIds) || !empty($currentInternIds));
?>
<div class="wrap">
    <h1><?= $isEdit ? esc_html__('Edit project members', 'tbay_intern') : esc_html__('Add project members', 'tbay_intern') ?></h1>
    <form method="post" action="<?= admin_url('admin-post.php') ?>">
        <input type="hidden" name="action" value="assign_project_members">
        <?php wp_nonce_field('assign_project_members_action'); ?>
        <input type="hidden" name="project_id" value="<?= $project_id ?>">
        <h2><?= esc_html__('Mentor', 'tbay_intern') ?></h2>
        <?php if($isEdit) : ?>
            <select name="mentor_ids[]" class="select2" multiple>
                <?php foreach ($allMentors as $mentor): ?>
                    <option value="<?= $mentor->ID ?>" <?= in_array($mentor->ID, $currentMentorIds) ? 'selected' : '' ?>>
                        <?= esc_html($mentor->display_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <select name="mentor_ids[]" multiple class="select2">
                <?php foreach ($mentors as $mentor): ?>
                    <option value="<?= $mentor->ID ?>"><?= $mentor->display_name ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
        <h2><?= esc_html__('Intern', 'tbay_intern') ?></h2>
        <?php if($isEdit) : ?>
            <select name="intern_ids[]" class="select2" multiple>
                <?php foreach ($allInterns as $intern): ?>
                    <option value="<?= $intern->ID ?>" <?= in_array($intern->ID, $currentInternIds) ? 'selected' : '' ?>>
                        <?= esc_html($intern->display_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <select name="intern_ids[]" class="select2" multiple >
                <?php foreach ($interns as $intern): ?>
                    <option value="<?= $intern->ID ?>"><?= $intern->display_name ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
        <?php submit_button($isEdit ? esc_attr__('Update' , 'tbay_intern') : esc_attr__('Add new', 'tbay_intern') ); ?>
    </form>
</div>
