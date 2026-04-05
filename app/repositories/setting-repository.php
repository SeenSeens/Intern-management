<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class SettingRepository{
    public function get(string $key, $default = null){
        return get_option($key, $default);
    }

    public function set(string $key, $value){
        return update_option($key, $value);
    }

    public function getMany(array $keys){
        $data = [];
        foreach ($keys as $key){
            $data[$key] = get_option($key);
        }
        return $data;
    }

    public function setMany(array $data){
        foreach ($data as $key => $value){
            update_option($key, $value);
        }
        return true;
    }
}