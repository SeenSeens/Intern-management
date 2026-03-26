<?php

namespace InternManagement\App\Repositories;
use Exception;

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

    public function sync_project_mentors(int $project_id, array $mentor_ids, int $assigned_by) {
        foreach ($mentor_ids as $mentor_id) {
            error_log("👉 Insert mentor: " . $mentor_id);
            $result = $this->insert_or_update(
                [
                    'project_id' => $project_id,
                    'mentor_id' => $mentor_id,
                    'assigned_by' => $assigned_by,
                    'deleted_at' => null
                ],
                ['assigned_by', 'deleted_at'] // nếu trùng thì update
            );
            if (!$result) {
                error_log("❌ Mentor insert fail: " . $this->db->last_error);
                throw new Exception("Insert mentor failed");
            }
        }

        // soft delete những thằng không còn
        if (!empty($mentor_ids)) {
            $ids = implode(',', array_map('intval', $mentor_ids));
            $this->db->query("
                UPDATE $this->table
                SET deleted_at = NOW()
                WHERE project_id = {$project_id}
                AND mentor_id NOT IN ($ids)
            ");
        }
    }

}