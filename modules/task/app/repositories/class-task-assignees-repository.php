<?php
namespace InternManagement\Modules\Task\App\Repositories;
use InternManagement\Includes\BaseRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssigneesRepository extends BaseRepository{
    protected string $table = 'intern_task_assignees';

    public function __construct() {
        parent::__construct( $this->table );
    }

    public function get_intern_assign_by_task_id( int $task_id ) {
        global $wpdb;
        $table_task_assignees = $wpdb->prefix . $this->table;
        return $this->db->get_results(
            $this->db->prepare(
                "
                        SELECT u.ID, u.display_name, u.user_email, ta.created_at
                        FROM {$table_task_assignees} ta
                        JOIN {$wpdb->users} u ON ta.user_id = u.ID
                        WHERE ta.task_id = %d AND ta.deleted_at IS NULL
                        ",
                $task_id
            )
        );
    }

    public function delete_task_assignees_by_task_id(int $task_id): bool{
        $this->where('task_id', '=', $task_id);
        if ($this->softDelete) {
            return $this->update_query([
                'deleted_at' => current_time('mysql')
            ]);
        }
        return $this->delete_query();
    }

}