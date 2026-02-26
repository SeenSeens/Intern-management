<?php
namespace InternManagement\App\Actions;
use InternManagement\App\Services\TaskAssigneesService;
use InternManagement\Core\Action;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssignessAction extends Action {

    public function __construct($service = null){
        parent::__construct(new TaskAssigneesService());
    }

    public function save(array $data){
        error_log('Gọi TaskAction::save với dữ liệu: ' . print_r($data, true));
        if (!empty($data['id'])) {
            $result = $this->service->update($data['id'], $data);
            error_log('Update result: ' . var_export($result, true));
            return;
        }
        $result = $this->service->create($data);
        error_log('Create result: ' . var_export($result, true));
    }

    public function delete(int $id){
        $this->service->delete($id);
    }

}
