<?php
namespace InternManagement\App\Repositories;
use InternManagement\App\Repositories\Interfaces\BaseRepositoryInterface;
use wpdb;
if ( ! defined( 'ABSPATH' ) ) exit;
class BaseRepository implements BaseRepositoryInterface{
    protected wpdb $db;
    protected string $table;
    protected bool $softDelete = true;
    public function __construct( string $table ){
        global $wpdb;
        $this->db = $wpdb;
        $this->table = $wpdb->prefix . $table;
    }

    public function all(){
        $where = $this->softDelete ? "WHERE deleted_at IS NULL" : "";
        return $this->db->get_results("SELECT * FROM {$this->table} {$where} ORDER BY created_at DESC");
    }

    public function find(int $id) {
        $where = $this->softDelete ? "AND deleted_at IS NULL" : "";
        return $this->db->get_row($this->db->prepare("SELECT * FROM {$this->table} WHERE id = %d {$where}", $id));
    }

    public function create(array $data) {
        $result = $this->db->insert($this->table, $data);
        if (!$result) {
            error_log('Insert failed: ' . $this->db->last_error);
            error_log('Dữ liệu truyền vào: ' . print_r($data, true));
        }
        return (int) $this->db->insert_id;
    }

    public function update(int $id, array $data) {
        return (bool) $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete(int $id) {
        if ($this->softDelete) {
            return (bool) $this->db->update(
                $this->table,
                ['deleted_at' => current_time('mysql')],
                ['id' => $id]
            );
        }
        return (bool) $this->db->delete($this->table, ['id' => $id]);
    }

    public function offset_paginate(int $page = 1, int $perPage = 10, array $filters = [], string $orderBy = 'created_at', string $direction = 'DESC'){
        $offset = max(1, $page);
        $perPage = max(1, $perPage);
        $offset  = ($page - 1) * $perPage;
        $where  = [];
        $params = [];

        if ($this->softDelete) {
            $where[] = "deleted_at IS NULL";
        }

        foreach ($filters as $column => $value) {
            if ($value === null || $value === '') continue;

            $where[] = "{$column} = %s";
            $params[] = $value;
        }

        $whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";
        // Count total
        $countSql = "SELECT COUNT(*) FROM {$this->table} {$whereSql}";
        $total = empty( $params ) ? (int) $this->db->get_var($countSql) : (int) $this->db->get_var( $this->db->prepare($countSql, ...$params) );

        // Get data
        $dataSql = "
            SELECT *
            FROM {$this->table}
            {$whereSql}
            ORDER BY {$orderBy} {$direction}
            LIMIT %d OFFSET %d,
        ";

        $queryParams = array_merge($params, [$perPage, $offset]);

        $items = empty($params)
            ? $this->db->get_results(
                $this->db->prepare(
                "
                SELECT *
                FROM {$this->table}
                WHERE deleted_at IS NULL
                ORDER BY created_at DESC
                LIMIT %d OFFSET %d
                ",
                    $perPage,
                    $offset
                ),
            )
            : $this->db->get_results(
            $this->db->prepare($dataSql, ...$queryParams)
        );

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

    public function cursor_paginate(?int $cursor = null, int $limit = 10, array $filters = [], string $cursorColumn = 'id'){
        $limit = max(1, $limit);

        $where = [];
        $params = [];

        if ($this->softDelete) {
            $where[] = "deleted_at IS NULL";
        }

        foreach ($filters as $column => $value) {
            if ($value === null || $value === '') continue;

            $where[] = "{$column} = %s";
            $params[] = $value;
        }

        if ($cursor) {
            $where[] = "{$cursorColumn} < %d";
            $params[] = $cursor;
        }

        $whereSql = count($where)
            ? "WHERE " . implode(" AND ", $where)
            : "";

        $sql = "
            SELECT *
            FROM {$this->table}
            {$whereSql}
            ORDER BY {$cursorColumn} DESC
            LIMIT %d
        ";

        $params[] = $limit;

        $items = $this->db->get_results(
            $this->db->prepare($sql, ...$params),
        );

        $nextCursor = count($items) === $limit
            ? end($items)[$cursorColumn]
            : null;

        return [
            'data' => $items,
            'next_cursor' => $nextCursor,
            'has_more' => $nextCursor !== null
        ];
    }

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