<?php
namespace InternManagement\Modules\Task\App\Services;

use InternManagement\Includes\BaseService;
use InternManagement\Modules\Task\App\Repositories\TaskDetailRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskDetailService extends BaseService{
    public function __construct(){
        parent::__construct(new TaskDetailRepository());
    }
}