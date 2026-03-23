<?php

namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorRepository extends BaseRepository{
    protected string $table = 'intern_project_mentors';
    public function __construct(){
        parent::__construct($this->table);
    }
    public function get_mentor_project(int $project_id){
        $users = $this->db->users;
        $results = $this->from("{$this->table} m")
            ->select('u.id, u.display_name')
            ->join("$users u", "u.ID = m.mentor_id")
            ->where('project_id', '=', $project_id)
            ->get();
        foreach ($results as &$user) {
            $user->avatar = get_avatar_url($user->ID);
        }
        return $results;
    }
    public function add_mentor(int $project_id, int $mentor_id, int $assigned_by) {
        global $wpdb;
        $result = false;
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}intern_project_mentors WHERE project_id = %d AND mentor_id = %d",
            $project_id, $mentor_id
        ));
        if (!$exists) {
            $result = $wpdb->insert("{$wpdb->prefix}intern_project_mentors", [
                'project_id' => $project_id,
                'mentor_id' => $mentor_id,
                'assigned_by' => $assigned_by,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ]);
            if (!$result) error_log("[DB Error] addMentor: " . $wpdb->last_error);
        }
        return (bool) $result;
    }


    public function sync_mentors(int $project_id, array $mentor_ids, int $assigned_by) {
        global $wpdb;
        $table = "{$wpdb->prefix}intern_project_mentors";
        $wpdb->delete($table, ['project_id' => $project_id]);
        foreach ($mentor_ids as $mentor_id) {
            $wpdb->insert($table, [
                'project_id' => $project_id,
                'mentor_id' => $mentor_id,
                'assigned_by' => $assigned_by,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ]);
        }
    }

    public function remove_mentor(int $project_id, int $mentor_id): bool {
        global $wpdb;
        return (bool) $wpdb->delete("{$wpdb->prefix}intern_project_mentors", [
            'project_id' => $project_id,
            'mentor_id' => $mentor_id,
        ]);
    }

}