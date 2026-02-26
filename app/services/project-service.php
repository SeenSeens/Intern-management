<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\ProjectRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectService extends BaseService {

    public function __construct() {
        parent::__construct(new ProjectRepository());
    }
    public function countProject(){
        return $this->repository->countProject();
    }
}