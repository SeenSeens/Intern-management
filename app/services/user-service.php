<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\UserRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserRepository());
    }

    public function get_users_by_roles( array $roles ){
        return $this->repository->get_users_by_roles( $roles );
    }

    public function get_all_hrs(){
        return $this->repository->get_all_hrs();
    }

    public function get_all_pms(){
        return $this->repository->get_all_pms();
    }

    public function get_all_mentors(){
        return $this->repository->get_all_mentors();
    }

    public function get_all_interns(){
        return $this->repository->get_all_interns();
    }
    public function count_interns(){
        return $this->repository->count_interns();
    }
    public function count_users_by_role(array $role){
        return $this->repository->count_users_by_role($role);
    }
}