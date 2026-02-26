<?php
//if ( ! current_user_can('edit_intern_projects') ) wp_die(__('Bạn không có quyền truy cập chức năng này.'));
?>
<div class="wrap">
    <form method="post" action="<?= admin_url('admin-post.php') ?>">
        <input type="hidden" name="action" value="assign_task">
        <?php wp_nonce_field('assign_task_action'); ?>
        <input type="hidden" name="task_id" value="<?= esc_attr($id ?? '') ?>">
        <table class="form-table">
            <tr>
                <th><?= esc_html__('Intern', 'tbay_intern') ?></th>
                <td>
                    <select name="intern_ids[]" class="select2" multiple>
                        <?php foreach ($interns as $intern): ?>
                        <option value="<?= $intern->ID ?>"><?= $intern->display_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php submit_button(esc_html__('Save', 'tbay_intern')); ?>
    </form>
</div>
