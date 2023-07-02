<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css"> -->
    <link rel="stylesheet" href="css/pico/pico.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
    <title>Login</title>
</head>
<?php
    session_start();
    require_once('api/auto-login.php');

    $info_status = isset($_SESSION['status']) ? $_SESSION['status'] : null;
    $info_text = isset($_SESSION['text']) ? $_SESSION['text'] : null;

    function createInfobox(){
        global $info_status, $info_text;
        $info_html = "";
        if (!empty($info_status) and !empty($info_text)){
            $info_html .= '<div class="info-box '.$info_status.'">';
            $info_html .= '<span class="close" onclick="closeInfobox();">X</span>';
            $info_html .= '<p style="text-align: center; font-size: 16px;">'.$info_text.'</p>';
            $info_html .= '</div>';
        }
        return $info_html;
    }

    $_SESSION = [];
?>
<body id = "index">
    <div id="container">
        
        <div id="login" class="selected-form">
            <h2>Login</h2>
            <?=createInfobox();?>
            <form action="api/login.php" method="post">
                <p>Username
                    <input type="text" name="user" id="login-user" required autocomplete="off">
                </p>
                <p>Password
                    <input type="password" name="pass" id="login-pass" required>
                </p>
                <p><input type="checkbox" name="remember" id="login-remember"> Remember me</p>
                <button type="submit">Login</button>
            </form>
            <p style="text-align: center; font-size: 16px;">Don't have an account?<br><a onclick='switchForm("register");'>Register here</a></p>
        </div>
        <div id="register" class="hide">
            <h2>Register</h2>
            <?=createInfobox();?>
            <form action="api/register.php" method="post">
                <p>Username
                    <input type="text" name="user" id="register-user" required autocomplete="off">
                </p>
                <p>Password
                    <input type="password" name="pass" id="register-pass" required>
                </p>
                <button type="submit">Register</button>
                <p style="text-align: center; font-size: 16px;">Got already an account?<br><a onclick='switchForm("login");'>Login here</a></p>
            </form>
        </div>
    </div>
</body>
</html>