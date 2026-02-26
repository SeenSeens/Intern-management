<?php
namespace InternManagement;
use InternManagement\Core\Init;

if ( ! defined( 'ABSPATH' ) ) exit;

final class Plugin {

    const string VERSION = '1.0.0';
    const string MINIMUM_PHP_VERSION = '8.0';
    private static ?Plugin $_instance = null;

    public static function instance(): ?Plugin{
        if ( is_null( self::$_instance ) ) self::$_instance = new self();
        return self::$_instance;
    }

    public function __construct() {
        if ( !$this->is_compatible() ) return;
        $this->init();
        Init::instance();
    }

    public function init(): void {
        add_action('init', function() {
            $locale = get_locale(); // vi_VN
            $mofile = WP_PLUGIN_DIR . '/intern/languages/tbay_intern-' . $locale . '.mo';

            if ( file_exists( $mofile ) ) {
                error_log("File dịch tồn tại: " . $mofile);
            } else {
                error_log("KHÔNG tìm thấy file dịch tại: " . $mofile);
            }
        });
        add_action('init', [ $this, 'load_languages'] );
        add_action('admin_enqueue_scripts', [$this, 'admin_styles']);
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_styles']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);
        add_action('admin_enqueue_scripts', function () {

            wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
            wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], null, true);

            // JS khởi tạo
            wp_add_inline_script('select2-js', "
                jQuery(document).ready(function($) {
                    $('select[multiple]').select2({
                        width: '100%',
                        placeholder: 'Chọn...',
                        allowClear: true
                    });
                });
            ");
        });

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

    /**
     * Nạp file ngôn ngữ từ thư mục /languages
     */
    public function load_languages(): void {
        $path = dirname( plugin_basename( INTERN_MANAGEMENT_MAIN_FILE ) ) . '/languages';
        load_plugin_textdomain( 'tbay_intern', false, $path );
    }
    public function admin_styles(): void {
        $styles = [
            'select2.min' => '4.1.0',
            'toastify.min' => '1.12.0',
            'all.min' => '6.7.2',
            'sweetalert2.min' => '11.26.3',
            'style' => '1.0.0'
        ];
        foreach( $styles as $style => $version ) :
            wp_enqueue_style(INTERN_MANAGEMENT_PREFIX . $style , plugins_url("assets/backend/css/{$style}.css", INTERN_MANAGEMENT_MAIN_FILE),  [], $version, 'all' );
        endforeach;
    }

    public function admin_scripts(): void {
        $scripts = [
            'select2.min' => '4.1.0',
            'toastify-js' => '1.12.0',
            'all.min' => '6.7.2',
            'sweetalert2@11' => '11.26.3',
            'popup' => '1.0.0'
        ];
        foreach( $scripts as $script => $version ) :
            wp_enqueue_script(INTERN_MANAGEMENT_PREFIX . $script, plugins_url("assets/backend/js/{$script}.js", INTERN_MANAGEMENT_MAIN_FILE), ['jquery'], $version, true);
        endforeach;
        // JS khởi tạo
        wp_add_inline_script('select2-js', "
            jQuery(document).ready(function($) {
                $('select[multiple]').select2({
                    width: '100%',
                    placeholder: 'Chọn...',
                    allowClear: true
                });
            });
        ");

    }

    public function frontend_styles(): void {
    }

    public function frontend_scripts(): void{
    }
}

