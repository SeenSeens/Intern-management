<?php
namespace InternManagement\Core;
if ( ! defined( 'ABSPATH' ) ) exit;
class Init {
    private static ?Init $instance = null;
    // Khai báo mảng chứa danh sách template
    private array $custom_templates = [
        'templates/app.php' => 'Intern management',
    ];
    public function __construct(){
        $this->load_dependencies();
        $this->register_hooks();
    }
    public static function instance(): Init{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function load_dependencies(): void{
        // Khởi tạo các thành phần cốt lõi
        Role::instance();
        // Load Routes
        $this->load_routes();

    }
    private function load_routes(): void{
        require_once INTERN_MANAGEMENT_PATH . '/app/routes/api/api.php';
    }
    private function register_hooks(): void {
        add_filter('theme_page_templates', [$this, 'register_custom_templates']);
        add_filter('template_include', [$this, 'load_custom_template']);
        add_action('init', [ $this, 'rewrite_rule' ]);
        add_filter('query_vars', [ $this, 'add_query_vars' ]);
        add_action('template_redirect', [ $this, 'redirect_to_template' ]);
        add_filter('determine_current_user', [ $this, 'identify_user' ], 20 );
        add_action('rest_api_init', [$this, 'enable_cors']);
    }
    // Thêm template vào dropdown trong Page Attributes
    public function register_custom_templates(array $templates): array{
        // Hợp nhất template của theme và template của plugin
        return array_merge($templates, $this->custom_templates);
    }
    // Load file template từ plugin thay vì theme
    public function load_custom_template($template) {
        if (is_page()) {
            // Lấy slug của template được chọn trong trang hiện tại
            $chosen_template_slug = get_page_template_slug(get_queried_object_id());
            // Kiểm tra: Nếu slug này nằm trong danh sách template của plugin mình
            if (isset($this->custom_templates[$chosen_template_slug])) {
                // Tạo đường dẫn tuyệt đối đến file template trong plugin
                $plugin_template_path = INTERN_MANAGEMENT_PATH . $chosen_template_slug;
                // Nếu file tồn tại thì trả về file đó, ngắt luồng của WP
                if (file_exists($plugin_template_path)) {
                    return $plugin_template_path;
                }
            }
        }
        // Nếu không phải template của mình, trả về template mặc định của WP
        return $template;
    }
    function rewrite_rule() {
        add_rewrite_rule(
            '^intern-api-docs/?$',
            'index.php?intern_api_docs=1',
            'top'
        );
    }
    function add_query_vars ($vars) {
        $vars[] = 'intern_api_docs';
        return $vars;
    }
    function redirect_to_template(): void{
        if (get_query_var('intern_api_docs')) {
            require_once INTERN_MANAGEMENT_PATH . '/templates/api-docs.php';
            exit;
        }
    }
    function identify_user($user_id) {
        if ($user_id <= 0 && isset($_COOKIE[LOGGED_IN_COOKIE])) {
            // Giải mã cookie để tìm User ID nếu WordPress chưa kịp nhận diện
            $valid_user_id = wp_validate_auth_cookie('', 'logged_in');
            if ($valid_user_id) {
                return $valid_user_id;
            }
        }
        return $user_id;
    }
    public function enable_cors(): void{
        remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
        add_filter('rest_pre_serve_request', function ($value) {
            header('Access-Control-Allow-Origin: http://wordpress.local:5173');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Nonce');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            return $value;
        });
    }
}