<?php

require_once '../config.php';

class database {
    private $connection;

    public function __construct() {
        global $config;
        $this->connect($config['db']['host'], $config['db']['dbname'], $config['db']['user'], $config['db']['pass']);
    }

    private function connect($host, $dbname, $user, $pass) {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    public function query($sql, $params = []) {
        try {
            $statement = $this->connection->prepare($sql);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }
}

?>