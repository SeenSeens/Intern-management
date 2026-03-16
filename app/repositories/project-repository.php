<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectRepository extends BaseRepository {
    protected string $table = 'intern_projects';

    public function __construct() {
        parent::__construct( $this->table );
    }
    public function count_project(){
        return $this->db->get_var(
            $this->db->prepare("SELECT COUNT(*) FROM $this->table WHERE deleted_at IS NULL")
        );
    }

    public function count_project_status(){
        return $this->db->get_row(
            $this->db->prepare("
                SELECT 
                    COUNT(CASE WHEN STATUS = 'completed' THEN 1 END) AS completed,
                    COUNT(CASE WHEN STATUS = 'waiting' THEN 1 END) AS waiting,
                    COUNT(CASE WHEN STATUS = 'on_hold' THEN 1 END) AS on_hold,
                    COUNT(CASE WHEN STATUS = 'in_progress' THEN 1 END) AS in_progress,
                    COUNT(*) AS total
                FROM {$this->table}
            ")
        );
    }
}