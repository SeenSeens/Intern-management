<?php

namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorRepository extends BaseRepository{
    private string $table = 'intern_project_mentors';
    public function __construct(){
        parent::__construct($this->table);
    }

    public function addMentor(int $project_id, int $mentor_id, int $assigned_by) {
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

    // ProjectRepository.php
    public function getMentorsByProject(int $project_id) {
        $table = $this->db->prefix . 'intern_project_mentors';
        return $this->db->get_results($this->db->prepare("
            SELECT u.ID, u.display_name, pm.created_at
            FROM {$table} pm
            JOIN {$this->db->users} u ON u.ID = pm.mentor_id
            WHERE pm.project_id = %d
        ", $project_id), OBJECT);
    }

    public function syncMentors(int $project_id, array $mentor_ids, int $assigned_by) {
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

    public function removeMentor(int $project_id, int $mentor_id): bool {
        global $wpdb;
        return (bool) $wpdb->delete("{$wpdb->prefix}intern_project_mentors", [
            'project_id' => $project_id,
            'mentor_id' => $mentor_id,
        ]);
    }

}