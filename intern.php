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

use InternManagement\Core\Database;
use InternManagement\Core\Role;
use InternManagement\Plugin;
if ( ! defined( 'ABSPATH' ) ) exit;
define( 'INTERN_MANAGEMENT_MAIN_FILE', __FILE__ );
define( 'INTERN_MANAGEMENT_URL', plugin_dir_url( __FILE__ ) );
define( 'INTERN_MANAGEMENT_PATH', plugin_dir_path( __FILE__ ) );
define( 'INTERN_MANAGEMENT_PREFIX', 'tbay_intern_');
const ALLOWED_ROLES = [ 'administrator', 'project_manager', 'mentor', 'intern' ];
const JWT_AUTH_SECRET_KEY = '4OWcPAYANYMYb/=fj/6d7947*(Bt7I1G)gx7xKFNkC<qG}=G|boZ}V;%A/$igI<.';
const JWT_AUTH_CORS_ENABLE = true;
// Autoload Composer files
if ( file_exists( INTERN_MANAGEMENT_PATH . 'vendor/autoload.php' ) ) {
    require_once INTERN_MANAGEMENT_PATH . 'vendor/autoload.php';
}
register_activation_hook( INTERN_MANAGEMENT_MAIN_FILE, [Database::class, 'activate'] );
register_deactivation_hook(INTERN_MANAGEMENT_MAIN_FILE, [Database::class, 'drop_table'] );

register_deactivation_hook(INTERN_MANAGEMENT_MAIN_FILE, [Role::class, 'remove_custom_roles'] );
function intern_run(): void{
    if (class_exists(Plugin::class)) {
        Plugin::instance();
    }
}
add_action( 'plugins_loaded', 'intern_run' );