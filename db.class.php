<?php


class DB {

    private $pdo;

    function __construct() {
        require_once 'config.php';
        try {
            $connData = "pgsql:host=$host;port=5432;dbname=$dbName;";
        
            $this->pdo = new PDO($connData, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);     
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

    // returns the number of rows resulting from the input query
    function numRows(PDOStatement $sql) {
        try {
            return $sql->rowCount();
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
}


?>