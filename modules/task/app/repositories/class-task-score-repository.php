<?php
namespace InternManagement\Modules\Task\App\Repositories;
use InternManagement\Includes\BaseRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskScoreRepository extends BaseRepository{
    protected string $table = 'intern_task_scores';
    public function __construct() {
        parent::__construct( $this->table );
    }
    public function delete_task_score_by_task_id(int $task_id): bool{
        $this->where('task_id', '=', $task_id);
        if ($this->softDelete) {
            return $this->update_query([
                'deleted_at' => current_time('mysql')
            ]);
        }
        return $this->delete_query();
    }
}