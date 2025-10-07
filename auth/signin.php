<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);

$msg = ''; // store message for later

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $em = $_POST['email'];
    $ps = $_POST['pass'];

    $searchstmt = $con->prepare("SELECT * FROM customer WHERE email=?");
    try {
        $searchstmt->execute([$em]);
        $data = $searchstmt->fetchAll();

        if ($data == []) {
            $msg = '<center><a href="./signup.php"><h2 style="color:orange;">please sign up first </h2></a></center>';
        } else {
            $hp = $data[0]['password'];
           
            if (password_verify($ps, $hp)) {
                // ✅ Set cookie before any echo
                $token = rand(111111111,999999999);
                $tkh = password_hash($token,PASSWORD_DEFAULT);
                $setrandm = $con->prepare("UPDATE customer SET token = ? WHERE email = ?");
                $setrandm->execute([$token,$em]);
                setcookie("herouser", $tkh, time() + (10 * 365 * 24 * 60 * 60), "/");
                setcookie("heroemail", $em, time() + (10 * 365 * 24 * 60 * 60), "/");
                setcookie('cartuser', $em.'=', time() + (10 * 365 * 24 * 60 * 60), "/");

                $msg = '<center><h1 style="color: #19183b; " id="success">SIGNIN SUCCESS</h1></center>';
            } else {
                $msg = '<center><h2 style="color:red;">incorrect credential</h2></center>';
            }
        }
    } catch (PDOException $e) {
        $msg = 'Error occurred: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signin</title>
    <link rel="stylesheet" href="./signin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
         integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <a href="./signup.php"><button type="button" class="sbtn">Sign Up</button></a>
    <form action="./signin.php" method="post">
            <h1>SIGN IN</h1><br><br>
            <input type="email" name="email" placeholder="Enter your Email" id="email" required> <br> <br>
            <input type="password" name="pass" placeholder="Password" id="pass" required>
            <i class="fa-regular fa-eye-slash" id="eye"></i> <br> <br>
            <button type="submit" >Sign In</button> <br><br>
            <button type="reset">Reset</button> 
        </form>
    

    <!-- show messages -->
    <?php if ($msg) echo $msg; ?>

    <script>
        let success = document.getElementById('success');
        if (success) {
            setTimeout(() => { success.innerText = '';window.location.href = '../main.php' }, 3000);
        }

// ---------------password hidden eye ---------------
let p=document.getElementById('pass')
let f = document.getElementById('eye')
f.addEventListener('click',()=>{
    cl = f.classList[1]
    if(cl == 'fa-eye-slash'){
        f.className = 'fa-regular fa-eye'
        p.type = 'text'
    }else{
        f.className = 'fa-regular fa-eye-slash'
        p.type = 'password'
    }
})
    </script>
</body>
</html>
