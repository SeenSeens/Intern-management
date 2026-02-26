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


use InternManagement\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

function intern(): void {
    define( 'INTERN_MANAGEMENT_MAIN_FILE', __FILE__ );
    define( 'INTERN_MANAGEMENT_URL', plugin_dir_url( __FILE__ ) );
    define( 'INTERN_MANAGEMENT_PATH', plugin_dir_path( __FILE__ ) );
    define( 'INTERN_MANAGEMENT_PREFIX', 'tbay_intern_');


    // Autoload Composer files
    if ( file_exists( plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . 'vendor/autoload.php' ) ) {
        require_once plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . 'vendor/autoload.php';
        error_log('Autoload loaded successfully');
    } else {
        error_log('Autoload file not found');
    }

    Plugin::instance();
}
add_action( 'plugins_loaded', 'intern' );
