<?php
namespace InternManagement\Modules\Setting\App\Services;
use InternManagement\Modules\Setting\App\Repositories\SettingRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class SettingService {
    protected SettingRepository $repository;
    public function __construct(){
        $this->repository = new SettingRepository();
    }
    /* ================= GENERAL ================= */
    public function get_general(){
        return [
            'timezone' => $this->repository->get('app_timezone', 'Asia/Ho_Chi_Minh'),
            'language' => $this->repository->get('app_language', 'vi'),
            'org_name' => $this->repository->get('app_org_name', ''),
            'org_email'=> $this->repository->get('app_org_email', '')
        ];
    }
    public function update_general(array $data){
        $map = [
            'timezone' => 'app_timezone',
            'language' => 'app_language',
            'org_name' => 'app_org_name',
            'org_email'=> 'app_org_email'
        ];
        foreach ($data as $key => $value){
            if(isset($map[$key])){
                $this->repository->set($map[$key], $value);
            }
        }
        return $this->get_general();
    }
    /* ================= NOTIFICATION ================= */
    public function get_notifications(){
        return $this->repository->get('app_notifications', [
            'assign_new_tasks' => [
                'email' => false,
                'push' => false,
                'in_app' => false
            ],
            'project_update'=> [
                'email' => false,
                'push' => false,
                'in_app' => false
            ],
            'new_message'=> [
                'email' => false,
                'push' => false,
                'in_app' => false
            ],
            'quiet_hours'=> [
                'enable' => false,
                'start_time' => '',
                'end_time' => ''
            ]
        ]);
    }
    public function update_notifications(array $data){
        $this->repository->set('app_notifications', $data);
        return $data;
    }
    /* ================= SYSTEM ================= */
    public function get_system(){
        return $this->repository->get('app_system', [
            'workflow' => 'linear',
            'auto_archive' => true
        ]);
    }
    public function update_system(array $data){
        $this->repository->set('app_system', $data);
        return $data;
    }
}