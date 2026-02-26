<?php
namespace InternManagement\App\Services;
use InternManagement\App\Repositories\UserRepository;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserRepository());
    }

    public function getUsersByRoles( array $roles ){
        return $this->repository->getUsersByRoles( $roles );
    }

    public function getAllHRs(){
        return $this->repository->getAllHRs();
    }

    public function getAllPMs(){
        return $this->repository->getAllPMs();
    }

    public function getAllMentors(){
        return $this->repository->getAllMentors();
    }

    public function getAllInterns(){
        return $this->repository->getAllInterns();
    }

    public function countInterns(){
        return $this->repository->countInterns();
    }
}