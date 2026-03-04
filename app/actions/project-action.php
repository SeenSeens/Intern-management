<?php
namespace InternManagement\App\Actions;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectAction extends BaseAction {

    protected array $allow_html = [  ];
    /**
     * Validate dữ liệu đầu vào
     */
    protected function validate(): array {
        $errors = [];

        $type = $this->get('action_type', 'save');
        if ($type !== 'delete') {

        }

        return $errors;
    }


    protected function map_input(): array
    {
        // TODO: Implement map_input() method.
    }
}
