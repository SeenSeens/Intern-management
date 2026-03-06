<?php
namespace InternManagement\Core;
if ( ! defined( 'ABSPATH' ) ) exit;
class Database {
    private static ?Database $instance = null;
    private function __construct() {
        add_action('init', [$this, 'create_tables']);
    }
    public static function instance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function create_tables(): void{
        
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charset_collate = $wpdb->get_charset_collate();
        $table_projects = $wpdb->prefix . 'intern_projects'; // Bảng dự án
        $table_project_mentors = $wpdb->prefix . 'intern_project_mentors'; // Bảng dự án - người hướng dẫn
        $table_project_interns = $wpdb->prefix . 'intern_project_interns'; // Bảng dự án - thực tập
        $table_tasks = $wpdb->prefix . 'intern_tasks'; // Bảng nhiệm  vụ
        $table_task_assignees = $wpdb->prefix . 'intern_task_assignees'; // Bảng giao nhiệm vụ cho thực tập
        $table_task_details = $wpdb->prefix . 'intern_task_details'; // Bảng chi tiết nhiệm vụ
        $table_reports = $wpdb->prefix . 'intern_reports'; // Bảng báo cáo
        $table_scores = $wpdb->prefix . 'intern_task_scores'; // Bảng điểm
        $table_report_comments = $wpdb->prefix . 'intern_report_comments';

        $sql = [];
        $sql[] = "CREATE TABLE {$table_projects} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `status` ENUM('in_progress', 'waiting', 'on_hold', 'completed') DEFAULT 'waiting',
            `manager_id` BIGINT UNSIGNED NOT NULL,
            `start_date` DATE DEFAULT NULL,
            `end_date` DATE DEFAULT NULL,
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
            UNIQUE KEY project_mentor_unique (project_id, mentor_id)
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
            UNIQUE KEY project_intern_unique (project_id, intern_id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$table_tasks} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `project_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `priority` ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
            `max_score` INT DEFAULT 10,
            `assigned_by` BIGINT UNSIGNED NOT NULL,
            `status` ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
            `start_date` DATE DEFAULT NULL,
            `end_date` DATE DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`),
            KEY `assigned_by` (`assigned_by`),
            UNIQUE KEY task_user_unique (task_id, user_id)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$table_task_assignees} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `task_id` BIGINT UNSIGNED NOT NULL,
            `user_id` BIGINT UNSIGNED NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `task_assignees_unique` (task_id, user_id)
        ) $charset_collate;";


        $sql[] = "CREATE TABLE {$table_task_details} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `task_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `status` ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
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
            `week_number` INT,
            `month` INT,
            `year` INT,
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

        $sql[] = "CREATE TABLE {$table_scores}(
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `intern_id` BIGINT UNSIGNED NOT NULL,
            `task_id` BIGINT UNSIGNED DEFAULT NULL,
            `score` INT NOT NULL,
            `evaluated_by` BIGINT UNSIGNED NOT NULL,
            `comment` TEXT,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY `intern_id` (intern_id),
            KEY `task_id` (task_id),
            UNIQUE KEY task_scores_unique (task_id, intern_id)
        ) $charset_collate;";
        foreach ($sql as $query) {
            dbDelta($query);
        }
    }
    public static function alter_tables(): void{}
    public static function drop_table(): void{
        global $wpdb;
        $tables = self::table_names();
        foreach ($tables as $table) :
            $wpdb->query("DROP TABLE IF EXISTS $table");
        endforeach;
    }

    private function add_foreign_keys(): void {}

    private static function table_names(): array{
        global $wpdb;
        return [
            'table_projects' => $wpdb->prefix . 'intern_projects', // Bảng dự án
            'table_project_mentors' => $wpdb->prefix . 'intern_project_mentors', // Bảng dự án - người hướng dẫn
            'table_project_interns' => $wpdb->prefix . 'intern_project_interns', // Bảng dự án - thực tập
            'table_tasks' => $wpdb->prefix . 'intern_tasks', // Bảng nhiệm vụ
            'table_task_assignees' => $wpdb->prefix . 'intern_task_assignees', // Bảng nhiệm vụ - thực tập sinh
            'table_task_details' => $wpdb->prefix . 'intern_task_details', // Bảng chi tiết nhiệm vụ
            'table_reports' => $wpdb->prefix . 'intern_reports', // Bảng báo cáo
            'table_scores' => $wpdb->prefix . 'intern_task_scores' // Bảng điểm
        ];
    }
}