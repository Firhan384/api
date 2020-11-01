<?php

include(__DIR__ . "./../../config/database.php");

class Connect extends database
{
    public $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->db->connect_error) {
            echo $this->db->connect_errno;
        }
    }
}
