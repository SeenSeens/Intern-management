<?php
namespace InternManagement\Core;
trait QueryBuilder {
    protected string $rawTable = '';
    protected string $where = '';
    protected string $operator = '';
    protected string $selectField = '*';
    protected string $limit = '';
    protected string $orderBy = '';
    protected string $innerJoin = '';
    protected array $groupConcatFields = [];
    protected string $groupBy = '';

    // Mảng chứa các giá trị truyền vào để dùng với $wpdb->prepare (Bảo mật)
    protected array $bindings = [];

    // Tự động thêm tiền tố database của WP (vd: wp_)
    public function table( $table ) {
        $this->rawTable = $this->db->prefix . $table;
        return $this;
    }
    public function from($table){
        $this->table = $table;
        return $this;
    }
    public function where( $field, $compare, $value ) {
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        if($value === null){
            $this->where .= "{$this->operator} {$field} {$compare} NULL";
        } else {
            $this->where .= "{$this->operator} {$field} {$compare} %s";
            $this->bindings[] = $value;
        }
        return $this;
    }

    public function orWhere( $field, $compare, $value ) {
        $this->operator = empty($this->where) ? ' WHERE ' : ' OR ';
        $this->where .= "{$this->operator} {$field} {$compare} %s";
        $this->bindings[] = $value;
        return $this;
    }

    public function whereLike( $field, $value ) {
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} LIKE %s";
        $this->bindings[] = $value;
        return $this;
    }

    public function whereNull($field){
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} IS NULL";
        return $this;
    }

    public function whereNotNull($field){
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} IS NOT NULL";
        return $this;
    }

    public function select( $field = '*' ) {
        $this->selectField = $field;
        return $this;
    }

    public function limit( $number, $offset = 0 ) {
        // Ép kiểu số nguyên để an toàn, không cần đưa vào bindings
        $number = intval($number);
        $offset = intval($offset);
        $this->limit = "LIMIT {$offset}, {$number}";
        return $this;
    }

    public function orderBy( $field, $type = 'ASC' ) {
        $fieldArr = array_filter( explode(',', $field) );
        if ( !empty($fieldArr) && count($fieldArr) >= 2 ) {
            $this->orderBy = "ORDER BY " . implode(', ', $fieldArr);
        } else {
            $this->orderBy = "ORDER BY {$field} {$type}";
        }
        return $this;
    }

    public function groupBy( $field ) {
        $this->groupBy = "GROUP BY {$field}";
        return $this;
    }

    public function join($table, $relationShip ) {
        $this->innerJoin .= " INNER JOIN {$table} ON {$relationShip} ";
        return $this;
    }

    public function leftJoin($table, $relationship ) {
        $this->innerJoin .= " LEFT JOIN {$table} ON {$relationship} ";
        return $this;
    }

    public function groupConcat($field, $alias = null, $separator = ', ', $distinct = false, $orderBy = null, $condition = null) {
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
    public function get() {
        if (!empty($this->groupConcatFields)) {
            if ($this->selectField === '*') {
                $this->selectField = implode(', ', $this->groupConcatFields);
            } else {
                $this->selectField .= ', ' . implode(', ', $this->groupConcatFields);
            }
        }

        $sqlQuery = "SELECT {$this->selectField} FROM {$this->table} {$this->innerJoin} {$this->where} {$this->groupBy} {$this->orderBy} {$this->limit}";
        $sqlQuery = trim($sqlQuery);

        // Bảo mật với wpdb->prepare nếu có điều kiện WHERE
        if ( !empty($this->bindings) ) {
            $sqlQuery = $this->db->prepare( $sqlQuery, $this->bindings );
        }

        $results = $this->db->get_results( $sqlQuery );

        $this->resetQuery();
        return $results ?: false;
    }

    /**
     * TRUY XUẤT 1 BẢN GHI (Tương đương fetch)
     */
    public function first() {
        // Ép lấy 1 bản ghi để tối ưu tốc độ nếu quên set limit
        $this->limit(1);

        $sqlQuery = "SELECT {$this->selectField} FROM {$this->table} {$this->innerJoin} {$this->where} {$this->groupBy} {$this->orderBy} {$this->limit}";
        $sqlQuery = trim($sqlQuery);

        if ( !empty($this->bindings) ) {
            $sqlQuery = $this->db->prepare( $sqlQuery, $this->bindings );
        }

        $result = $this->db->get_row( $sqlQuery );

        $this->resetQuery();
        return $result ?: false;
    }

    /**
     * THÊM DỮ LIỆU
     */
    public function insert( $data ) {
        $result = $this->db->insert( $this->table, $data );
        $this->resetQuery();
        return $result !== false;
    }

    public function lastId() {
        return $this->db->insert_id;
    }

    /**
     * CẬP NHẬT DỮ LIỆU (Kết hợp với hàm where)
     */
    public function update( array $data ) {
        // Tạo chuỗi SET "cột = %s, cột = %s"
        $setList = [];
        $updateBindings = [];
        foreach ( $data as $column => $value ) {
            $setList[] = "{$column} = %s";
            $updateBindings[] = $value;
        }
        $setSql = implode( ', ', $setList );

        $sql = "UPDATE {$this->table} SET {$setSql} {$this->where}";

        // Gộp biến của UPDATE và biến của WHERE lại với nhau
        $allBindings = array_merge( $updateBindings, $this->bindings );

        if ( !empty($allBindings) ) {
            $sql = $this->db->prepare( $sql, $allBindings );
        }

        $result = $this->db->query( $sql );
        $this->resetQuery();
        return $result !== false;
    }

    /**
     * XÓA DỮ LIỆU (Kết hợp với hàm where)
     */
    public function delete() {
        // Chặn việc lỡ tay xóa trắng bảng nếu quên viết hàm where()
        if ( empty($this->where) ) {
            return false;
        }

        $sql = "DELETE FROM {$this->table} {$this->where}";

        if ( !empty($this->bindings) ) {
            $sql = $this->db->prepare( $sql, $this->bindings );
        }

        $result = $this->db->query( $sql );
        $this->resetQuery();
        return $result !== false;
    }

    /**
     * THÊM HOẶC CẬP NHẬT (ON DUPLICATE KEY UPDATE)
     */
    public function insertOrUpdate( $data, $updateFields = [], $parentId = null, $parentKey = '' ) {
        if ( $parentId !== null && $parentKey !== '' ) {
            $data[$parentKey] = $parentId;
        }

        $columns = implode( ', ', array_keys($data) );
        // Tạo chuỗi placeholder %s, %s, %s tương ứng với số lượng cột
        $placeholders = implode( ', ', array_fill(0, count($data), '%s') );

        $updateQuery = '';
        if ( !empty($updateFields) ) {
            $updateSet = [];
            foreach ( $updateFields as $field ) {
                $updateSet[] = "{$field} = VALUES({$field})";
            }
            $updateQuery = 'ON DUPLICATE KEY UPDATE ' . implode( ', ', $updateSet );
        }

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders}) {$updateQuery}";

        // Chuẩn bị các giá trị động
        $sql = $this->db->prepare( $sql, array_values($data) );
        $result = $this->db->query( $sql );

        $this->resetQuery();
        return $result !== false;
    }

    /**
     * RESET CÁC THUỘC TÍNH SAU KHI CHẠY QUERY
     */
    public function resetQuery() {
        $this->where = '';
        $this->operator = '';
        $this->selectField = '*';
        $this->limit = '';
        $this->orderBy = '';
        $this->innerJoin = '';
        $this->groupConcatFields = [];
        $this->groupBy = '';
        $this->bindings = []; // Reset cả mảng biến
    }
}