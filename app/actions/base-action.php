<?php
namespace InternManagement\App\Actions;

use Exception;
use InternManagement\Includes\Action;
use InvalidArgumentException;
use ReflectionClass;

if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * BaseAction – Action dùng chung cho CRUD (Create, Update, Delete)
 * Mỗi module có thể kế thừa class này, chỉ cần định nghĩa:
 *  - validate()
 *  - map_input(): định nghĩa field cần lưu
 */
abstract class BaseAction extends Action {
    /**
     * Lấy tên module dựa trên tên class con.
     * Ví dụ: ProjectAction -> "project", TaskAction -> "task"
     * @return string
     */
    protected function get_module_name(): string {
        $class_name = (new ReflectionClass($this))->getShortName();
        return strtolower(str_replace('Action', '', $class_name));
    }

    /**
     * Entry point CRUD — xử lý theo type (create, update, delete)
     * @return array
     * @throws Exception
     */
    protected function handle(): array{
        global $wpdb;
        $type = $this->get('action_type', 'save');
        $id   = intval($this->get('id'));
        $data = $this->map_input();
        $module = $this->get_module_name();
        $result = [];
        if ($id === 0 && in_array($type, ['update', 'delete'])) {
            error_log('⚠️ ID bằng 0 – AJAX không truyền ID cho thao tác ' . $type);
        }
        $wpdb->query("START TRANSACTION");
        try {
            switch ($type) {
                case 'delete':
                    if (empty($id)) {
                        throw new InvalidArgumentException('Thiếu ID khi xóa.');
                    }
                    do_action("intern_before_{$type}_{$module}", $id, []);
                    $deleted = $this->delete($id);
                    $result = ['deleted_id' => $id, 'deleted' => $deleted];
                    do_action("intern_after_{$type}_{$module}", $id, []);
                    break;
                case 'create':
                    do_action("intern_before_{$type}_{$module}", $id, $data);
                    unset($data['id']);
                    $result = ['created_id' => $this->save($data)];
                    do_action("intern_after_{$type}_{$module}", $id, $data);
                    break;
                case 'update':
                    do_action("intern_before_{$type}_{$module}", $id, $data);
                    if (empty($id)) {
                        throw new InvalidArgumentException('Thiếu ID khi cập nhật.');
                    }
                    $data['id'] = $id;
                    $result = ['updated_id' => $this->save($data)];
                    do_action("intern_after_{$type}_{$module}", $id, $data);
                    break;
                default:
                    do_action("intern_before_{$type}_{$module}", $id, $data);
                    $result = ['saved_id' => $this->save($data)];
                    do_action("intern_after_{$type}_{$module}", $id, $data);
                    break;
            }
            $wpdb->query("COMMIT");
        } catch (Exception $e) {
            $wpdb->query("ROLLBACK");
            error_log("Lỗi ở BaseAction ({$type} {$module}): " . $e->getMessage());
            throw $e;
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