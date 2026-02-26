<?php
namespace InternManagement\App\Controllers\Shortcodes;

use InternManagement\App\Services\TaskService;
if ( ! defined( 'ABSPATH' ) ) exit;
class TestController{
    protected $service;

    public function __construct(){
        $this->service = new TaskService();
    }

    public function dashboard(){


        ob_start();
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . 'app/views/shortcode/test.php';
        return ob_get_clean();
    }
}
