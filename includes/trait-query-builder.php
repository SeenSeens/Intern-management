<?php
namespace InternManagement\Includes;
if ( ! defined( 'ABSPATH' ) ) exit;
trait QueryBuilder {
    protected string $queryTable = '';
    protected string $where = '';
    protected string $operator = '';
    protected string $selectField = '*';
    protected string $limit = '';
    protected string $orderBy = '';
    protected string $innerJoin = '';
    protected array $groupConcatFields = [];
    protected string $groupBy = '';
    protected array $bindings = [];

    public function from($table): static{
        $this->queryTable = $table;
        return $this;
    }

    public function where( $field, $compare, $value ): static{
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        if($value === null){
            $this->where .= "{$this->operator} {$field} {$compare} NULL";
        } else {
            $this->where .= "{$this->operator} {$field} {$compare} %s";
            $this->bindings[] = $value;
        }
        return $this;
    }

    public function or_where( $field, $compare, $value ): static{
        $this->operator = empty($this->where) ? ' WHERE ' : ' OR ';
        $this->where .= "{$this->operator} {$field} {$compare} %s";
        $this->bindings[] = $value;
        return $this;
    }

    public function where_like( $field, $value ): static{
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} LIKE %s";
        $this->bindings[] = $value;
        return $this;
    }

    public function where_null($field): static{
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} IS NULL";
        return $this;
    }

    public function where_not_null($field): static{
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} IS NOT NULL";
        return $this;
    }

    public function select( $field = '*' ): static{
        $this->selectField = $field;
        return $this;
    }

    public function limit( $number, $offset = 0 ): static{
        $number = intval($number);
        $offset = intval($offset);
        $this->limit = "LIMIT {$offset}, {$number}";
        return $this;
    }

    public function order_by( $field, $type = 'ASC' ): static{
        $fieldArr = array_filter( explode(',', $field) );
        if ( !empty($fieldArr) && count($fieldArr) >= 2 ) {
            $this->orderBy = "ORDER BY " . implode(', ', $fieldArr);
        } else {
            $this->orderBy = "ORDER BY {$field} {$type}";
        }
        return $this;
    }

    public function group_by( $field ): static{
        $this->groupBy = "GROUP BY {$field}";
        return $this;
    }

    public function join($table, $relationShip ): static{
        $this->innerJoin .= " INNER JOIN {$table} ON {$relationShip} ";
        return $this;
    }

    public function left_join($table, $relationship ): static{
        $this->innerJoin .= " LEFT JOIN {$table} ON {$relationship} ";
        return $this;
    }

    public function group_concat($field, $alias = null, $separator = ', ', $distinct = false, $orderBy = null, $condition = null): static{
        $gc = "GROUP_CONCAT(";
        if ($distinct) $gc .= "DISTINCT ";
        if ($condition) {
            $gc .= "CASE WHEN $condition THEN $field END";
        } else {
            $gc .= $field;
        }
        if ($orderBy) {
            $gc .= " ORDER BY $orderBy";
        }
        $gc .= " SEPARATOR '$separator')";
        if ($alias) {
            $gc .= " AS $alias";
        }
        $this->groupConcatFields[] = $gc;
        return $this;
    }

    /**
     * TRUY XUẤT NHIỀU BẢN GHI (Tương đương fetchAll)
     */
    public function get(): array|object{
        if (!empty($this->groupConcatFields)) {
            if ($this->selectField === '*') {
                $this->selectField = implode(', ', $this->groupConcatFields);
            } else {
                $this->selectField .= ', ' . implode(', ', $this->groupConcatFields);
            }
        }
        $currentTable = !empty($this->queryTable) ? $this->queryTable : $this->table;
        $sqlQuery = "SELECT {$this->selectField} FROM {$currentTable} {$this->innerJoin} {$this->where} {$this->groupBy} {$this->orderBy} {$this->limit}";
        $sqlQuery = trim($sqlQuery);
        // Bảo mật với wpdb->prepare nếu có điều kiện WHERE
        if ( !empty($this->bindings) ) {
            $sqlQuery = $this->db->prepare( $sqlQuery, $this->bindings );
        }
        $results = $this->db->get_results( $sqlQuery );
        $this->reset_query();
        return $results ?: [];
    }

    /**
     * TRUY XUẤT 1 BẢN GHI (Tương đương fetch)
     */
    public function first() {
        $this->limit(1);
        $currentTable = !empty($this->queryTable) ? $this->queryTable : $this->table;
        $sqlQuery = "SELECT {$this->selectField} FROM {$currentTable} {$this->innerJoin} {$this->where} {$this->groupBy} {$this->orderBy} {$this->limit}";
        $sqlQuery = trim($sqlQuery);
        if ( !empty($this->bindings) ) {
            $sqlQuery = $this->db->prepare( $sqlQuery, $this->bindings );
        }
        $result = $this->db->get_row( $sqlQuery );
        $this->reset_query();
        return $result ?: null;
    }

    /**
     * THÊM DỮ LIỆU
     */
    public function insert( $data ): bool|int{
        $result = $this->db->insert( $this->table, $data );
        $this->reset_query();
        if ($result === false) {
            return false;
        }
        return $this->db->insert_id;
    }

    public function last_id(): int{
        return $this->db->insert_id;
    }

    /**
     * CẬP NHẬT DỮ LIỆU (Kết hợp với hàm where)
     */
    public function update_query( array $data ): bool{
        if (empty($this->where)) return false;
        $setList = [];
        $updateBindings = [];
        foreach ( $data as $column => $value ) {
            $setList[] = "{$column} = %s";
            $updateBindings[] = $value;
        }
        $setSql = implode( ', ', $setList );
        $sql = "UPDATE {$this->table} SET {$setSql} {$this->where}";
        $allBindings = array_merge( $updateBindings, $this->bindings );
        if ( !empty($allBindings) ) {
            $sql = $this->db->prepare( $sql, $allBindings );
        }
        $result = $this->db->query( $sql );
        $this->reset_query();
        return $result !== false;
    }

    /**
     * XÓA DỮ LIỆU (Kết hợp với hàm where)
     */
    public function delete_query(): bool{
        if ( empty($this->where) ) {
            return false;
        }
        $sql = "DELETE FROM {$this->table} {$this->where}";
        if ( !empty($this->bindings) ) {
            $sql = $this->db->prepare( $sql, $this->bindings );
        }
        $result = $this->db->query( $sql );
        $this->reset_query();
        return $result !== false;
    }

    /**
     * THÊM HOẶC CẬP NHẬT (ON DUPLICATE KEY UPDATE)
     * @param $data
     * @param $updateFields
     * @param $parentId
     * @param $parentKey
     * @return bool
     */
    public function insert_or_update( $data, $updateFields = [], $parentId = null, $parentKey = '' ): bool{
        if ( $parentId !== null && $parentKey !== '' ) {
            $data[$parentKey] = $parentId;
        }
        $columns = [];
        $placeholders = [];
        $values = [];
        foreach ($data as $column => $value) {
            $columns[] = "`{$column}`";
            if (is_null($value)) {
                $placeholders[] = "NULL";
            } elseif (is_int($value)) {
                $placeholders[] = "%d";
                $values[] = $value;
            } elseif (is_float($value)) {
                $placeholders[] = "%f";
                $values[] = $value;
            } else {
                $placeholders[] = "%s";
                $values[] = $value;
            }
        }
        $updateQuery = '';
        if ( !empty($updateFields) ) {
            $updateSet = [];
            foreach ( $updateFields as $field ) {
                $updateSet[] = "`{$field}` = VALUES(`{$field}`)";
            }
            $updateQuery = 'ON DUPLICATE KEY UPDATE ' . implode( ', ', $updateSet );
        }
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s) %s",
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders),
            $updateQuery
        );
        if (!empty($values)) {
            $sql = $this->db->prepare($sql, $values);
        }
        $result = $this->db->query( $sql );
        if ($result === false) {
            error_log("❌ SQL ERROR: " . $this->db->last_error);
            error_log("❌ SQL: " . $sql);
        }
        $this->reset_query();
        return $result !== false;
    }

    /**
     * Đếm số lượng bản ghi (Dùng cho phân trang)
     * @return int
     */
    public function count(): int{
        $sqlQuery = "SELECT COUNT(*) FROM {$this->table} {$this->innerJoin} {$this->where} {$this->groupBy}";
        $sqlQuery = trim($sqlQuery);
        if ( !empty($this->bindings) ) {
            $sqlQuery = $this->db->prepare( $sqlQuery, $this->bindings );
        }
        $result = $this->db->get_var( $sqlQuery );
        $this->reset_query();
        return (int) $result;
    }
    /**
     * RESET CÁC THUỘC TÍNH SAU KHI CHẠY QUERY
     */
    public function reset_query(): void{
        $this->queryTable = '';
        $this->where = '';
        $this->operator = '';
        $this->selectField = '*';
        $this->limit = '';
        $this->orderBy = '';
        $this->innerJoin = '';
        $this->groupConcatFields = [];
        $this->groupBy = '';
        $this->bindings = [];
    }
}