<?php
namespace InternManagement\Core;

use Exception;
if ( ! defined( 'ABSPATH' ) ) exit;
abstract class Action {
    protected mixed $service;

    public function __construct($service = null) {
        if ($service) {
            $this->service = $service;
        } else {
            // Tự động tạo service dựa vào tên class nếu có quy ước
            $serviceClass = str_replace(array('Action', 'Actions'), array('Service', 'Services'), get_class($this));
            if (class_exists($serviceClass)) {
                $this->service = new $serviceClass();
            } else {
                throw new \RuntimeException("Service class {$serviceClass} not found");
            }
        }
    }
}
