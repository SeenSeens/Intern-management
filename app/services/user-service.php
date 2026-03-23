<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\UserRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserRepository());
    }

    public function get_users_by_roles( $roles ){
        return $this->repository->get_users_by_roles( $roles );
    }

    public function count_interns(){
        return $this->repository->count_interns();
    }
    public function count_users_by_role(array $role){
        return $this->repository->count_users_by_role($role);
    }
}