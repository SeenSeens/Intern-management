<?php
/*
 * Module Name: User
 * Description:
 * Version: 1.0.0
 * Author: Trương Đình Tuấn
 */
namespace InternManagement\Modules\User;
if ( ! defined( 'ABSPATH' ) ) exit;
final class User {
    private static ?User $instance = null;
    private function __construct(){
        $this->define_constants();
        $this->load_controllers();
        $this->load_includes();
    }
    public static function instance(): User{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function define_constants(): void{
        if(!defined('INTERN_MANAGEMENT_USER_FILE')) {
            define('INTERN_MANAGEMENT_USER_FILE', __FILE__);
        }
        if(!defined('INTERN_MANAGEMENT_USER_URL')) {
            define('INTERN_MANAGEMENT_USER_URL', trailingslashit(plugin_dir_url(__FILE__)));
        }
        if (!defined('INTERN_MANAGEMENT_USER_PATH')) {
            define('INTERN_MANAGEMENT_USER_PATH', trailingslashit(plugin_dir_path(__FILE__)));
        }
    }
    private function load_controllers(): void {
        $controller_path = INTERN_MANAGEMENT_USER_PATH . 'app/controllers';
        if ( ! is_dir( $controller_path ) ) return;
        foreach (glob($controller_path . '/*.php') as $file) {
            $controller_folder_name = basename($file);
            $class_name = $this->resolve_controller_class( $controller_folder_name );
            if ( ! class_exists( $class_name ) ) {
                require_once $file;
            }
            if ( class_exists( $class_name ) ) {
                new $class_name();
            }
        }
    }
    private function resolve_controller_class(string $file): string{
        $filename = basename($file, '.php');
        $name = str_replace('class-', '', $filename);
        $parts = explode('-', $name);
        $parts = array_map('ucfirst', $parts);
        $class = implode('', $parts);
        return __NAMESPACE__ . "\\App\\Controllers\\{$class}";
    }
    private function load_includes(): void{
        $path = INTERN_MANAGEMENT_USER_PATH . 'includes';
        if (!is_dir($path)) return;
        foreach (glob($path . '/*.php') as $file) {
            require_once $file;
            $class = $this->resolve_include_class($file);
            if (class_exists($class)) {
                new $class();
            }
        }
    }
    private function resolve_include_class(string $file): string {
        $filename = basename($file, '.php');
        $name = str_replace('class-', '', $filename);
        $parts = explode('-', $name);
        $parts = array_map('ucfirst', $parts);
        $class = implode('', $parts);
        return __NAMESPACE__ . "\\Includes\\{$class}";
    }
}