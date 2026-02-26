<div class="wrap">
    <h1>Thành viên dự án #<?= $project_id ?></h1>

    <h2>Mentor</h2>
    <ul>
        <?php foreach ($mentors as $mentor): ?>
            <li><?= esc_html($mentor->display_name) ?> (ID: <?= $mentor->ID ?>)</li>
        <?php endforeach; ?>
    </ul>

    <h2>Intern</h2>
    <ul>
        <?php foreach ($interns as $intern): ?>
            <li><?= esc_html($intern->display_name) ?> (ID: <?= $intern->ID ?>)</li>
        <?php endforeach; ?>
    </ul>

    <a href="<?= admin_url('admin.php?page=intern-project') ?>">← Quay lại danh sách dự án</a>
</div>
