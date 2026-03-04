<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectInternRepository extends BaseRepository {
    protected string $table = 'intern_project_interns';
    public function __construct() {
        parent::__construct( $this->table );
    }

    public function getProjectInterns(int $project_id){
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

    public function addIntern(int $project_id, int $intern_id, int $assigned_by) {
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

    public function getInternsByProject(int $project_id) {
        $table = $this->db->prefix . 'intern_project_interns';
        return $this->db->get_results($this->db->prepare("
            SELECT u.ID, u.display_name, pi.created_at
            FROM {$table} pi
            JOIN {$this->db->users} u ON u.ID = pi.intern_id
            WHERE pi.project_id = %d
        ", $project_id), OBJECT);
    }

    public function syncInterns(int $project_id, array $intern_ids, int $assigned_by) {
        global $wpdb;
        $table = "{$wpdb->prefix}intern_project_interns";
        $wpdb->delete($table, ['project_id' => $project_id]);
        foreach ($intern_ids as $internId) {
            $wpdb->insert($table, [
                'project_id' => $project_id,
                'intern_id' => $internId,
                'assigned_by' => $assigned_by,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql'),
            ]);
        }
    }

    public function removeIntern(int $project_id, int $intern_id): bool {
        global $wpdb;
        return (bool) $wpdb->delete("{$wpdb->prefix}intern_project_interns", [
            'project_id' => $project_id,
            'intern_id' => $intern_id,
        ]);
    }
}