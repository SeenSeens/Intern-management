<?php
namespace InternManagement\App\Repositories;


use DateTime;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskRepository extends BaseRepository{
    protected string $table = 'intern_tasks';

    public function __construct() {
        parent::__construct( $this->table );
    }
    // Lấy tất cả các tasks
    public function get_all_tasks(){
        $projects = $this->db->prefix . 'intern_projects';
        return $this->from("{$this->table} t")
            ->select("t.*, p.name as project_name")
            ->join("$projects p","p.id = t.project_id")
            ->whereNull("t.deleted_at")
            ->orderBy("t.created_at",'DESC')
            ->get();

    }
    public function statistics(){
        return $this->select(
            "COUNT(CASE WHEN STATUS = 'pending' THEN 1 END) AS pending,
            COUNT(CASE WHEN STATUS = 'in_progress' THEN 1 END) AS in_progress,
            COUNT(CASE WHEN STATUS = 'completed' THEN 1 END) AS completed,
            COUNT(*) AS total")
            ->first();
    }
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
            ->whereNull("deleted_at")
            ->first();
    }
    public function upcoming_tasks($days = 7){
        return $this->select("*")
        ->where("end_date", ">=", date('Y-m-d'))
        ->where("end_date", "<=", date('Y-m-d', strtotime("+{$days} days")))
        ->where("status", "!=", "completed")
        ->whereNull("deleted_at")
        ->get();
    }
}