<?php

?>
<div class="wrap">
    <h1 class="wp-heading-inline">📊 Dashboard Quản lý Thực tập sinh</h1>
    <hr class="wp-header-end">

    <!-- Cards thống kê -->
    <div style="display: flex; gap: 20px; margin-top: 20px;">
        <?php
        $cards = [
            ['label' => 'Sinh viên', 'value' => $countIntern, 'color' => '#3498db'],
            ['label' => 'Dự án', 'value' => $countProject, 'color' => '#2ecc71'],
            ['label' => 'Nhiệm vụ', 'value' => $countTask, 'color' => '#f1c40f'],
            ['label' => 'Hoàn thành (%)', 'value' => '68%', 'color' => '#e74c3c']
        ];
        foreach ($cards as $card): ?>
            <div style="flex: 1; background: <?= $card['color'] ?>; color: #fff; padding: 20px; border-radius: 8px;">
                <h2 style="margin: 0; font-size: 28px;"><?= $card['value'] ?></h2>
                <p style="margin: 5px 0 0;"><?= $card['label'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Biểu đồ -->
    <div style="margin-top: 40px;">
        <h2>📈 Biểu đồ tiến độ nhiệm vụ</h2>
        <canvas id="taskProgressChart" height="100"></canvas>
    </div>

    <!-- Danh sách nhiệm vụ gần deadline -->
    <div style="margin-top: 40px;">
        <h2>🕒 Nhiệm vụ sắp đến hạn</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Tên nhiệm vụ</th>
                    <th>Dự án</th>
                    <th>Sinh viên</th>
                    <th>Deadline</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasksAreDueSoons as $tasksAreDueSoon) : ?>
                <tr>
                    <td><?= $tasksAreDueSoon->title ?></td>
                    <td><?= $tasksAreDueSoon->project_id ?></td>
                    <td>Nguyễn Văn A</td>
                    <td><?= $tasksAreDueSoon->end_date ?></td>
                    <td>
                        <span><?= $tasksAreDueSoon->status ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Thư viện Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('taskProgressChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
            datasets: [{
                label: 'Nhiệm vụ hoàn thành',
                data: [5, 12, 9, 18],
                backgroundColor: '#2ecc71'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Tiến độ theo tuần' }
            }
        }
    });
</script>
