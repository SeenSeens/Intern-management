<?php
namespace InternManagement\Modules\Task\App\Repositories;
use InternManagement\Includes\BaseRepository;

if ( ! defined( 'ABSPATH' ) ) exit;

class TaskDetailRepository extends BaseRepository{
    protected string $table = 'intern_task_details';

    public function __construct() {
        parent::__construct( $this->table );
    }
}