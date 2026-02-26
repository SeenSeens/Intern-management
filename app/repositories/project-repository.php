<?php
namespace InternManagement\App\Repositories;
if ( ! defined( 'ABSPATH' ) ) exit;
class ProjectRepository extends BaseRepository {
    private string $table = 'intern_projects';

    public function __construct() {
        parent::__construct( $this->table );
    }
    public function countProject(){
        global $wpdb;
        $table_project = "{$wpdb->prefix}{$this->table}";
        return $this->db->get_var(
            $wpdb->prepare("SELECT COUNT(*) FROM $table_project")
        );
    }
}