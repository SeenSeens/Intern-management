<?php
namespace InternManagement\App\Actions;
use InternManagement\Core\Action;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectAction extends Action {

    public function save(array $data){
        error_log('Gọi ProjectAction::save với dữ liệu: ' . print_r($data, true));
        if (!empty($data['id'])) {
            $result = $this->service->update($data['id'], $data);
            error_log('Update result: ' . var_export($result, true));
            return $data['id'];
        }
        $result = $this->service->create($data);
        error_log('Create result: ' . var_export($result, true));
        return $result;
    }

    public function delete(int $id){
        $this->service->delete($id);
    }

    

}
