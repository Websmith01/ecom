<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $btn = $_POST['btn'];
    if ($btn == 'placeorder') {
        $cartcook = $_COOKIE['cartuser'];
        $cart = explode('-', $cartcook);

        $useremail = substr($cart[0], 0, -1);

        // Insert order
        $ordersql = $con->prepare("INSERT INTO orders VALUES (?,?,?)");
        $ordersql->execute([$useremail, explode('=', $cartcook)[1], $_POST['total']]);

        // Instead of deleting, set cart cookie to "--"
        setcookie("cartuser", $cart[0], time() + 3600, "/"); // 1 hour expiry

        // Optional: redirect to avoid resubmission
        header("Location: cart.php");
        exit();
    }
}
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
                <input type="text" value="<?php echo $total;?>" hidden name="total">
                <button class="orderbtn" type="submit" name="btn" value="placeorder">PLACEORDER</button>

            </form>
            <!-- <?php
                // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //     $btn= $_POST['btn'];
                //     if ($btn=='placeorder'){
                //         $useremail = substr($cart[0], 0, -1);
                //         $ordersql =$con->prepare("INSERT INTO orders VALUES (?,?,?)");
                //         $ordersql->execute([$useremail,explode('=',$cartcook)[1],$total]);
                //         setcookie("cartuser", "", time() - 3600, "/");
                //     }
                // }
            ?> -->
        </div>
        
        <div class="orderhis">
            <div class="omain">
                <div class="smain">
                     <?php
                        $cartem=$_COOKIE['heroemail'];
                        $emcartsql =$con->prepare("SELECT totalamt FROM orders WHERE email=?");
                        $emcartsql->execute([$cartem]);
                        $emcart = $emcartsql->fetchAll();
                        for ($i =0; $i<count($emcart);$i++){ 
                            echo '<h2> Order :' . $i . "</h2>";
                            echo $emcart[$i]['totalamt'];
                            echo '<hr>';
                        }

            ?> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>