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
        // nếu có alias: "tasks t"
        if (str_contains($table, ' ')) {
            [$name, $alias] = explode(' ', $table);

            $this->rawTable = $name;
            $this->table = $this->db->prefix . $name . ' ' . $alias;

        } else {
            $this->rawTable = $table;
            $this->table = $this->db->prefix . $table;
        }
        return $this;
    }
    public function from($table){
        if (str_contains($table, ' ')) {
            [$name, $alias] = explode(' ', $table);
            $this->rawTable = $name;
            $this->table = $this->db->prefix . $name . ' ' . $alias;
        } else {
            $this->rawTable = $table;
            $this->table = $this->db->prefix . $table;
        }
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

    public function or_where( $field, $compare, $value ) {
        $this->operator = empty($this->where) ? ' WHERE ' : ' OR ';
        $this->where .= "{$this->operator} {$field} {$compare} %s";
        $this->bindings[] = $value;
        return $this;
    }

    public function where_like( $field, $value ) {
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} LIKE %s";
        $this->bindings[] = $value;
        return $this;
    }

    public function where_null($field){
        $this->operator = empty($this->where) ? ' WHERE ' : ' AND ';
        $this->where .= "{$this->operator} {$field} IS NULL";
        return $this;
    }

    public function where_not_null($field){
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

    public function order_by( $field, $type = 'ASC' ) {
        $fieldArr = array_filter( explode(',', $field) );
        if ( !empty($fieldArr) && count($fieldArr) >= 2 ) {
            $this->orderBy = "ORDER BY " . implode(', ', $fieldArr);
        } else {
            $this->orderBy = "ORDER BY {$field} {$type}";
        }
        return $this;
    }

    public function group_by( $field ) {
        $this->groupBy = "GROUP BY {$field}";
        return $this;
    }

    public function join($table, $relationShip ) {
        $this->innerJoin .= " INNER JOIN {$table} ON {$relationShip} ";
        return $this;
    }

    public function left_join($table, $relationship ) {
        $this->innerJoin .= " LEFT JOIN {$table} ON {$relationship} ";
        return $this;
    }

    public function group_concat($field, $alias = null, $separator = ', ', $distinct = false, $orderBy = null, $condition = null) {
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

        $this->rese_query();
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

        $this->rese_query();
        return $result ?: false;
    }

    /**
     * THÊM DỮ LIỆU
     */
    public function insert( $data ) {
        $result = $this->db->insert( $this->table, $data );
        $this->rese_query();
        if ($result === false) {
            return false;
        }
        return $this->db->insert_id;
    }

    public function last_id() {
        return $this->db->insert_id;
    }

    /**
     * CẬP NHẬT DỮ LIỆU (Kết hợp với hàm where)
     */
    public function update( array $data ) {
        if (empty($this->where)) return false;
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
        $this->rese_query();
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
        $this->rese_query();
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
    public function insert_or_update( $data, $updateFields = [], $parentId = null, $parentKey = '' ) {
        if ( $parentId !== null && $parentKey !== '' ) {
            $data[$parentKey] = $parentId;
        }

        $columns = [];
        $placeholders = [];
        $values = [];
        foreach ($data as $column => $value) {
            $columns[] = "`{$column}`";

            if (is_null($value)) {
                $placeholders[] = "NULL"; // 🔥 NULL thật
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
        $this->rese_query();
        return $result !== false;
    }

    /**
     * RESET CÁC THUỘC TÍNH SAU KHI CHẠY QUERY
     */
    public function rese_query() {
        //$this->rawTable = '';
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