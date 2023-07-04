<?php
    session_start();
    unset($_SESSION['status']);
    unset($_SESSION['text']);
    if (!isset($_SESSION['user'])){
        require_once('api/auto-login.php');
    }
    require_once('api/auto-logout.php');
    require_once('api/class/db.class.php');
    require_once('api/class/user.class.php');
    $db = new Database();
    $user = new User();
    $user->get_data_by_id($db,$_SESSION['user']['id']);
    $orders = $user->get_orders($db);
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
            <div>
            <?php
                if (!empty($orders)){
                    echo('<table>');
                    echo('<thead>');
                    echo('<tr>');
                    echo('<th scope="col">#</th>');
                    foreach($orders[0] as $key => $value){
                        echo('<th scope="col">'. ucfirst($key).'</th>');
                    }
                    echo('</tr>');
                    echo('</thead>');
                    
                    $total_price = 0;
                    echo('<tbody>');
                    foreach($orders as $order_number => $order){
                        $total_price += $order['count'] * $order['price'];
                        echo('<tr>');
                        echo('<th scope="row">'.$order_number.'</th>');
                        foreach($order as $key => $item){
                            if ($key == "price"){
                                $item = number_format($item,2,",",".")."€";
                            }
                            echo('<td>'.$item.'</td>');
                        }
                        echo('</tr>');
                    }
                    echo('</tbody>');
                    echo('<tfoot>');
                    echo('<tr>');
                    echo('<td>Total</td>');
                    foreach($orders[0] as $key => $item){
                        if($key == "price"){
                            echo('<td>'.number_format($total_price,2,",",".").'€</td>');
                        }else{
                            echo('<td> </td>');
                        }
                    }
                    echo('</tr>');
                    echo('</tfoot>');
                    echo('</table>');
                }
            ?>
            
            </div>
        </div>
    </div>
</body>
</html>