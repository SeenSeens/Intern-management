<?php
namespace InternManagement\Modules\setting\app\controllers;
use InternManagement\Includes\ApiController;
use InternManagement\Modules\Setting\App\Services\SettingService;
use WP_REST_Request;
use WP_REST_Server;

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
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_general'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'update_general'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        /* NOTIFICATION */
        register_rest_route($this->namespace, '/settings/notifications', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_notifications'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'update_notifications'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
        /* SYSTEM */
        register_rest_route($this->namespace, '/settings/system', [
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [$this, 'get_system'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ],
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [$this, 'update_system'],
                'permission_callback' => function(WP_REST_Request $request) {
                    return $this->check_permission($request, []);
                }
            ]
        ]);
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