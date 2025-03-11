<?php
require_once(__DIR__ . '/../Config/Database.php');

class CommonModel 
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function getAllRecords($table, $limit = null)
    {
        $query = "SELECT * FROM $table";
        
        if ($limit !== null) {
            $query .= " LIMIT " . intval($limit); // Ensure limit is an integer to prevent SQL injection
        }
    
        $result =  $this->db->query($query);
        
        $records = [];
        if($result && $result->num_rows > 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] = $row;
            }
        }
        
        return $records;
    }
    
    public function getRecordWhere($table, $whereField, $whereValue, $fields = '*', $limit = null) {
        // If $fields is an array, convert it to a comma-separated string
        $selectedFields = is_array($fields) ? implode(", ", $fields) : $fields;
    
        // Construct the query with dynamic fields and limit
        $query = "SELECT $selectedFields FROM $table WHERE $whereField = '$whereValue'";

        // echo "query is: " . $query; die;
        
        if ($limit !== null) {
            $query .= " LIMIT $limit";
        }
    
        $result = $this->db->query($query);
    
        if ($result && $result->num_rows > 0) {
            return $limit == 1 ? $result->fetch_assoc() : $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function getRecordWhereAnd($table, $whereFields, $whereValues, $fields = '*', $limit = null) {
        // Convert array fields to a comma-separated string
        $selectedFields = is_array($fields) ? implode(", ", $fields) : $fields;
    
        // Construct WHERE clause for multiple conditions
        if (is_array($whereFields) && is_array($whereValues) && count($whereFields) === count($whereValues)) {
            $whereClauses = [];
            foreach ($whereFields as $key => $field) {
                $whereClauses[] = "$field = '{$whereValues[$key]}'";
            }
            $whereClause = implode(" AND ", $whereClauses);
        } else {
            // Single condition case
            $whereClause = "$whereFields = '$whereValues'";
        }
    
        // Construct the query
        $query = "SELECT $selectedFields FROM $table WHERE $whereClause";
        
        if ($limit !== null) {
            $query .= " LIMIT $limit";
        }
    
        $result = $this->db->query($query);
    
        if ($result && $result->num_rows > 0) {
            return $limit == 1 ? $result->fetch_assoc() : $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }
    
    public function insertRecord($table, $data) {
        foreach ($data as $key => $value) {
            // Convert arrays to JSON before inserting
            if (is_array($value)) {
                $data[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
            } else {
                $data[$key] = addslashes($value); // Escape single quotes
            }
        }
    
        $columns = implode(', ', array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
    
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    
        return $this->db->query($sql);
    }
    

    public function getAllRecordsByFields($table, $fields, $where = []) {
        // Convert array fields to a comma-separated string
        $fields = is_array($fields) ? implode(', ', $fields) : $fields;
    
        // Construct WHERE clause if conditions are provided
        $whereClause = '';
        if (!empty($where) && is_array($where)) {
            $conditions = [];
            foreach ($where as $key => $value) {
                $conditions[] = "$key = '$value'";
            }
            $whereClause = " WHERE " . implode(" AND ", $conditions);
        }
    
        // Construct the SQL query
        $sql = "SELECT $fields FROM $table" . $whereClause;
        $result = $this->db->query($sql);
    
        if (!$result) {
            return [];
        }
    
        $data = $result->fetch_all(MYSQLI_ASSOC);
    
        // If only one field is selected, return a simple indexed array
        if (!is_array($fields)) {
            return array_column($data, $fields);
        }
    
        return $data;
    }

    public function deleteRecordById($table, $id){
        $query = "DELETE FROM `$table` WHERE id = $id";

        // Execute query
        if ($this->db->query($query)) {
            return true; 
        } else {
            return false; 
        }
    }

    public function updateRecordById($table, $data, $id) {
    
        // Construct the SET part of the query dynamically
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "`$column` = '$value'";
        }
        $setQuery = implode(", ", $set);
    
        // Update query
        $query = "UPDATE `$table` SET $setQuery WHERE id = $id";

    
        // Execute query
        if ($this->db->query($query)) {
            return true; 
        } else {
            return false; 
        }
    
    }
    
    public function getInnerJoinRecords($table1, $table2, $joinCondition, $whereCondition = "") {
        $sql = "SELECT $table1.* FROM $table1 INNER JOIN $table2 ON $joinCondition";
    
        if (!empty($whereCondition)) {
            $sql .= " WHERE $whereCondition";
        }

        $result = $this->db->query($sql);
    
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    

   
}







