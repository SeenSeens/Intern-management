<?php
namespace InternManagement\App\Repositories;


use DateTime;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskRepository extends BaseRepository{
    protected string $table = 'intern_tasks';

    public function __construct() {
        parent::__construct( $this->table );
    }

    public function assignTask( array $data ) {
        global $wpdb;
        $wpdb->insert("{$wpdb->prefix}$this->table", $data);
        return $wpdb->insert_id;
    }

    public function createSubtask( array $data ) {
        global $wpdb;
        $wpdb->insert("{$wpdb->prefix}$this->table", $data);
        return $wpdb->insert_id;
    }

    public function allTasks(){
        global $wpdb;
        $table_tasks = "{$wpdb->prefix}{$this->table}";
        $table_projects = "{$wpdb->prefix}intern_projects";
        return $this->db->get_results("SELECT * FROM $table_tasks JOIN $table_projects ON $table_tasks.project_id = $table_projects.id WHERE 
            $table_tasks.deleted_at IS NULL AND $table_projects.deleted_at IS NULL ORDER BY $table_tasks.created_at DESC");
    }

    public function getTasksByProject( int $project_id){
        global $wpdb;
        return $this->db->get_results(
            $wpdb->prepare("SELECT * FROM {$wpdb->prefix}$this->table WHERE project_id = %d", $project_id)
        );
    }

    public function getProjectIdByTaskId(int $task_id){
        global $wpdb;
        return $this->db->get_row(
            $wpdb->prepare("SELECT project_id FROM {$wpdb->prefix}$this->table WHERE id = %d", $task_id)
        );
    }
    public function countTask(){
        global $wpdb;
        $table_task = "{$wpdb->prefix}{$this->table}";
        return $this->db->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM $table_task")
        );
    }

    /*public function tasksAreDueSoon( DateTime $days_ahead ){
        global $wpdb;
        $table_task = "{$wpdb->prefix}{$this->table}";
        // Lấy ngày hiện tại
        $current_date = current_time( 'mysql', true );
        return $this->db->get_results(
            $wpdb->prepare("SELECT * FROM $table_task WHERE end_date <= DATE_ADD(%s, INTERVAL %d DAY) OR end_date < %s AND deleted_at IS NULL ", $current_date, $days_ahead, $current_date)
        );
    }*/
}