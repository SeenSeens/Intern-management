<?php
namespace InternManagement\Includes;

use InternManagement\Includes\Interfaces\BaseRepositoryInterface;
use wpdb;

if ( ! defined( 'ABSPATH' ) ) exit;
class BaseRepository implements BaseRepositoryInterface{
    use QueryBuilder;
    protected wpdb $db;
    protected string $table;
    protected bool $softDelete = true;

    /**
     * @param string $table
     */
    public function __construct( string $table ){
        global $wpdb;
        $this->db = $wpdb;
        $this->table = $wpdb->prefix . $table;
    }

    /**
     * @return array|object|\stdClass[]
     */
    public function all(){
        return $this->select("*")
            ->where_null("deleted_at")
            ->order_by("created_at", "DESC")
            ->get();
    }

    /**
     * @param int $id
     * @return array|object|\stdClass|null
     */
    public function find(int $id) {
        return $this->select("*")
            ->where_null("deleted_at")
            ->where("id", "=", $id)
            ->first();
    }

    /**
     * @param array $data
     * @return false|int
     */
    public function create(array $data) {
        return $this->insert($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data) {
        return $this->where('id', '=', $id)
            ->update_query($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool{
        $this->where('id', '=', $id);
        if ($this->softDelete) {
            return $this->update_query([
                'deleted_at' => current_time('mysql')
            ]);
        }
        return $this->delete_query();
    }

    /**
     * Xóa hàng loạt theo mảng điều kiện
     * Ví dụ: $this->deleteWhere(['task_id' => 5, 'status' => 'pending']);
     * @param array $conditions
     * @return bool
     */
    public function delete_where(array $conditions): bool {
        if (empty($conditions)) {
            return false;
        }
        foreach ($conditions as $column => $value) {
            $this->where($column, '=', $value);
        }
        if ($this->softDelete) {
            return $this->update_query([
                'deleted_at' => current_time('mysql')
            ]);
        }
        return $this->delete_query();
    }

    // Pagination Interface
    /**
     * @param int $page
     * @param int $perPage
     * @param array $filters
     * @param string $orderBy
     * @param string $direction
     * @return array
     */
    public function offset_paginate(int $page = 1, int $perPage = 10, array $filters = [], string $orderBy = 'created_at', string $direction = 'DESC'){
        $offset = max(1, $page);
        $perPage = max(1, $perPage);
        $offset  = ($page - 1) * $perPage;
        $query = $this->from($this->table);
        if ($this->softDelete) {
            $query->where_null('deleted_at');
        }
        foreach ($filters as $column => $value) {
            if ($value === null || $value === '') continue;
            $query->where($column, '=', $value);
        }
        $countQuery = clone $query;
        $total = $countQuery->count();
        $items = $query->select("*")
            ->order_by($orderBy, $direction)
            ->limit($perPage, $offset)
            ->get();
        return [
            'items' => $items,
            'meta' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
            ]
        ];
    }

    /**
     * @param int|null $cursor
     * @param int $limit
     * @param array $filters
     * @param string $cursorColumn
     * @return array
     */
    public function cursor_paginate(?int $cursor = null, int $limit = 10, array $filters = [], string $cursorColumn = 'id'){
        $limit = max(1, $limit);
        $query = $this->from($this->table);
        if ($this->softDelete) {
            $query->where_null('deleted_at');
        }
        foreach ($filters as $column => $value) {
            if ($value === null || $value === '') continue;
            $query->where($column, '=', $value);
        }
        if ($cursor) {
            $query->where($cursorColumn, '<', $cursor);
        }
        $items = $query->select("*")
            ->order_by($cursorColumn, "DESC")
            ->limit($limit)
            ->get();
        $nextCursor = null;
        if (count($items) === $limit) {
            $lastItem = end($items);
            $nextCursor = is_object($lastItem) ? $lastItem->$cursorColumn : $lastItem[$cursorColumn];
        }
        return [
            'data' => $items,
            'next_cursor' => $nextCursor,
            'has_more' => $nextCursor !== null
        ];
    }

    /**
     * @param string $statusColumn
     * @return int[]
     */
    public function stats(string $statusColumn = 'status'): array{
        $where = $this->softDelete
            ? "WHERE deleted_at IS NULL"
            : "";
        $sql = "
            SELECT
                COUNT(*) as total,
                {$statusColumn}
            FROM {$this->table}
            {$where}
            GROUP BY {$statusColumn}
        ";
        $rows = $this->db->get_results($sql, ARRAY_A);
        $result = ['total' => 0];
        foreach ($rows as $row) {
            $result['total'] += (int) $row['total'];
            $result[$row[$statusColumn]] = (int) $row['total'];
        }
        return $result;
    }
}