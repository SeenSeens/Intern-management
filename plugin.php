<?php
namespace InternManagement;
use InternManagement\Core\Init;
if ( ! defined( 'ABSPATH' ) ) exit;
final class Plugin {
    const VERSION = '1.0.0';
    const MINIMUM_PHP_VERSION = '8.0';
    private static ?Plugin $_instance = null;
    public static function instance(): ?Plugin{
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function __construct() {
        if ( !$this->is_compatible() ) return;
        Init::instance();
    }
    public function is_compatible(): bool {
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return false;
        }
        return true;
    }
    public function admin_notice_minimum_php_version(): void{
        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'tbay_intern' ),
            '<strong>' . esc_html__( 'INTERN MANAGEMENT', 'tbay_intern' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'tbay_intern' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
}