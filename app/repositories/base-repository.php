<?php
namespace InternManagement\App\Repositories;
use InternManagement\App\Repositories\Interfaces\BaseRepositoryInterface;
use wpdb;
if ( ! defined( 'ABSPATH' ) ) exit;
class BaseRepository implements BaseRepositoryInterface{
    protected wpdb $db;
    private string $table;

    public function __construct( string $table ){
        global $wpdb;
        $this->db = $wpdb;
        $this->table = $wpdb->prefix . $table;
    }

    public function all(){
        return $this->db->get_results("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }

    public function find(int $id) {
        return $this->db->get_row($this->db->prepare("SELECT * FROM {$this->table} WHERE id = %d", $id));
    }

    public function create(array $data) {
        $result = $this->db->insert($this->table, $data);
        if (!$result) {
            error_log('Insert failed: ' . $this->db->last_error);
            error_log('Dữ liệu truyền vào: ' . print_r($data, true));
        }
        return $this->db->insert_id;
    }

    public function update(int $id, array $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete(int $id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

}