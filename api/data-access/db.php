<?php

class Database {

    private $dbHost = '';
    private $dbName = '';
    private $dbUser = '';
    private $dbPass = '';

    private static $instance;
    private static $con;

    public static function getInstance() {
        if (is_null(self::$instance))
            self::$instance = new Database();

        return self::$con;
    }

    public function __construct() {

        $connectionString = "mysql:dbname=$this->dbHost;dbname=$this->dbName";

        try {
            self::$con = new PDO($connectionString, $this->dbUser, $this->dbPass);
        } catch (exception $e) {
            //JsonUtils::echoError($e->getMessage());
            JsonUtils::echoError("Unable to establish a MySQL connection");
            exit;
        }
    }
}