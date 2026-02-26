<?php
namespace InternManagement\App\Shortcodes;


use InternManagement\App\Controllers\Shortcodes\TestController;
if ( ! defined( 'ABSPATH' ) ) exit;
class TestShortcode{
    public function render($atts = []){
        if (!is_user_logged_in()) {
            return '<p>Vui lòng <a href="' . wp_login_url() . '">đăng nhập</a>.</p>';
        }

        $controller = new TestController();
        return $controller->dashboard();
    }
}
