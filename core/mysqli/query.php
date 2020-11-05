<?php

include("connect.php");

class Query extends Connect
{
    public $table;
    public $use_where;
    protected $key, $value;

    public function __construct($table)
    {
        parent::__construct();
        if ($this->db->connect_error) {
            $this->db->close();
            exit();
        }
        $this->table = $table;
    }

    public function all($result = null)
    {
        $data = $this->db->query("SELECT * FROM $this->table");
        // if (strcmp("result_array", $result) == 0 || empty($result)) {
        //     $data = $data->fetch_array();
        // } else if (strcmp("result_object", $result) == 0) {
        //     $data = $data->fetch_object();
        // }
        // $this->db->close();
        return $data;
    }

    public function query($data)
    {
        $result = $this->db->query($data);
        return $result;
    }

    public function insert($data)
    {
        $result_query = null;
        if (is_array($data)) {
            $new = [];
            foreach ($data as $p) {
                $new[] = "'" . $p . "'";
            }
            $result_query = 'INSERT INTO ' . $this->table . ' (' . implode(', ', array_keys($data)) . ') VALUES (' . implode(', ', array_values($new)) . ')';
        }
        $result = $this->db->query($result_query);
        if ($result === true) {
            return true;
        } else {
            return $this->db->error;
        }
    }

    public function where($key, $value = NULL)
    {
        $this->use_where = true;
        if (is_array($value) && is_array($key)) {
            $value = $value[0];
            $key = $key[0];
        }
        if (is_null($value)) {
            $is_value = '';
        } else {
            if (is_string($value)) {
                $is_value = "'" . $value . "'";
            } else if (is_integer($value)) {
                $is_value = $value;
            }
        }

        $this->key = $key;
        $this->value = $is_value;
        return ' WHERE ' . $key . ' = ' . $is_value;
    }

    public function update($data)
    {
        foreach ($data as $key => $value) {
            if (is_integer($value) || is_float($value) || is_double($value)) {
                $is_value = $value;
            } else if (is_string($value)) {
                $is_value = "'" . $value . "'";
            }
            $valstr[] = $key . "=" . $is_value;
        }
        if ($this->use_where == true) {
            $str_where = $this->where($this->key, $this->value);
        } else {
            $str_where = '';
        }
        $result_query = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $valstr) . $str_where;
        $result = $this->db->query($result_query);
        if ($result === true) {
            return true;
        } else {
            return $this->db->error;
        }
    }
    /*
    data : must be array
    */
    public function delete($data)
    {
        $result_query = 'DELETE FROM ' . $this->table . $this->where(array_keys($data), array_values($data));
        $result = $this->db->query($result_query);
        if ($result === true) {
            return true;
        } else {
            return $this->db->error;
        }
    }
}
