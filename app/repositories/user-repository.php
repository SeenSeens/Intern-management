<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserRepository extends BaseRepository {
    protected string $table = 'users';

    public function __construct() {
        parent::__construct( $this->table );
    }

    public function get_users_by_roles( array $roles = [] ): array {
        if (empty($roles)) return [];
        $args = [
            'role__in' => $roles,
            'order_by' => 'id',
            'order' => 'ASC',
            'number' => -1,
        ];
        return get_users($args);
    }
    public function count_users_by_role(array $roles): array{
        $user_counts = count_users();
        $result = [];
        foreach ($roles as $role) {
            $result[$role] = $user_counts['avail_roles'][$role] ?? 0;
        }
        return $result;
    }
    public function get_all_hrs(): array{
        return $this->get_users_by_roles(['hr']);
    }

    public function get_all_pms(): array{
        return $this->get_users_by_roles(['pm']);
    }

    public function get_all_mentors(): array{
        return $this->get_users_by_roles(['mentor']);
    }

    public function get_all_interns(): array{
        return $this->get_users_by_roles(['intern']);
    }

    public function count_interns(): int{
        return $this->count_users_by_role('intern');
    }
}