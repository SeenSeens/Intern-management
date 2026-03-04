<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserRepository extends BaseRepository {
    protected string $table = 'users';

    public function __construct() {
        parent::__construct( $this->table );
    }

    public function getUsersByRoles( array $roles = [] ): array {
        if (empty($roles)) return [];
        $args = [
            'role__in' => $roles,
            'orderby' => 'display_name',
            'order' => 'ASC',
            'number' => -1,
        ];
        return get_users($args);
    }
    public function countUsersByRole(string $role_key): int {
        $user_counts = count_users();
        if (isset($user_counts['avail_roles'][$role_key])) {
            return (int) $user_counts['avail_roles'][$role_key];
        }
        return 0;
    }
    public function getAllHRs(){
        return $this->getUsersByRoles(['hr']);
    }

    public function getAllPMs(){
        return $this->getUsersByRoles(['pm']);
    }

    public function getAllMentors(){
        return $this->getUsersByRoles(['mentor']);
    }

    public function getAllInterns(){
        return $this->getUsersByRoles(['intern']);
    }

    public function countInterns(){
        return $this->countUsersByRole('intern');
    }
}