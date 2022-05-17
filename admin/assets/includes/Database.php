<?php

date_default_timezone_set('asia/kolkata');

class Database {

    private $host = 'localhost';
    private $user = 'coromcxc_admin';
    private $pass = 'Ccop@123!';
    private $dbname = 'coromcxc_data';
    private $dbh;
    private $error;
    private $stmt;
    private $count;

    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set Options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // Create new PDO
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            //echo 'success';
        } catch (PDOEception $e) {
            $this->error = $e->getMessage();
            //echo 'sorry';
        }
    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
        return $this->stmt->execute();
    }

    public function prepare($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    public function resultset() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count() {
        $this->count = $this->stmt->rowCount();
        return $this->count;
    }
    
        public function col_count() {
        $this->count = $this->stmt->columnCount();
        return $this->count;
    }

}
