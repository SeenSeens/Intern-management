<?php
namespace InternManagement\App\Repositories;
use Exception;

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
    public function get_project_interns(int $project_id){
        global $wpdb;
        $table_project_interns = $wpdb->prefix . $this->table;
        $users_table = $wpdb->users;
        $sql = "
            SELECT u.ID, u.display_name
            FROM $table_project_interns pi
            JOIN $users_table u ON pi.intern_id = u.ID
            WHERE pi.project_id = %d AND pi.deleted_at IS NULL
        ";
        return $wpdb->get_results($wpdb->prepare($sql, $project_id));
    }

    public function add_intern(int $project_id, int $intern_id, int $assigned_by) {
        global $wpdb;
        $result = false;
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}intern_project_interns WHERE project_id = %d AND intern_id = %d",
            $project_id, $intern_id
        ));
        if (!$exists) {
            $result = $wpdb->insert("{$wpdb->prefix}intern_project_interns", [
                'project_id' => $project_id,
                'intern_id' => $intern_id,
                'assigned_by' => $assigned_by,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ]);
            if (!$result) error_log("[DB Error] addIntern: " . $wpdb->last_error);
        }
        return (bool) $result;
    }

    public function get_interns_by_project(int $project_id) {
        $table = $this->db->prefix . 'intern_project_interns';
        return $this->db->get_results($this->db->prepare("
            SELECT u.ID, u.display_name, pi.created_at
            FROM {$table} pi
            JOIN {$this->db->users} u ON u.ID = pi.intern_id
            WHERE pi.project_id = %d
        ", $project_id), OBJECT);
    }

    public function sync_project_interns(int $project_id, array $intern_ids, int $assigned_by) {
        foreach ($intern_ids as $intern_id) {
            //error_log("👉 Insert intern: " . $intern_id);
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
                //error_log("❌ Intern insert fail: " . $this->db->last_error);
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

    public function remove_intern(int $project_id, int $intern_id): bool {
        global $wpdb;
        return (bool) $wpdb->delete("{$wpdb->prefix}intern_project_interns", [
            'project_id' => $project_id,
            'intern_id' => $intern_id,
        ]);
    }
}