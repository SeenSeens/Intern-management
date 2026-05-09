<?php
/*
 * Module Name: SMTP
 * Description:
 * Version: 1.0.0
 * Author: Trương Đình Tuấn
 */
namespace InternManagement\Modules\Smtp;
if ( ! defined( 'ABSPATH' ) ) exit;
final class Smtp {
    private static ?Smtp $instance = null;
    public function __construct(){}
    public static function instance(): Smtp{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}