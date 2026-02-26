<?php
namespace InternManagement\Core;
if ( ! defined( 'ABSPATH' ) ) exit;
abstract class Controller{
    protected mixed $service;
    public function __construct($service = null){
        if ($service) $this->service = $service;
    }
    abstract public function index();
    abstract public function create();
    abstract public function edit();
    abstract public function delete();
    abstract public function store();

    protected function render(string $view, array $data = []): void{
        $file = plugin_dir_path( INTERN_MANAGEMENT_MAIN_FILE ) . '/app/views/' . $view . '.php';
        if (!file_exists($file)) {n
            ?>
            <div class="wrap">
                <h1>Quản lý thực tập sinh</h1>
                <div class="notice notice-error">
                    <p>⚠️ Giao diện chưa được tạo: <code> <?= esc_html($view) ?></code></p>
                </div>
            </div>
            <?php
            return;
        }
        extract($data);
        require_once $file;
    }
}
