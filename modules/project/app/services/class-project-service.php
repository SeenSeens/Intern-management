<?php
namespace InternManagement\Modules\Project\App\Services;
use Exception;
use InternManagement\Includes\BaseService;
use InternManagement\Modules\Project\App\Repositories\ProjectRepository;
use InternManagement\Modules\Task\App\Repositories\TaskDetailRepository;
use InternManagement\Modules\Task\App\Repositories\TaskRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectService extends BaseService {
    protected TaskRepository $taskRepository;
    protected TaskDetailRepository $taskDetailRepository;

    public function __construct() {
        parent::__construct(new ProjectRepository());
        $this->taskRepository = new TaskRepository();
        $this->taskDetailRepository = new TaskDetailRepository();
    }

    public function statistics(){
        return $this->repository->statistics();
    }
    public function delete_project_and_relations(int $project_id) {
        global $wpdb;
        $wpdb->query("START TRANSACTION");
        try {
            $this->repository->delete($project_id);
        } catch (Exception $e) {
            $wpdb->query("ROLLBACK");
            error_log('Error deleting project ID ' . $project_id . ': ' . $e->getMessage());
            throw new Exception('Không thể xóa dự án lúc này. Vui lòng thử lại sau.');
        }
    }
}