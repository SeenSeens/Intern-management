<?php
namespace InternManagement\Core;
if ( ! defined( 'ABSPATH' ) ) exit;
abstract class ApiController{
    protected mixed $service;
    public function __construct($service = null){
        if ($service) $this->service = $service;
    }
    abstract public function index();
    abstract public function create();
    abstract public function edit();
    abstract public function delete();

    protected function json($data = [], $success = true, $status = 200) {
        wp_send_json([
            'success' => $success,
            'data' => $data,
        ], $status);
    }

    protected function error($message, $status = 400) {
        wp_send_json_error(['message' => $message], $status);
    }
}
