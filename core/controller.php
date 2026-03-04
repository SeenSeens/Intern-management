<?php
namespace InternManagement\Core;
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

        // Luôn đăng ký AJAX hooks riêng của controller
        $this->register_ajax_hooks();
    }

    // Load assets

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
        // Xác định đường dẫn template theo module
        $file = INTERN_MANAGEMENT_PATH . '/app/views/' . $view . '.php';

        // Kiểm tra file tồn tại
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

        // Cho phép hook filter dữ liệu view
        // Các module khác có thể thêm/chỉnh dữ liệu
        $data = apply_filters("web366_{$this->module}_view_data", $data, $view);

        // Cho phép hook override file path (theme/module khác có thể thay template)
        $file = apply_filters("web366_{$this->module}_render_path", $file, $view, $data);

        // Nếu file override không tồn tại thì fallback về file gốc
        if (!file_exists($file)) {
            $msg = "<div class='wrap'><div class='notice notice-error'><p>⚠️ File override không tồn tại: <code>{$file}</code></p></div></div>";
            if ($return) return $msg;
            echo $msg;
            return;
        }

        // Chuẩn bị dữ liệu cho view
        extract($data, EXTR_OVERWRITE);

        // Bắt đầu buffer nội dung để có thể return hoặc echo
        ob_start();

        try {
            include $file;
        } catch (\Throwable $e) {
            echo "<div class='notice notice-error'><p>❌ Lỗi render view: {$e->getMessage()}</p></div>";
        }

        $content = ob_get_clean();

        // Hook sau khi render
        do_action("web366_{$this->module}_after_render", $view, $data, $content);

        // Nếu $return = true → trả HTML string
        if ($return) {
            return $content;
        }

        // Ngược lại → in ra màn hình
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
