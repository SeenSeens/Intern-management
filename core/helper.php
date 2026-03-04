<?php
namespace InternManagement\Core;

use DateTime;
use DateTimeZone;
if ( ! defined( 'ABSPATH' ) ) exit;
class Helper {

    /**
     * @param string $input
     * @param string $format
     * @param string $time
     * @return string|null
     */
    public static function format_date_time_local(string $input, string $format = 'Y-m-d', string $time = '00:00:00'): ?string{
        $input = sanitize_text_field($input);
        if (empty($input)) return null;
        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
        $datetime = DateTime::createFromFormat($format, $input, $timezone);
        if (!$datetime) return null;
        if ($time !== '00:00:00') {
            $parts = explode(':', $time);
            if (count($parts) === 3) $datetime->setTime((int)$parts[0], (int)$parts[1], (int)$parts[2]);
        }
        return $datetime->format('Y-m-d H:i:s');
    }

    /**
     * Redirect kèm thông báo cho Toastify (dùng cho bất kỳ module PHP nào)
     * @param string $message Thông báo
     * @param string $type    Loại: 'success'|'error'|'info'|'warning'
     * @param string $page    (tùy chọn) trang admin slug, ví dụ 'emailai'
     * @param array  $extra_query (tùy chọn) thêm params ['tab' => 'x']
     */
    public static function toast_redirect( string $message, string $type = 'success', string $page = '', array $extra_query = [] ): void{
        $base = admin_url( 'admin.php' );
        $params = [];

        if ( $page ) {
            $params['page'] = $page;
        }

        $params['msg']  = $message;
        $params['type'] = $type;

        // gộp thêm params tùy chọn
        if ( ! empty( $extra_query ) && is_array( $extra_query ) ) {
            foreach ( $extra_query as $k => $v ) {
                $params[ $k ] = $v;
            }
        }

        $url = add_query_arg( $params, $base );
        wp_redirect( $url );
        exit;
    }

    /**
     * Gọi toast trực tiếp từ PHP (in script) — trường hợp cần hiển thị ngay trong cùng request (không redirect)
     * Sử dụng khi bạn muốn show toast mà không reload/redirect.
     * @param string $message
     * @param string $type
     */
    public static function print_inline_toast( string $message, string $type = 'success' ): void {
        // Xsafe escape
        $msg = esc_js( $message );
        $t   = esc_js( $type );

        echo "<script type=\"text/javascript\">
            (function(){
                if (window.internNotifications && typeof window.internNotifications.show === 'function') {
                    window.internNotifications.show('{$msg}', '{$t}');
                } else {
                    // nếu JS chưa load, dùng setTimeout thử lại
                    setTimeout(function(){
                        if (window.internNotifications && typeof window.internNotifications.show === 'function') {
                            window.internNotifications.show('{$msg}', '{$t}');
                        }
                    }, 800);
                }
            })();
        </script>";
    }

    /**
     * Redirect kèm thông báo cho SweetAlert2
     *
     * @param string $message Thông báo
     * @param string $type    Loại: 'success'|'error'|'info'|'warning'|'question'
     * @param string $page    (tùy chọn) trang admin slug, ví dụ 'emailai'
     * @param array  $extra_query (tùy chọn) thêm params ['tab' => 'x']
     */
    public static function swal_redirect( string $message, string $type = 'success', string $page = '', array $extra_query = [] ): void {
        $base = admin_url( 'admin.php' );
        $params = [];

        if ( $page ) {
            $params['page'] = $page;
        }

        $params['swal']  = $message; // dùng param khác 'msg' để phân biệt với Toastify
        $params['type']  = $type;

        // gộp thêm params tùy chọn
        if ( ! empty( $extra_query ) && is_array( $extra_query ) ) {
            foreach ( $extra_query as $k => $v ) {
                $params[ $k ] = $v;
            }
        }

        $url = add_query_arg( $params, $base );
        wp_redirect( $url );
        exit;
    }

    /**
     * Hiển thị SweetAlert2 ngay trong cùng request (không redirect)
     *
     * @param string $title
     * @param string $message
     * @param string $type success|error|info|warning|question
     * @param bool   $is_toast (tùy chọn) hiển thị dạng toast hay popup
     */
    public static function print_inline_swal( string $title, string $message = '', string $type = 'info', bool $is_toast = false ): void {
        $title   = esc_js( $title );
        $message = esc_js( $message );
        $type    = esc_js( $type );

        // Dạng Toast hoặc Alert chính thức
        if ( $is_toast ) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: '{$type}',
                        title: '{$title}',
                        text: '{$message}',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        title: '{$title}',
                        text: '{$message}',
                        icon: '{$type}',
                        confirmButtonText: 'OK'
                    });
                });
            </script>";
        }
    }
}
