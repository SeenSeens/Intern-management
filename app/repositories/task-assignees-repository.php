<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class TaskAssigneesRepository extends BaseRepository{
    protected string $table = 'intern_task_assignees';

    public function __construct() {
        parent::__construct( $this->table );
    }

    public function getInternAssignByTaskId( int $task_id ) {
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

}