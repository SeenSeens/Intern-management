<?php
namespace InternManagement\Core;
if ( ! defined( 'ABSPATH' ) ) exit;
class Init {
    private static ?Init $instance = null;
    // Khai báo mảng chứa danh sách template
    private array $custom_templates = [
        'templates/app.php' => 'Intern management',
    ];
    private function __construct(){
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
        Database::instance();
        new Menu();
        // Load Routes
        $this->load_routes();

    }
    private function load_routes(): void{
        require_once plugin_dir_path(INTERN_MANAGEMENT_MAIN_FILE) . '/app/routes/web/admin-post.php';
        require_once plugin_dir_path(INTERN_MANAGEMENT_MAIN_FILE) . '/app/routes/api/api.php';
        require_once plugin_dir_path(INTERN_MANAGEMENT_MAIN_FILE) . '/app/routes/shortcode/index.php';
    }

    private function register_hooks(): void {
        // Add template vào dropdown Page Template
        add_filter('theme_page_templates', [$this, 'register_custom_templates']);
        // Load template từ plugin
        add_filter('template_include', [$this, 'load_custom_template']);

        add_action('init', [ $this, 'rewrite_rule' ]);

        add_filter('query_vars', [ $this, 'add_query_vars' ]);

        add_action('template_redirect', [ $this, 'redirect_to_template' ]);
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
                $plugin_template_path = plugin_dir_path(INTERN_MANAGEMENT_MAIN_FILE) . $chosen_template_slug;
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

    function redirect_to_template() {
        if (get_query_var('intern_api_docs')) {
            require_once INTERN_MANAGEMENT_PATH . '/templates/api-docs.php';
            exit;
        }
    }
}




