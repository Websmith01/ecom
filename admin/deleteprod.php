<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
?>
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
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="./deleteprod.css">
    </head>
    <body>
    <a href="../admin/mainadmin.php"><button>Back</button></a>
      

<?php
    }
    if($auth){
        $id = $_GET['id']; 
?>
    <form action="<?php echo './deleteprod.php?id=' . $id; ?>" method="post">
        <h1>Are you sure want to Delete ?</h1>

        <button type="submit" name="conf" value="yes">Yes</button>
        <button type="submit" name="conf" value="no">No</button>
    </form>
    
    <?php 
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $conf= $_POST['conf'];
            if ($conf=='yes'){
                $deletesql =$con->prepare("DELETE FROM product WHERE pid =?");
                $deletesql->execute([$id]);
                echo '<h3 >Deleted Successfully</h3>';
            }else {
                // echo '<a href="./mainadmin.php"><button class="dbtn"> go back </button></a>';
            }
        }
    ?>

<?php }
else{
    echo 'some error occured';
}?>  
    </body>
    </html>