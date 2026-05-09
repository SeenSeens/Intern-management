<?php
namespace InternManagement\Modules\Project\App\Repositories;
use InternManagement\Includes\BaseRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectRepository extends BaseRepository {
    protected string $table = 'intern_projects';
    public function __construct() {
        parent::__construct( $this->table );
    }

    /**
     * Trạng thái project ( Hiển thị ở index project)
     * @return array|object|\stdClass|null
     */
    public function statistics(){
        return $this->select("
            COUNT(CASE WHEN STATUS = 'completed' THEN 1 END) AS completed,
            COUNT(CASE WHEN STATUS = 'waiting' THEN 1 END) AS waiting,
            COUNT(CASE WHEN STATUS = 'on_hold' THEN 1 END) AS on_hold,
            COUNT(CASE WHEN STATUS = 'in_progress' THEN 1 END) AS in_progress,
            COUNT(*) AS total
        ")
            ->where_null("deleted_at")
            ->first();
    }

}