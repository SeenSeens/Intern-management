<?php
namespace InternManagement\Modules\Project\App\Actions;

use Exception;
use InternManagement\App\Actions\BaseAction;
use InternManagement\Includes\Helper;
use InternManagement\Modules\Project\App\Services\ProjectInternService;
use InternManagement\Modules\Project\App\Services\ProjectMentorService;
use InternManagement\Modules\Task\App\Services\TaskService;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectAction extends BaseAction {

    protected array $allow_html = ['description'];

    /**
     * Validate dữ liệu đầu vào
     * @return array
     */
    protected function validate(): array {
        $errors = [];
        $type = $this->get('action_type', 'save');
        if ($type !== 'delete') {
            if (empty($this->get('name'))) {
                $errors['name'] = 'Tên dự án không được để trống.';
            }
            if (empty($this->get('description'))) {
                $errors['description'] = 'Mô tả dự án không được để trống.';
            }
            if (empty($this->get('status'))) {
                $errors['status'] = 'Trạng thái dự án không được để trống.';
            }
            if (empty($this->get('start_date'))) {
                $errors['start_date'] = 'Ngày bắt dự án không được để trống.';
            }
            if (empty($this->get('end_date'))) {
                $errors['end_date'] = 'Ngày kết thúc dự án không được để trống.';
            }
            $start = Helper::format_date_time_local($this->get('start_date'));
            $end   = Helper::format_date_time_local($this->get('end_date'));
            if ($start && $end && strtotime($start) > strtotime($end)) {
                $errors['date'] = "Ngày bắt đầu không được lớn hơn ngày kết thúc";
            }
        }
        return $errors;
    }

    /**
     * @return array
     */
    protected function map_input(): array{
        return [
            'id' => (int)$this->get('id'),
            'name' => $this->get('name'),
            'description' => $this->get('description'),
            'status' => $this->get('status'),
            'manager_id' => get_current_user_id(),
            'start_date' => $this->get('start_date') ? Helper::format_date_time_local($this->get('start_date')) : null,
            'end_date' => $this->get('end_date') ? Helper::format_date_time_local($this->get('end_date')) : null,
        ];
    }

    /**
     * @param array $data
     * @return int|string
     * @throws Exception
     */
    public function save(array $data): int|string {
        $project_id = parent::save($data);
        if (!$project_id) {
            throw new Exception("Không thể tạo project");
        }
        $mentor_ids  = array_map('intval', (array) $this->get('mentors', []));
        $intern_ids  = array_map('intval', (array) $this->get('interns', []));
        $assigned_by = get_current_user_id();
        if (!empty($mentor_ids)) {
            $projectMentorService = new ProjectMentorService();
            $projectMentorService->sync_project_mentors($project_id, $mentor_ids, $assigned_by);
        }
        if (!empty($intern_ids)) {
            $projectInternService = new ProjectInternService();
            $projectInternService->sync_project_interns($project_id, $intern_ids, $assigned_by);
        }
        return $project_id;
    }
}