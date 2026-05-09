<?php
/*
 * Plugin Name:       Quản Lý Thực Tập Sinh
 * Plugin URI:
 * Description:       Plugin quản lý thực tập sinh
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Trương Đình Tuấn
 * Author URI:
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:
 * Text Domain:       tbay_intern
 * Domain Path:       /languages
 * Requires Plugins:
 */

use InternManagement\Includes\Database;
use InternManagement\Includes\ModuleLoader;
use InternManagement\Includes\Role;
use InternManagement\Plugin;
if ( ! defined( 'ABSPATH' ) ) exit;
if(!defined('INTERN_MANAGEMENT_MAIN_FILE')) {
    define('INTERN_MANAGEMENT_MAIN_FILE', __FILE__);
}
if(!defined('INTERN_MANAGEMENT_URL')) {
    define('INTERN_MANAGEMENT_URL', trailingslashit(plugin_dir_url(__FILE__)));
}
if (!defined('INTERN_MANAGEMENT_PATH')){
    define( 'INTERN_MANAGEMENT_PATH', trailingslashit(plugin_dir_path( __FILE__ ) ));
}
if (!defined('INTERN_MANAGEMENT_PREFIX')){
    define( 'INTERN_MANAGEMENT_PREFIX', 'tbay_intern_');
}
if (!defined('ALLOWED_ROLES')){
    define( 'ALLOWED_ROLES', [ 'administrator', 'project_manager', 'mentor', 'intern' ]);
}
if (!defined('JWT_AUTH_SECRET_KEY')){
    define( 'JWT_AUTH_SECRET_KEY', '4OWcPAYANYMYb/=fj/6d7947*(Bt7I1G)gx7xKFNkC<qG}=G|boZ}V;%A/$igI<.');
}
if (!defined('JWT_AUTH_CORS_ENABLE')){
    define( 'JWT_AUTH_CORS_ENABLE', true);
}
if ( file_exists( INTERN_MANAGEMENT_PATH . 'vendor/autoload.php' ) ) {
    require_once INTERN_MANAGEMENT_PATH . 'vendor/autoload.php';
}
register_activation_hook( INTERN_MANAGEMENT_MAIN_FILE, [Database::class, 'activate'] );
register_deactivation_hook(INTERN_MANAGEMENT_MAIN_FILE, [Database::class, 'drop_table'] );
register_deactivation_hook(INTERN_MANAGEMENT_MAIN_FILE, [Role::class, 'remove_custom_roles'] );
function intern_run(): void{
    if (class_exists(Plugin::class)) {
        Plugin::instance();
        ModuleLoader::instance();
    }
}
add_action( 'plugins_loaded', 'intern_run' );