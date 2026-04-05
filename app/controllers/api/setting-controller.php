<?php
namespace InternManagement\App\Controllers\Api;
use InternManagement\App\Services\SettingService;
use InternManagement\Core\ApiController;
use WP_REST_Request;
if ( ! defined( 'ABSPATH' ) ) exit;
class SettingController extends ApiController{
    protected SettingService $settingService;
    public function __construct(){
        parent::__construct();
        $this->settingService = new SettingService();
    }
    protected function register_routes(): void{
        /* GENERAL */
        register_rest_route($this->namespace, '/settings/general', [
            [
                'methods' => 'GET',
                'callback' => [$this, 'get_general'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods' => 'POST',
                'callback' => [$this, 'update_general'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        /* NOTIFICATION */
        register_rest_route($this->namespace, '/settings/notifications', [
            [
                'methods' => 'GET',
                'callback' => [$this, 'get_notifications'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods' => 'POST',
                'callback' => [$this, 'update_notifications'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
        /* SYSTEM */
        register_rest_route($this->namespace, '/settings/system', [
            [
                'methods' => 'GET',
                'callback' => [$this, 'get_system'],
                'permission_callback' => [$this, 'permission']
            ],
            [
                'methods' => 'POST',
                'callback' => [$this, 'update_system'],
                'permission_callback' => [$this, 'permission']
            ]
        ]);
    }
    public function permission(): bool{
        return $this->require_login();
    }
    /* ========= GENERAL ========= */
    public function get_general(){
        return [
            'success' => true,
            'data' => $this->settingService->get_general()
        ];
    }
    public function update_general(WP_REST_Request $request){
        $params = $request->get_json_params();
        return [
            'success' => true,
            'data' => $this->settingService->update_General($params)
        ];
    }
    /* ========= NOTIFICATION ========= */
    public function get_notifications(){
        return [
            'success' => true,
            'data' => $this->settingService->get_notifications()
        ];
    }
    public function update_notifications(WP_REST_Request $request){
        $params = $request->get_json_params();
        return [
            'success' => true,
            'data' => $this->settingService->update_notifications($params)
        ];
    }
    /* ========= SYSTEM ========= */
    public function get_system(){
        return [
            'success' => true,
            'data' => $this->settingService->get_system()
        ];
    }
    public function update_system(WP_REST_Request $request){
        $params = $request->get_json_params();
        return [
            'success' => true,
            'data' => $this->settingService->update_system($params)
        ];
    }
}