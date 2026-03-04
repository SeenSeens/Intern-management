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
        $table_task_assignees = $wpdb->prefix . 'intern_task_assignees';
        $table_task_details = $wpdb->prefix . 'intern_task_details';
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
            KEY `assigned_by` (`assigned_by`)
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
            KEY `assigned_by` (`assigned_by`)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$table_tasks} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `project_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `priority` ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
            `assigned_by` BIGINT UNSIGNED NOT NULL,
            `status` ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
            `start_date` DATE DEFAULT NULL,
            `end_date` DATE DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `project_id` (`project_id`),
            KEY `assigned_by` (`assigned_by`)
        ) $charset_collate;";

        $sql[] = "CREATE TABLE {$table_task_assignees} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `task_id` BIGINT UNSIGNED NOT NULL,
            `user_id` BIGINT UNSIGNED NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `task_user_unique` (`task_id`, `user_id`)
        ) $charset_collate;";


        $sql[] = "CREATE TABLE {$table_task_details} (
            `id` BIGINT UNSIGNED AUTO_INCREMENT,
            `task_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `status` ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
            `created_by` BIGINT UNSIGNED NOT NULL,
            `assignee_id` BIGINT UNSIGNED NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` DATETIME DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `task_id` (`task_id`),
            KEY `created_by` (`created_by`),
            KEY `assignee_id` (`assignee_id`)
        ) $charset_collate;";



        foreach ($sql as $query) {
            dbDelta($query);
        }
    }
    public static function alter_tables(): void{

    }
    public static function drop_table(): void{
        global $wpdb;
        $tables = self::table_names();
        foreach ($tables as $table) :
            $wpdb->query("DROP TABLE IF EXISTS $table");
        endforeach;
    }

    private function add_foreign_keys(): void {
        global $wpdb;
    }

    private static function table_names(): array{
        global $wpdb;
        return [
            'table_projects' => $wpdb->prefix . 'intern_projects', // Bảng dự án
            'table_project_mentors' => $wpdb->prefix . 'intern_project_mentors', // Bảng dự án - người hướng dẫn
            'table_project_interns' => $wpdb->prefix . 'intern_project_interns', // Bảng dự án - thực tập
            'table_tasks' => $wpdb->prefix . 'intern_tasks', // Bảng nhiệm vụ
            'table_task_assignees' => $wpdb->prefix . 'intern_task_assignees', // Bảng nhiệm vụ - thực tập sinh
            'table_task_details' => $wpdb->prefix . 'intern_task_details', // Bảng nhiệm vụ con
        ];
    }
}