<?php
//if ( ! current_user_can('edit_intern_projects') ) wp_die(__('Bạn không có quyền truy cập chức năng này.'));
$isEdit = isset($project) && $project;
?>
<div class="wrap">
    <h1><?= $isEdit ? esc_html__('Project update', 'tbay_intern') : esc_html__('Add project', 'tbay_intern') ?></h1>
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
                    <?php submit_button($isEdit ? esc_attr__('Update' , 'tbay_intern') : esc_attr__('Add new', 'tbay_intern') ); ?>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const start = new Date(document.querySelector('[name="start_date"]').value);
    const end = new Date(document.querySelector('[name="end_date"]').value);
    if (start && end && start > end) {
        alert("Ngày bắt đầu không được lớn hơn ngày kết thúc!");
        e.preventDefault();
    }
});

</script>
