<?php

class User {
    private $id;
    private $name;
    private $password; //hashed
    private $cart;

    function __construct($name = "",$password = "", $id = null){
        $this->name = $name;
        $this->password = hash("sha256", $password);
        $this->id = $id;
    }

    function get_name():string{
        return $this->name;
    }

    function get_data_by_id(Database $db = null, $id = null):bool{
        if ($db == null or !$db->is_connected() or $id == null){
            return false;
        }
        $result = $db->sql_execute('SELECT * FROM `user` WHERE `id` = :id', ['id' => $id]);
        if (!empty($result)){
            $this->id = $result[0]['id'];
            $this->name = $result[0]['name'];
            return true;
        }
        return false;
    }

    function get_data_by_session(Database $db = null, $session = null):bool{
        if ($db == null or !$db->is_connected() or $id == null){
            return false;
        }
        $result = $db->sql_execute('SELECT * FROM `user` WHERE `session` = :session AND DATEDIFF(:date, `session_date`) < 60', ['session' => $session, 'date' => date('Y-m-d')]);
        if (!empty($result)){
            $this->id = $result[0]['id'];
            $this->name = $result[0]['name'];
            return true;
        }
        return false;
    }

    function register(Database $db = null):bool{
        if ($db == null or !$db->is_connected()){
            return false;
        }

        //check if user already exists
        $result = $db->sql_execute('SELECT id FROM `user` WHERE `name` = :name', ['name' => $this->name]);
        if (empty($result)){
            try {
                $result = $db->sql_execute('INSERT  INTO `user` (`name`, `password`) VALUES( :name, :password)', ['name' => $this->name, 'password' => $this->password]);
                $_SESSION['status'] = 'success';
                $_SESSION['text'] = 'User registered';
                return true;
            } catch(e) {
                $_SESSION = [];
                $_SESSION['status'] = 'error';
                $_SESSION['text'] = 'User could not be registered';
                return false;
            }
        }else{
            $_SESSION = [];
            $_SESSION['status'] = 'error';
            $_SESSION['text'] = 'User already exists';
            return false;
        }
    }

    function login(Database $db,$remember = false):bool{
        if ($db == null or !$db->is_connected()){
            return false;
        }

        $result = $db->sql_execute('SELECT id FROM `user` WHERE `name` = :name AND `password` = :password' , ['name' => $this->name, 'password' => $this->password]);
        if (!empty($result)){
            $this->id = $result[0]['id'];

            if ($remember){
                $session_token = $remember ? $this->generate_session($db) : null;
                $db->sql_execute('UPDATE `user` SET `session` = :session, `session_date` = :date WHERE `id` = :userid' , ['session' => $session_token, 'date' => date('Y-m-d'), 'userid' => $this->id]);
                setcookie("session_token",$session_token,time()+(86400*30),"/",$_SERVER['SERVER_NAME']); // 30 days
            }
            
            $_SESSION['status'] = 'success';
            $_SESSION['text'] = 'Hello '.$this->name;
            $_SESSION['user']['id'] = $this->id;
            $_SESSION['user']['name'] = $this->name;
            return true;
        }else{
            $_SESSION = [];
            $_SESSION['status'] = 'error';
            $_SESSION['text'] = 'Username or password was incorrect';
            return false;
        }
    }

    //TODO: cronjob to clear old sessions on db
    private function generate_session(Database $db):string{

        function generate_random_string($length = 12){
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!$%&#';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $session = "";
        $generated = false;
        do {
            $new_session = generate_random_string().$this->name;
            $session = hash("sha256",$new_session);
            $result = $db->sql_execute('SELECT id FROM `user` WHERE `session` = :session' , ['session' => $session]);
            if (empty($result)){
                $generated = true;
            }
        } while ($generated == false);
        
        return $session;
    }

    function get_orders(Database $db):array{
        if ($db == null or !$db->is_connected()){
            return [];
        }
        
        $result = $db->sql_execute('SELECT p.title, p.description, o.count, p.price FROM `orders` AS o INNER JOIN `user` AS u ON o.u_id = u.id INNER JOIN `product` AS p ON o.p_id = p.id WHERE u.id = :userid' , ['userid' => $this->id]);
        if (!empty($result)){
            return $result;
        }
        return [];
    }

    
}