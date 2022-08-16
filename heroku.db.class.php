<?php


class DB {

    private $pdo;

    function __construct() {
        
        try {
            include './heroku.config.php';

            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::MYSQL_ATTR_SSL_CA => '/path/to/cacert.pem',
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            );
            $this->pdo = new PDO("pgsql:host=".$conn["host"].";dbname=". ltrim($conn["path"], "/"), $conn["user"], $conn["pass"], $options);

        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    // query method
    // returns pdo statement object
    function query(string $queryString, Array $substitutionArray) {
        try {
            $sql = $this->pdo->prepare($queryString);
            $sql->execute($substitutionArray);
            
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
        return $sql;
    }

    // Returns a single row from the query parameter as an array
    function fetchSingleRow(PDOStatement $sql) {
        try {
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    // Returns all rows from the query parameter as an array of arrays
    function fetchAll(PDOStatement $sql) {
        try {
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    // Returns a specific number of rows specified in the parameters
    function fetchRowNumber(PDOStatement $sql,integer $rowNumber) {
        try {
            $result = array();
            for($i = 0; $i < $rowNumber; $i++) {
                $tmp = $sql->fetch(PDO::FETCH_ASSOC);
                array_push($result, $tmp);
            }
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    function insertRow($queryString, $substitutionArray) {
        try {
            $sql = $this->query($queryString, $substitutionArray);
            if($sql && $this->numRows($sql) == 1) {
                return 1;
            }
            else 
                return -1;
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    function insertRows($queryString, $substitutionArray) {
        try {
            $sql = $this->query($queryString, $substitutionArray);
            if($sql && $this->numRows($sql) == 1) {
                return 1;
            }
            else 
                return -1;
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    // returns the number of rows resulting from the input query
    function numRows(PDOStatement $sql) {
        try {
            return $sql->rowCount();
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }
}


?>