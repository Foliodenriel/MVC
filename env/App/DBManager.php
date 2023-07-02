<?php

namespace App;

use PDO;

class DBManager {

    private $conn;
    private $dbName;
    private $file;

    public function getDBName() { return $this->dbName; }
    public function getConn() { return $this->conn; }

    public function __construct($dbConfig) {

        $this->conn = null;
        $this->startConn($dbConfig);
    }

    protected function startConn($dbConfig) {

        if (isset($dbConfig['user'], $dbConfig['password'], $dbConfig['db']))
        {
            $this->dbName = $dbConfig['db'];
            $pdo_config = 'mysql:host=127.0.0.1;port=' . $dbConfig['port'] . ';dbname=' . $this->dbName;
            $this->conn = new PDO($pdo_config, $dbConfig['user'], $dbConfig['password']);
        }
    }
}
