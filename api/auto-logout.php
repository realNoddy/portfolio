<?php

if (!isset($_SESSION['user']) or !isset($_SESSION['user']['id'])){
    session_destroy();
    header("Location: http://localhost/");
    die();
}
