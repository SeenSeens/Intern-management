<?php
// Kiểm tra quyền
/*if ( ! current_user_can('edit_intern_projects') ) {
    wp_die(__('Bạn không có quyền truy cập chức năng này.'));
}*/
$isEdit = isset($task) && $task;
?>
<div class="wrap">
    <h1>
        <?= $isEdit ? 'Cập nhật nhiệm vụ' : 'Thêm nhiệm vụ' ?>
    </h1>
    <form method="post" action="<?= admin_url('admin-post.php') ?>">
        <input type="hidden" name="action" value="save_task">
        <?php wp_nonce_field('save_task_action'); ?>
        <input type="hidden" name="project_id" value="<?= esc_attr($project->id) ?>">
        <input type="hidden" name="id" value="<?= esc_attr( $task->id ?? 0 ) ?>">
        <table class="form-table">
            <tr>
                <th>Tên</th>
                <td><input name="title" type="text" value="<?= esc_attr($task->title ?? '') ?>" required></td>
            </tr>
            <tr>
                <th>Mô tả</th>
                <td>
                    <?php
                    wp_editor(
                        $task->description ?? '',
                        'description', // ID của field, name cũng là 'description'
                        [
                            'textarea_name' => 'description',
                            'textarea_rows' => 10,
                            'media_buttons' => true,
                        ]
                    );
                    ?>
                </td>
            </tr>
            <tr>
                <th>Trạng thái</th>
                <td>
                    <select name="status">
                        <?php
                        $statuses = ['pending' => 'Chờ xử lý', 'in_progress' => 'Đang triển khai', 'completed' => 'Hoàn thành'];
                        foreach ($statuses as $key => $label) {
                            $selected = ($task->status ?? '') === $key ? 'selected' : '';
                            echo "<option value='{$key}' {$selected}>{$label}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Ngày bắt đầu</th>
                <td>
                    <input type="date" name="start_date" id="start_date">
                </td>
            </tr>
            <tr>
                <th>Ngày kết thúc</th>
                <td>
                    <input type="date" name="end_date" id="end_date">
                </td>
            </tr>
            <tr>
                <th>Độ ưu tiên</th>
                <td>
                    <select name="priority">
                        <?php
                        $priorities = ['low' => 'Thấp', 'medium' => 'Trung bình', 'high' => 'Cao', 'critical' => 'Khẩn cấp'];
                        foreach ($priorities as $key => $label) {
                            $selected = ($task->priority ?? '') === $key ? 'selected' : '';
                            echo "<option value='{$key}' {$selected}>{$label}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        <?php submit_button($isEdit ? 'Cập nhật' : 'Thêm mới'); ?>
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