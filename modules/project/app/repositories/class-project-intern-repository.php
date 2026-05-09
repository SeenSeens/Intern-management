<?php
namespace InternManagement\Modules\Project\App\Repositories;
use Exception;
use InternManagement\Includes\BaseRepository;

if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternRepository extends BaseRepository {
    protected string $table = 'intern_project_interns';
    public function __construct() {
        parent::__construct( $this->table );
    }

    public function get_intern_project(int $project_id){
        $users = $this->db->users;
        $results = $this->from("{$this->table} m")
            ->select('u.ID, u.display_name')
            ->join("$users u", "u.ID = m.intern_id")
            ->where('project_id', '=', $project_id)
            ->get();
        if($results) {
            foreach ($results as $user) {
                $user->avatar = get_avatar_url($user->ID);
            }
        }
        return $results;
    }

    public function sync_project_interns(int $project_id, array $intern_ids, int $assigned_by) {
        foreach ($intern_ids as $intern_id) {
            $result = $this->insert_or_update(
                [
                    'project_id' => $project_id,
                    'intern_id' => $intern_id,
                    'assigned_by' => $assigned_by,
                    'deleted_at' => null
                ],
                ['assigned_by', 'deleted_at']
            );
            if (!$result) {
                throw new Exception("Insert intern failed");
            }
        }
        if (!empty($intern_ids)) {
            $ids = implode(',', array_map('intval', $intern_ids));
            $this->db->query("
                UPDATE {$this->db->prefix}intern_project_interns
                SET deleted_at = NOW()
                WHERE project_id = {$project_id}
                AND intern_id NOT IN ($ids)
            ");
        }
    }

    // Lấy ra danh sách project mà intern đã được giao
    public function get_list_projects_intern_assigned( int $user_id ){
        $projects = $this->db->prefix . 'intern_projects';
        return $this->from("{$this->table} i")
            ->select("p.*")
            ->join("$projects p", "p.id = i.project_id")
            ->where('i.intern_id', '=', $user_id)
            ->where_null("p.deleted_at")
            ->where_null("i.deleted_at")
            ->order_by("p.created_at", "DESC")
            ->get();

    }

    /**
     * Trạng thái project intern đã được giao ( Hiển thị ở index project)
     * @return array|object|\stdClass|null
     */
    public function statistics(int $user_id){
        $projects = $this->db->prefix . 'intern_projects';
        $intern = $this->table;
        return $this->from("$intern i")
            ->select("
                COUNT(CASE WHEN p.STATUS = 'completed' THEN 1 END) AS completed,
                COUNT(CASE WHEN p.STATUS = 'waiting' THEN 1 END) AS waiting,
                COUNT(CASE WHEN p.STATUS = 'on_hold' THEN 1 END) AS on_hold,
                COUNT(CASE WHEN p.STATUS = 'in_progress' THEN 1 END) AS in_progress,
                COUNT(p.id) AS total
            ")
            ->join("$projects p", "p.id = i.project_id")
            ->where("i.intern_id", "=", $user_id)
            ->where_null("p.deleted_at")
            ->where_null("i.deleted_at")
            ->first();
    }
}