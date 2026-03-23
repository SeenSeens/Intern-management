<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class UserRepository extends BaseRepository {
    protected string $table = 'users';

    public function __construct() {
        parent::__construct( $this->table );
    }

    public function get_users_by_roles( $roles ) {
        $args = [
            'role' => $roles,
            'orderby' => 'id',
            'order' => 'ASC',
            'number' => -1,
        ];

        $user_query = new \WP_User_Query($args);

        $users = [];

        if (!empty($user_query->get_results())) {
            foreach ($user_query->get_results() as $user) {
                $users[] = [
                    'id' => $user->ID,
                    'name' => $user->display_name,
                    'email' => $user->user_email,
                    'avatar' => get_avatar_url($user->ID)
                ];
            }
        }

        return $users;
    }
    public function count_users_by_role(array $roles){
        $user_counts = count_users();
        $result = [];
        foreach ($roles as $role) {
            $result[$role] = $user_counts['avail_roles'][$role] ?? 0;
        }
        return $result;
    }

    public function count_interns(){
        return $this->count_users_by_role(['intern']);
    }
}