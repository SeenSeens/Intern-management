<?php
namespace InternManagement\App\Controllers\Api;
use InternManagement\Core\ApiController;

class TaskController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function register_routes(): void{
        register_rest_route($this->namespace, '/tasks', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'index'],
                'permission_callback' => '__return_true',
                //'permission_callback' => [$this, 'permission']
            ]
        ]);

        register_rest_route($this->namespace, '/task', [
            [
                'methods'  => 'POST',
                'callback' => [$this, 'store'],
                'permission_callback' => '__return_true',
                //'permission_callback' => [$this, 'permission']
            ]
        ]);

        register_rest_route($this->namespace, '/task/(?P<id>\d+)', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'show'],
                'permission_callback' => '__return_true'
            ],
            [
                'methods'  => 'PUT',
                'callback' => [$this, 'update'],
                'permission_callback' => '__return_true'
            ],
            [
                'methods'  => 'DELETE',
                'callback' => [$this, 'destroy'],
                'permission_callback' => '__return_true'
            ]
        ]);
    }
    private function permission(): bool{
        return $this->require_login();
    }
}