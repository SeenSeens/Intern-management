<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;

class TaskDetailRepository extends BaseRepository{
    protected string $table = 'intern_task_details';

    public function __construct() {
        parent::__construct( $this->table );
    }
}