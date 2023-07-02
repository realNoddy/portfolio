<?php
session_start();

if (empty($_POST) or empty($_POST['user']) or empty($_POST['pass'])){
    $_SESSION['status'] = 'error';
    $_SESSION['text'] = 'No data was given';
    header("Location: http://localhost/");
    die();
}

require_once('class/db.class.php');
$db = new Database($debug=true);

if (!$db->is_connected()){
    $_SESSION['status'] = 'error';
    $_SESSION['text'] = 'DB connection failed';
    header("Location: http://localhost/");
    die();
}

require_once('class/user.class.php');

$user = $_POST['user'];
$pass = $_POST['pass'];
$remember = $_POST['remember'] == "on" ? true : false;

$user = new User($user, $pass);
$result = $user->login($db,$remember);

if($result){
    header("Location: http://localhost/dashboard.php"); //dashboard
}else{
    header("Location: http://localhost/");
}
