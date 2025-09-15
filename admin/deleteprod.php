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

<?php
    }
    if($auth){
        $id = $_GET['id']; 
?>
    <h1>are you sure want to delete</h1>
    <form action="<?php echo './deleteprod.php?id=' . $id; ?>" method="post">

        <button type="submit" name="conf" value="yes">Yes</button>
        <button type="submit" name="conf" value="no">No</button>
    </form>
    
    <?php 
         if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $conf= $_POST['conf'];
            if ($conf=='yes'){
                $deletesql =$con->prepare("DELETE FROM product WHERE pid =?");
                $deletesql->execute([$id]);
                echo 'deleted successfully';
                echo '<a href="./mainadmin.php"> go back </a>';
            }else {
                 echo '<a href="./mainadmin.php"> go back </a>';
            }
        }
    ?>

<?php }
else{
    echo 'some error occured';
}?>