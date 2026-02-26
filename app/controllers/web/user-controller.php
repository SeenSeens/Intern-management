<?php
namespace InternManagement\App\Controllers\Web;
use InternManagement\App\Services\UserService;
use InternManagement\Core\Controller;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserController extends Controller {

    public function __construct() {
        parent::__construct(new UserService());
    }

    public function index(){
        $users = $this->service->getUsersByRoles( [ 'project_manager', 'hr', 'mentor', 'intern' ] );
        $grouped = [
            'project_managers' => [],
            'hrs' => [],
            'mentors'     => [],
            'interns'     => [],
        ];
        foreach ($users as $user) {
            if (in_array('intern', $user->roles, true)) {
                $grouped['interns'][] = $user;
            }
            if (in_array('mentor', $user->roles, true)) {
                $grouped['mentors'][] = $user;
            }
            if (in_array('project_manager', $user->roles, true)) {
                $grouped['project_managers'][] = $user;
            }
            if (in_array('hr', $user->roles, true)) {
                $grouped['hrs'][] = $user;
            }
        }
        $this->render( 'user/index', $grouped );
    }

    public function create(){

    }

    public function edit(){

    }

    public function delete(){

    }

    public function store(){

    }

}