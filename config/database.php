<?php

class database
{
    public $host, $user, $pass, $dbname;
    public function __construct()
    {
        $encode_data = json_decode(file_get_contents(__DIR__ . "./../env.json"), true);
        $this->host = $encode_data["database"]["host"];
        $this->user = $encode_data["database"]["user"];
        $this->pass = $encode_data["database"]["password"];
        $this->dbname = $encode_data["database"]["dbname"];
    }
}
