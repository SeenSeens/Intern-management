<?php
namespace InternManagement\App\Actions;
use InternManagement\Core\Action;

if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * BaseAction – Action dùng chung cho CRUD (Create, Update, Delete)
 *
 * Mỗi module có thể kế thừa class này, chỉ cần định nghĩa:
 *  - validate()
 *  - map_input(): định nghĩa field cần lưu
 */
abstract class BaseAction extends Action {

    /**
     * Entry point CRUD — xử lý theo type (create, update, delete)
     */
    protected function handle(): array{
        $type = $this->get('action_type', 'save'); // default là create/update
        $id   = intval($this->get('id'));
        if ($id === 0) {
            error_log('⚠ ID bị 0 — AJAX không truyền ID');
        }
        error_log( $id  );
        $data = $this->map_input();

        $result = [];

        switch ($type) {
            case 'delete':
                if (empty($id)) {
                    throw new \InvalidArgumentException('Thiếu ID khi xóa.');
                }
                $deleted = $this->delete($id);
                $result = ['deleted_id' => $id, 'deleted' => $deleted];
                break;

            case 'create':
                unset($data['id']);
                $result = ['created_id' => $this->save($data)];
                break;

            case 'update':
                if (empty($id)) {
                    throw new \InvalidArgumentException('Thiếu ID khi cập nhật.');
                }
                $data['id'] = $id;
                $result = ['updated_id' => $this->save($data)];
                break;

            default:
                $result = ['saved_id' => $this->save($data)];
                break;
        }

        // Chuẩn hóa output để controller nhận diện dễ
        if (isset($result['created_id']) || isset($result['updated_id']) || isset($result['saved_id'])) {
            $result['saved'] = true;
        }

        return $result;
    }

    /**
     * Hàm con cần override để map dữ liệu đầu vào sang format DB
     */
    abstract protected function map_input(): array;
}