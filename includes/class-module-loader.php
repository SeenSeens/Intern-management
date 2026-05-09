<?php
namespace InternManagement\Includes;
use InternManagement\Modules\Auth\Auth;
use InternManagement\Modules\Evaluation\Evaluation;
use InternManagement\Modules\Project\Project;
use InternManagement\Modules\Report\Report;
use InternManagement\Modules\Setting\Setting;
use InternManagement\Modules\Task\Task;
if ( ! defined( 'ABSPATH' ) ) exit;
class ModuleLoader {
    private static ?ModuleLoader $instance = null;
    private function __construct(){
        $this->load_modules();
    }
    public static function instance(): ModuleLoader{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function load_modules(): void {
        $module_path = INTERN_MANAGEMENT_PATH . 'modules';
        if ( ! is_dir( $module_path ) ) return;
        foreach (glob($module_path . '/*', GLOB_ONLYDIR) as $dir) {
            $module_folder_name = basename($dir);
            $class_name = $this->slug_to_class( $module_folder_name );
            if ( ! class_exists( $class_name ) ) {
                $file_path = "{$dir}/{$module_folder_name}.php";
                if ( file_exists( $file_path ) ) {
                    require_once $file_path;
                }
            }
            if ( class_exists( $class_name ) && method_exists( $class_name, 'instance' ) ) {
                $class_name::instance();
            }
        }
    }
    private function slug_to_class(string $slug): string {
        $class = str_replace( '-', ' ', $slug );
        $class = ucwords( $class );
        $class = str_replace( ' ', '', $class );
        return "InternManagement\\Modules\\{$class}\\{$class}";
    }
}