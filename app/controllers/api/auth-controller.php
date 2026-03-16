<?php
namespace InternManagement\App\Controllers\Api;
use InternManagement\Core\ApiController;
use WP_REST_Request;

class AuthController extends ApiController{

    protected function register_routes(): void{
        register_rest_route($this->namespace, '/login', [
            'methods'  => 'POST',
            'callback' => [ $this, 'intern_login' ],
            'permission_callback' => '__return_true'
        ]);
    }

    function intern_login(WP_REST_Request $request){
        $params = $request->get_json_params() ?? $request->get_params();
        if ( empty($params['username']) || empty($params['password']) ) {
            return $this->error('Username hoặc password không được để trống');
        }
        $creds = [
            'user_login' => sanitize_text_field($params['username']),
            'user_password' => $params['password'],
            'remember' => true
        ];
        $user = wp_signon($creds, false);
        if( is_wp_error($user) ){
            return $this->error( $user->get_error_message() );
        }
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);
        do_action('wp_login', $user->user_login, $user);
        return $this->success([
            'id' => $user->ID,
            'name' => $user->display_name,
            'email' => $user->user_email,
            'roles' => $user->roles
        ]);
    }
}