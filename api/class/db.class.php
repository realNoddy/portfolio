<?php

class Database {
    
    private $db_engine = "mysql";
    private $db_server = "localhost";
    private $db_table = "db_project";
    private $db_user = "root";
    private $db_password = "";
    private $db_connection;
    private $debug = false;
    private $connected = false;

    function __construct($debug=false){
        $this->debug = $debug;
        try {
            $db_data = $this->db_engine.":host=".$this->db_server.";dbname=".$this->db_table;
            $this->db_connection = new PDO($db_data, $this->db_user);
            if ($this->debug){
                $this->db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully";
            }
            $this->connected = true;
        }catch(PDOException $e){
            if ($this->debug){
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }

    function is_connected():bool{
        return $this->connected;
    }

    function get_connection():PDO{
        return $this->db_connection;
    }

    function sql_execute($sql,$values=[]):array{
        $st = $this->db_connection->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $st->execute($values);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

}

