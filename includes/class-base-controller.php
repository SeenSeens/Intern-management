<?php
namespace InternManagement\Includes;
use Throwable;

if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * BaseController
 * -----------------------------------------
 * Class cha cho tất cả Controller trong hệ thống
 * Cung cấp: render(), json(), redirect(), partial(), view_exists(), error(), success()
 */
abstract class Controller{
    protected mixed $service;
    protected string $module = '';

    public function __construct($service = null){
        if ($service) $this->service = $service;
        $this->register_ajax_hooks();
    }

    /**
     * Mỗi controller con cần override hàm này
     * để đăng ký các hook AJAX cụ thể của nó.
     */
    protected function register_ajax_hooks(): void {}

    /**
     * Render view với dữ liệu truyền từ Controller
     *
     * @param string $view    Ví dụ: 'compose/index'
     * @param array  $data    Mảng dữ liệu (thường từ compact())
     * @param bool   $return  Nếu true → return HTML thay vì echo
     * @return string|void
     */
    protected function render(string $view, array $data = [], bool $return = false){
        $file = INTERN_MANAGEMENT_PATH . '/app/views/' . $view . '.php';
        if (!file_exists($file)) {
            $msg = "<div class='wrap'>
                <div class='notice notice-error'>
                    <p>⚠️ Giao diện chưa được tạo: <code>{$view}</code></p>
                </div>
            </div>";
            if ($return) return $msg;
            echo $msg;
            return;
        }

        $data = apply_filters("intern_{$this->module}_view_data", $data, $view);
        $file = apply_filters("intern_{$this->module}_render_path", $file, $view, $data);
        if (!file_exists($file)) {
            $msg = "<div class='wrap'><div class='notice notice-error'><p>⚠️ File override không tồn tại: <code>{$file}</code></p></div></div>";
            if ($return) return $msg;
            echo $msg;
            return;
        }
        extract($data, EXTR_OVERWRITE);
        ob_start();
        try {
            include $file;
        } catch (Throwable $e) {
            echo "<div class='notice notice-error'><p>❌ Lỗi render view: {$e->getMessage()}</p></div>";
        }
        $content = ob_get_clean();
        do_action("intern_{$this->module}_after_render", $view, $data, $content);
        if ($return) {
            return $content;
        }
        echo $content;
    }


    /**
     * Render view con (partial)
     *
     * @param string $view
     * @param array  $data
     */
    protected function partial(string $view, array $data = []): void{
        $this->render($view, $data, false);
    }

    /**
     * Kiểm tra xem view có tồn tại hay không
     *
     * @param string $view
     * @return bool
     */
    protected function view_exists(string $view): bool{
        $path = INTERN_MANAGEMENT_PATH . "app/views/{$view}.php";
        return file_exists($path);
    }

    /**
     * Trả JSON response
     *
     * @param mixed $data
     * @param bool  $success
     * @param int   $status
     */
    protected function json($data, bool $success = true, int $status = 200): void{
        if ($success) {
            wp_send_json_success($data, $status);
        } else {
            wp_send_json_error($data, $status);
        }
    }

    /**
     * Shortcut cho JSON error
     *
     * @param string|array $message
     * @param int $status
     */
    protected function error($message, int $status = 400): void{
        $this->json(['error' => $message], false, $status);
    }

    /**
     * Shortcut cho JSON success
     *
     * @param mixed $data
     * @param int $status
     */
    protected function success($data, int $status = 200): void{
        $this->json($data, true, $status);
    }

    /**
     * Redirect đến trang admin
     *
     * @param string $page    Slug của page
     * @param array  $params  Tham số GET bổ sung
     * @param bool   $exit    Có dừng script sau redirect không
     */
    protected function redirect(string $page, array $params = [], bool $exit = true): void{
        $url = add_query_arg(array_merge(['page' => $page], $params), admin_url('admin.php'));
        wp_redirect($url);
        if ($exit) exit;
    }
}
