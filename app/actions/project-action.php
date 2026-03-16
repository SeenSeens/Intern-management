<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectAction extends BaseAction {

    protected array $allow_html = [];
    /**
     * Validate dữ liệu đầu vào
     */
    protected function validate(): array {
        $errors = [];

        $type = $this->get('action_type', 'save');
        if ($type !== 'delete') {
            if (empty($this->get('name'))) {
                $errors['name'] = 'Tên dự án không được để trống.';
            }
        }

        return $errors;
    }


    protected function map_input(): array{
        return [
            'id' => (int)$this->get('id'),
            'name' => $this->get('name'),
            'description' => $this->get('description'),
            'status' => $this->get('status'),
            'manager_id' => get_current_user_id(),
            'start_date' => $this->get('start_date'),
            'end_date' => $this->get('end_date'),
        ];
    }
}
