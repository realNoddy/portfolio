<?php

if (!isset($_COOKIE['session_token'])){
    return;
}

require_once 'class/db.class.php';
$db = new Database();

$result = $db->sql_execute('SELECT id, name name FROM `user` WHERE `session` IS NOT NULL AND `session` = :session AND DATEDIFF(:date, `session_date`) < 60', ['session' => $_COOKIE['session_token'],'date' => date('Y-m-d')]);

if (!empty($result)){
    $_SESSION['user']['id'] = $result[0]['id'];
    $_SESSION['user']['name'] = $result[0]['name'];
    header("Location: http://localhost/dashboard.php");
    die();
}