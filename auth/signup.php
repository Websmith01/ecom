<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
    <link rel="stylesheet" href="./signup.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
         integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
         <a href="./signin.php"><button class="sbtn">Sign In</button></a>
    <?php
        $server = 'localhost';
        $username = 'root';
        $password = '12345';
        $database = 'ecom';

        $link = "mysql:host=$server;dbname=$database";
        $con = new PDO($link,$username,$password);
        // if($con){
        //     echo 'ok connection done';
        // }else{
        //     echo $con;
        // }
    ?>
        <form action="./signup.php" method="post">
            <h1>SIGN UP</h1>
            <input type="text" name="username" placeholder="username" required> <br> <br>
           <input type="email" name="email" placeholder="Enter your Email" id="email" required> <br> <br>
            <input type="password" name="pass" placeholder="Password" id="pass" required>
            <i class="fa-regular fa-eye-slash" id="eye"></i> <br> <br>
            <button type="submit" value="signup">Sign Up</button> <br><br> 
            <button type="reset">Reset</button>
        </form>
   
  
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $un = $_POST['username'];
            $em = $_POST['email'];
            $ps = $_POST['pass'];

            $hps= password_hash($ps,PASSWORD_DEFAULT);

            $insertstmt = $con->prepare("INSERT INTO customer VALUES (?,?,?,?,?,?)");
            try{
                $insertstmt->execute([$em,$un,$hps,'','','']);
                echo '<center><h1 style="color: #A1C2BD; " id="success">SIGNUP SUCCESS</h1></center>';
            }catch (PDOException $e) {
                echo 'Error occurred: ' . $e->getMessage();
            }
        }
    ?> 
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