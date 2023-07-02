<?php
session_start();

require_once("class/db.class.php");
$db = new Database();
$db->sql_execute("UPDATE `user` SET `session` = NULL WHERE `id` = :id",['id' => $_SESSION['user']['id']]);
setcookie("session_token","",time()-100,"/",$_SERVER['SERVER_NAME']);
session_destroy();
