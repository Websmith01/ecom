<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./cart.css">
</head>
<body>
    <div class="main">
        <div class="bill">
            <table  border="2px" class="table">
                <tr >
                    <th>PRODUCT</th>
                    <th>PRICE</th>
                    <th>QUANTITY</th>
                    <th>TOTAL</th>
                </tr>
            <?php
                $total=0;
                $cartcook=$_COOKIE['cartuser'];
                $cart=explode('-',$cartcook);
                for($i=1;$i<count($cart);$i++){
                    $pid = explode(':',explode(',',$cart[$i])[0])[1];
                    $qty = explode(':',explode(',',$cart[$i])[1])[1];
                    $prodsql =$con->prepare("SELECT pname,pprice FROM product WHERE pid = ?");
                    $prodsql->execute([$pid]);
                    $prodet = $prodsql->fetchAll();
                    echo '<tr>';
                        echo '<td>' . $prodet[0]['pname'] . '</td>';
                        echo '<td>' . $prodet[0]['pprice'] . '</td>';
                        echo '<td>' . $qty . '</td>';
                        echo '<td>' . $qty * $prodet[0]['pprice'] . '</td>';
                    echo '</tr>';  
                    $total+= $qty * $prodet[0]['pprice'];
                }

            ?>
            </table>
        </div>
        <div class="placeorder">
            <h2 class="amount">GRAND TOTAL  : Rs <?php echo $total;?></h2>
            <form action="./cart.php" method="post">
                <button class="orderbtn" type="submit" name="btn" value="placeorder">PLACEORDER</button>

            </form>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $btn= $_POST['btn'];
                    if ($btn=='placeorder'){
                        $useremail = substr($cart[0], 0, -1);
                        $ordersql =$con->prepare("INSERT INTO orders VALUES (?,?,?)");
                        $ordersql->execute([$useremail,explode('=',$cartcook)[1],$total]);
                    }
                }
            ?>
        </div>
        
        <div class="orderhis"></div>
    </div>
</body>
</html>