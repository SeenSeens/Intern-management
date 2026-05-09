<?php
namespace InternManagement\Modules\Project\App\Repositories;
use Exception;
use InternManagement\Includes\BaseRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectMentorRepository extends BaseRepository{
    protected string $table = 'intern_project_mentors';
    public function __construct(){
        parent::__construct($this->table);
    }

    /**
     * Lấy mentor trong 1 project
     * @param int $project_id
     * @return array|object|\stdClass[]
     */
    public function get_mentor_project(int $project_id){
        $users = $this->db->users;
        $results = $this->from("{$this->table} m")
            ->select('u.ID, u.display_name')
            ->join("$users u", "u.ID = m.mentor_id")
            ->where('project_id', '=', $project_id)
            ->where_null("deleted_at")
            ->get();

        if ($results){
            foreach ($results as $user) {
                $user->avatar = get_avatar_url($user->ID);
            }
        }
        return $results;
    }

    /**
     * @param int $project_id
     * @param array $mentor_ids
     * @param int $assigned_by
     * @return void
     * @throws Exception
     */
    public function sync_project_mentors(int $project_id, array $mentor_ids, int $assigned_by) {
        foreach ($mentor_ids as $mentor_id) {
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

    // Lấy ra danh sách project mà mentor đã được giao
    public function get_list_projects_mentor_assigned(int $user_id){
        $projects = $this->db->prefix . 'intern_projects';
        return $this->from("{$this->table} m")
            ->select("p.*")
            ->join("$projects p", "p.id = m.project_id")
            ->where('m.mentor_id', '=', $user_id)
            ->where_null("p.deleted_at")
            ->where_null("m.deleted_at")
            ->order_by("p.created_at", "DESC")
            ->get();
    }
    /**
     * Trạng thái project mentor đã được giao ( Hiển thị ở index project)
     * @return array|object|\stdClass|null
     */
    public function statistics(int $user_id){
        $projects = $this->db->prefix . 'intern_projects';
        $mentor = $this->table;
        return $this->from("$mentor m")
            ->select("
                COUNT(CASE WHEN p.STATUS = 'completed' THEN 1 END) AS completed,
                COUNT(CASE WHEN p.STATUS = 'waiting' THEN 1 END) AS waiting,
                COUNT(CASE WHEN p.STATUS = 'on_hold' THEN 1 END) AS on_hold,
                COUNT(CASE WHEN p.STATUS = 'in_progress' THEN 1 END) AS in_progress,
                COUNT(p.id) AS total
            ")
            ->join("$projects p", "p.id = m.project_id")
            ->where('m.mentor_id', '=', $user_id)
            ->where_null("p.deleted_at")
            ->where_null("m.deleted_at")
            ->first();
    }
}