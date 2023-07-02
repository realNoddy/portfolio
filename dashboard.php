<?php
    session_start();
    unset($_SESSION['status']);
    unset($_SESSION['text']);
    if (!isset($_SESSION['user'])){
        require_once('api/auto-login.php');
    }
    require_once('api/auto-logout.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pico/pico.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
    <title>Dashboard</title>
</head>
<body id="dashboard">
    <div id="container">
        <div id="menu">
            <div class="header">
                <h1>Dashboard</h1>
            </div>
            <div class="list">
                <div>
                    Profile
                </div>
                <div>
                    Listing
                </div>
            </div>
        </div>
        <div id="content">
            <div class="header">
                <div>Hello <span class="username"><?=$_SESSION['user']['name']?></span></div>
                <div onclick="Logout();">Logout</div>
            </div>
        </div>
    </div>
</body>
</html>