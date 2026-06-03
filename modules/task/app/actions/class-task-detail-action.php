<?php
namespace InternManagement\Modules\Task\App\Actions;

use InternManagement\App\Actions\BaseAction;
use InternManagement\Includes\Helper;
use InternManagement\Modules\Task\App\Services\TaskDetailService;
use InternManagement\Modules\Task\App\Services\TaskService;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskDetailAction extends BaseAction {
    protected array $allow_html = ['description'];
    protected function validate(): array {
        $errors = [];

        $type = $this->get('action_type', 'save');
        if ($type !== 'delete') {
            if (empty($this->get('title'))) {
                $errors['title'] = 'Tên task không được để trống.';
            }
            if (empty($this->get('description'))) {
                $errors['description'] = 'Mô tả task không được để trống.';
            }
            if (empty($this->get('status'))) {
                $errors['status'] = 'Tên dự án không được để trống.';
            }
            $start = Helper::format_date_time_local($this->get('start_date'));
            $end   = Helper::format_date_time_local($this->get('end_date'));
            if ($start && $end && strtotime($start) > strtotime($end)) {
                $errors['date'] = "Ngày bắt đầu không được lớn hơn ngày kết thúc";
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
            'max_score' => $this->get('max_score'),
            'assigned_by' => $this->get('assigned_by'),
            'status' => $this->get('status'),
            'start_date' => $this->get('start_date') ?  Helper::format_date_time_local($this->get('start_date')) : null,
            'end_date' => $this->get('end_date') ?  Helper::format_date_time_local($this->get('end_date')) : null,
        ];
    }
}