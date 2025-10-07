<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $pid = $_POST['pid'];
        $pcat = $_POST['pcategory'];
        $pn = $_POST['pname'];
        $pp = $_POST['pprice'];
        $pq = $_POST['pqty'];
        $pim = $_POST['imglink'];
        $insertstmt = $con->prepare("INSERT INTO product VALUES (?,?,?,?,?,?)");
        try{
            $insertstmt->execute([$pid,$pcat,$pn,$pp,$pq,$pim]);
            header("Location: ./mainadmin.php");
        }catch (PDOException $e) {
            echo 'Error occurred: ' . $e->getMessage();
        }
    }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./mainadmin.css">
</head>
<body>
     <?php
        $auth = false;
        if(!isset($_COOKIE['adminuser'])){
            echo '<h1> admin login 1st <a href="./adminlogin.php">go to login page</a></h1>';
        }else{
            $tokensql =$con->prepare("SELECT token FROM admin");
            $tokensql->execute();
            $tokenuser = $tokensql->fetchAll();
            foreach($tokenuser as $tk){
                if($_COOKIE['adminuser'] == $tk['token']){
                    $auth=true;
                    break;
                }
            }
    ?>

    <?php
        }
        if($auth){
    ?>
        <a href="./adminlogout.php" ><button class="logbut">LOGOUT ADMIN </button></a>
        <h4>Authenticated success</h4>
        <div class="maindiv">
            <div class="editproduct">
                <div id="prodhis">
                    <h1>PRODUCT HISTORY</h1>
                    <table border="2" class="producthistory">
                        <tr>
                            <th>pid</th>
                            <th>pcategory</th>
                            <th>pname</th>
                            <th>pprice</th>
                            <th>pqty</th>
                        </tr>
                        <?php
                            $prodsql =$con->prepare("SELECT * FROM product");
                            $prodsql->execute();
                            $allprod = $prodsql->fetchAll();
                            foreach($allprod as $prod){
                                echo '<tr>';
                                    echo '<td>' . $prod['pid'] .'</td>';
                                    echo '<td>' . $prod['pcategory'] .'</td>';
                                    echo '<td>' . $prod['pname'] .'</td>';
                                    echo '<td>' . $prod['pprice'] .'</td>';
                                    echo '<td>' . $prod['pqty'] .'</td>';
                                    echo '<td><a href="./updateprod.php?id=' . $prod['pid'] . '"><button class="tab-but">UPDATE</button></a></td>';
                                   echo '<td><a href="./deleteprod.php?id=' . $prod['pid'] . '"><button class="tab-but">DELETE</button></a></td>';

                            }

                        ?>
                        
                    </table>
                </div>
                <div class="addproduct">
                    <h1>ADD PRODUCT</h1>
                    <form action="./mainadmin.php" method="post">
                        <input type="text" required name="pid" placeholder="PID"><br>
                        <input type="text" required name="pcategory" placeholder="PCATEGORY"><br>
                        <input type="text" required name="pname" placeholder="PNAME"><br>
                        <input type="text" required name="pprice" placeholder="PPRICE"><br>
                        <input type="text" required name="pqty" placeholder="PQTY"><br>
                        <input type="text" name="imglink" placeholder="imglink"><br>
                        <button type="submit"> Add Product</button>
                        <button type="reset"> RESET</button>
                    </form>
                    
                </div>
            </div>
            <div class="orderdetail"  style="background-color: blueviolet;">
                <h1 >ORDER DETAIL</h1>
                <p>
                    hgfhjytjtgfjnunytkmugk jhgjhgjgjkhgjk
                    gfhfgcjhfgvnfghg hgjtgjuyhtfgfgfgfgfgfgfgfgfgfgyu ghghghghghghghghghghghgh fffffffffffffffffffffffffff fgkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk


                    
                </p>
            
            </div>
        </div>
    <?php }else{
        echo 'un authenticated';
    } ?>
    <!-- <script>
         let psuccess = document.getElementById('pdone');
        if (psuccess) {
            setTimeout(() => { success.innerText = '';window.location.href = '../main.php' }, 3000);
        }

    </script> -->
</body>
</html>