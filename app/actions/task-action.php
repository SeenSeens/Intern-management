<?php
namespace InternManagement\App\Actions;
use InternManagement\Core\Action;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAction extends Action {

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
