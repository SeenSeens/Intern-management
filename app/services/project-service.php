<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\ProjectRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectService extends BaseService {

    public function __construct() {
        parent::__construct(new ProjectRepository());
    }
    public function count_project(){
        return $this->repository->count_project();
    }

    public function count_project_status(){
        return $this->repository->count_project_status();
    }
}