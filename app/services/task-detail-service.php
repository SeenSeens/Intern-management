<?php
namespace InternManagement\App\Services;

use InternManagement\App\Repositories\TaskDetailRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskDetailService extends BaseService{
    public function __construct(){
        parent::__construct(new TaskDetailRepository());
    }
}