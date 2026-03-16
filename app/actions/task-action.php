<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAction extends BaseAction {
    protected array $allow_html = ['description'];
    protected function validate(): array {
        $errors = [];

        $type = $this->get('action_type', 'save');
        if ($type !== 'delete') {
            if (empty($this->get('title'))) {
                $errors['title'] = 'Tên dự án không được để trống.';
            }
        }

        return $errors;
    }
    protected function map_input(): array{
        return [
            'id' => (int)$this->get('id'),
            'project_id' => (int)$this->get('project_id'),
            'title' => $this->get('title'),
            'description' => $this->get('description'),
            'priority' => $this->get('priority'),
            'assigned_by' => $this->get('assigned_by'),
            'status' => $this->get('status'),
            'start_date' => $this->get('start_date'),
            'end_date' => $this->get('end_date'),
        ];
    }
}
