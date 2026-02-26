<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class AssignMemberProjectRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('intern_projects');
    }
    public function syncMembers(int $project_id, array $mentor_ids, array $intern_ids, int $assigned_by) {
        global $wpdb;
        $mentor_table = "{$wpdb->prefix}intern_project_mentors";
        $intern_table = "{$wpdb->prefix}intern_project_interns";
        $wpdb->delete($mentor_table, ['project_id' => $project_id]);
        $wpdb->delete($intern_table, ['project_id' => $project_id]);
        foreach ($mentor_ids as $mentor_id) {
            $wpdb->insert($mentor_table, [
                'project_id' => $project_id,
                'mentor_id' => $mentor_id,
                'assigned_by' => $assigned_by,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ]);
        }
        foreach ($intern_ids as $intern_id) {
            $wpdb->insert($intern_table, [
                'project_id' => $project_id,
                'intern_id' => $intern_id,
                'assigned_by' => $assigned_by,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ]);
        }
    }





}