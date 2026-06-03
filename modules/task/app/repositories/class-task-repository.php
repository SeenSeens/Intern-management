<?php
namespace InternManagement\Modules\Task\App\Repositories;
use InternManagement\Includes\BaseRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskRepository extends BaseRepository{
    protected string $table = 'intern_tasks';
    public function __construct() {
        parent::__construct( $this->table );
    }

    /**
     * Lấy tất cả các tasks
     * @return array|object|\stdClass[]
     */
    public function get_all_tasks(){
        $projects = $this->db->prefix . 'intern_projects';
        return $this->from("{$this->table} t")
            ->select("t.*, p.name as project_name")
            ->join("$projects p","p.id = t.project_id")
            ->where_null("t.deleted_at")
            ->order_by("t.created_at",'DESC')
            ->get();
    }

    public function get_all_tasks_intern(int $user_id){
        $projects = $this->db->prefix . 'intern_projects';
        $task_assignees = $this->db->prefix . 'intern_task_assignees';
        return $this->from("{$this->table} t")
            ->select("t.*, p.name as project_name")
            ->join("$projects p","p.id = t.project_id")
            ->join("$task_assignees ts","t.id = ts.task_id")
            ->where("ts.user_id",'=', $user_id)
            ->where_null("t.deleted_at")
            ->where_null("ts.deleted_at")
            ->where_null("p.deleted_at")
            ->order_by("t.created_at",'DESC')
            ->get();
    }
    /**
     * @return array|object|\stdClass|null
     */
    public function statistics(){
        return $this->select(
            "COUNT(CASE WHEN STATUS = 'pending' THEN 1 END) AS pending,
            COUNT(CASE WHEN STATUS = 'in_progress' THEN 1 END) AS in_progress,
            COUNT(CASE WHEN STATUS = 'completed' THEN 1 END) AS completed,
            COUNT(*) AS total")
            ->first();
    }

    /**
     * @param int $project_id
     * @return array|object|\stdClass|null
     */
    public function overall_progress(int $project_id){
        return $this->from("{$this->table} t")
            ->select("
                COUNT(CASE WHEN STATUS = 'pending' THEN 1 END) AS pending,
                COUNT(CASE WHEN STATUS = 'in_progress' THEN 1 END) AS in_progress,
                COUNT(CASE WHEN STATUS = 'completed' THEN 1 END) AS completed,
                COUNT(*) AS total,
                ROUND(
                    CASE 
                        WHEN COUNT(*) = 0 THEN 0
                        ELSE COUNT(CASE WHEN status = 'completed' THEN 1 END) * 100.0 / COUNT(*)
                    END
                , 0) AS progress
            ")
            ->where("project_id", "=", "$project_id")
            ->where_null("deleted_at")
            ->first();
    }

    /**
     * @param $days
     * @return array|object|\stdClass[]
     */
    public function upcoming_tasks(int $days = 7): array|object{
        return $this->select("*")
        ->where("end_date", ">=", date('Y-m-d'))
        ->where("end_date", "<=", date('Y-m-d', strtotime("+{$days} days")))
        ->where("status", "!=", "completed")
        ->where_null("deleted_at")
        ->get();
    }

    /** Lấy task trong project
     * @param $project_id
     * @return array|object
     */
    public function get_tasks_from_project(int $project_id): object|array{
        return $this->select("*")
            ->where("project_id", "=", "$project_id")
            ->where_null("deleted_at")
            ->get();
    }
    // Xóa task theo id project
    public function delete_by_project(int $project_id): bool{
        return $this->where("project_id", "=", $project_id)
            ->delete_query();
    }
    // Get task
    public function get_task(int $id){
        $projects = $this->db->prefix . 'intern_projects';
        $users = $this->db->users;
        return $this->select('t.*, p.name as project_name, u.ID, u.display_name')
            ->from("{$this->table} t")
            ->join("$projects p", "p.id = t.project_id")
            ->join("$users u", "u.ID = t.intern_id")
            ->where("t.id", "=", $id)
            ->where_null("t.deleted_at")
            ->where_null("p.deleted_at")
            ->first();
    }
}