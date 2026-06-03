<?php
namespace InternManagement\Includes;
if ( ! defined( 'ABSPATH' ) ) exit;
class Database {
    public static function activate(){
        self::create_tables();
        self::seed_data();
        flush_rewrite_rules();
    }
    public static function create_tables(){
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $charset_collate = $wpdb->get_charset_collate();
        $table_projects = $wpdb->prefix . 'intern_projects';
        $table_project_mentors = $wpdb->prefix . 'intern_project_mentors';
        $table_project_interns = $wpdb->prefix . 'intern_project_interns';
        $table_tasks = $wpdb->prefix . 'intern_tasks';
        $table_task_details = $wpdb->prefix . 'intern_task_details';
        $table_reports = $wpdb->prefix . 'intern_reports';
        //$table_report_comments = $wpdb->prefix . 'intern_report_comments';
        $sql = [];
        $sql[] = "CREATE TABLE {$table_projects} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `status` ENUM('in_progress', 'waiting', 'on_hold', 'completed') DEFAULT 'waiting',
            `manager_id` BIGINT UNSIGNED NOT NULL,
            `start_date` DATE DEFAULT NULL,
            `end_date` DATE DEFAULT NULL,
            `current_score` DECIMAL(3,1) DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (id),
            KEY status (status),
            KEY manager_id (manager_id)
        ) $charset_collate;";
        $sql[] = "CREATE TABLE {$table_project_mentors} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `project_id` BIGINT UNSIGNED NOT NULL,
            `mentor_id` BIGINT UNSIGNED NOT NULL,
            `assigned_by` BIGINT UNSIGNED NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (id),
            KEY `project_id` (`project_id`),
            KEY `mentor_id` (`mentor_id`),
            KEY `assigned_by` (`assigned_by`),
            UNIQUE KEY unique_project_mentor (project_id, mentor_id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$table_project_interns} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `project_id` BIGINT UNSIGNED NOT NULL,
            `intern_id` BIGINT UNSIGNED NOT NULL,
            `assigned_by` BIGINT UNSIGNED NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (id),
            KEY `project_id` (`project_id`),
            KEY `intern_id` (`intern_id`),
            KEY `assigned_by` (`assigned_by`),
            UNIQUE KEY unique_project_mentor (project_id, intern_id)
        ) $charset_collate;";
        $sql[] = "CREATE TABLE {$table_tasks} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `project_id` BIGINT UNSIGNED NOT NULL,
            `intern_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `priority` ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
            `current_score` DECIMAL(3,1) DEFAULT NULL,
            `completion_percent` INT DEFAULT 0,
            `status` ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
            `start_date` DATE DEFAULT NULL,
            `end_date` DATE DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`),
            KEY `intern_id` (`intern_id`)
        ) $charset_collate;";
        $sql[] = "CREATE TABLE {$table_task_details} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `task_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `status` ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
            `score` DECIMAL(3,1) DEFAULT 0,
            `evaluated_by` BIGINT UNSIGNED DEFAULT NULL,
            `evaluated_at` DATETIME DEFAULT NULL,
            `created_by` BIGINT UNSIGNED NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `task_id` (`task_id`)
        ) $charset_collate;";
        $sql[] = "CREATE TABLE {$table_reports}(
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `project_id` BIGINT UNSIGNED NOT NULL,
            `task_id` BIGINT UNSIGNED NOT NULL,
            `intern_id` BIGINT UNSIGNED NOT NULL,
            `report_type` ENUM('daily','weekly','monthly','task','project') NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `content` TEXT,
            `progress` INT DEFAULT 0,
            `report_date` DATE,
            `status` ENUM('submitted','reviewed','approved','rejected') DEFAULT 'submitted',
            `reviewed_by` BIGINT UNSIGNED DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (id),
            KEY `task_id` (task_id),
            KEY `project_id` (project_id),
            KEY `intern_id` (intern_id),
            KEY `reviewed_by` (reviewed_by)
        ) $charset_collate;";
        foreach ($sql as $query) {
            dbDelta($query);
        }
    }
    public static function seed_data(){
        global $wpdb;
        $table_projects = $wpdb->prefix . 'intern_projects';
        $table_project_mentors = $wpdb->prefix . 'intern_project_mentors';
        $table_project_interns = $wpdb->prefix . 'intern_project_interns';
        $table_tasks = $wpdb->prefix . 'intern_tasks';
        $table_task_assignees = $wpdb->prefix . 'intern_task_assignees';
        $table_task_details = $wpdb->prefix . 'intern_task_details';
        $table_reports = $wpdb->prefix . 'intern_reports';
        //$table_report_comments = $wpdb->prefix . 'intern_report_comments';
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_projects");
        if ($count > 0) return;
        $manager_id = 1;
        $mentor_ids = [2,3,4];
        $intern_ids = [5,6,7,8,9,10];
        $project_ids = [];
        for ($i=1;$i<=10;$i++){
            $wpdb->insert($table_projects,[
                'name'=>"Intern Project $i",
                'description'=>"Project training $i",
                'status'=>['waiting','in_progress','completed'][array_rand([0,1,2])],
                'manager_id'=>$manager_id,
                'start_date'=>"2026-03-01",
                'end_date'=>"2026-06-01"
            ]);
            $project_id=$wpdb->insert_id;
            $project_ids[]=$project_id;
            foreach($mentor_ids as $mentor){
                $wpdb->insert($table_project_mentors,[
                    'project_id'=>$project_id,
                    'mentor_id'=>$mentor,
                    'assigned_by'=>$manager_id
                ]);
            }
            foreach($intern_ids as $intern){
                $wpdb->insert($table_project_interns,[
                    'project_id'=>$project_id,
                    'intern_id'=>$intern,
                    'assigned_by'=>$mentor_ids[array_rand($mentor_ids)]
                ]);
            }
        }
        $task_ids=[];
        foreach($project_ids as $project){
            for($t=1;$t<=4;$t++){
                $wpdb->insert($table_tasks,[
                    'project_id'=>$project,
                    'intern_id'=>$intern_ids[array_rand($intern_ids)],
                    'title'=>"Task $t Project $project",
                    'description'=>"Development task",
                    'priority'=>['low','medium','high'][array_rand([0,1,2])],
                    'status'=>['pending','in_progress','completed'][array_rand([0,1,2])]
                ]);
                $task_id=$wpdb->insert_id;
                $task_ids[]=$task_id;
                for($d=1;$d<=3;$d++){
                    $wpdb->insert($table_task_details,[
                        'task_id'=>$task_id,
                        'title'=>"Subtask $d",
                        'description'=>"Task detail",
                        'status'=>['pending','completed'][array_rand([0,1])],
                        'created_by'=>$mentor_ids[array_rand($mentor_ids)]
                    ]);
                }
            }
        }
        foreach($task_ids as $task){
            for($r=1;$r<=2;$r++){
                $intern=$intern_ids[array_rand($intern_ids)];
                $wpdb->insert($table_reports,[
                    'project_id'=>$project_ids[array_rand($project_ids)],
                    'task_id'=>$task,
                    'intern_id'=>$intern,
                    'report_type'=>['daily','weekly'][array_rand([0,1])],
                    'title'=>"Report task $task",
                    'content'=>"Work progress report",
                    'progress'=>rand(10,100),
                    'report_date'=>date('Y-m-d'),
                    'status'=>['submitted','reviewed','approved'][array_rand([0,1,2])]
                ]);
            }
        }
    }
    public static function drop_table(): void{
        global $wpdb;
        $tables = self::table_names();
        foreach ($tables as $table) :
            $wpdb->query("DROP TABLE IF EXISTS $table");
        endforeach;
    }

    private static function table_names(): array{
        global $wpdb;
        return [
            'table_projects' => $wpdb->prefix . 'intern_projects',
            'table_project_mentors' => $wpdb->prefix . 'intern_project_mentors',
            'table_project_interns' => $wpdb->prefix . 'intern_project_interns',
            'table_tasks' => $wpdb->prefix . 'intern_tasks',
            'table_task_details' => $wpdb->prefix . 'intern_task_details',
            'table_reports' => $wpdb->prefix . 'intern_reports',
        ];
    }
}