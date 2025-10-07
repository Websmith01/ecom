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
    <link rel="stylesheet" href="./main.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>
<body>
    <div class="navbar" >
            <div class="logo">
                PEESHO
            </div>
            <div class="navlink">
                <a href="./product/product.php"><div >PRODUCT</div></a>
                <?php
                    $profile='
                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class=" text-white  focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center " type="button"> PROFILE <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdown" class="z-10 hidden bg-[#708993] divide-y divide-[#708993] rounded-lg shadow-sm w-44 dark:bg-[#708993]">
                            <ul class="py-2 text-sm text-[#253900] dark:text-white" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="" class="block px-4 py-2 hover:bg-[#FFFADC] dark:hover:bg-gray-600 dark:hover:text-white">CART</a>
                            </li>
                            <li>
                                <a href="./userprofile/profile.php" class="block px-4 py-2 hover:bg-[#FFFADC] dark:hover:bg-gray-600 dark:hover:text-white">EDIT PROFILE</a>
                            </li>
                            <li>
                                <a href="./auth/logout.php" class="block px-4 py-2 hover:bg-[#FFFADC] dark:hover:bg-gray-600 dark:hover:text-white">LOG OUT</a>
                            </li>
                            </ul>
                        </div>
                        ';

                    $emsql =$con->prepare("SELECT token FROM customer");
                    $emsql->execute();
                    $user = $emsql->fetchAll();
                    $pr = false;
                    if(isset($_COOKIE['herouser'])){
                        foreach($user as $u){
                            // print_r($u);
                            if(password_verify($u['token'], $_COOKIE['herouser'])){
                                echo $profile;
                                $pr = true;
                                break;
                            }
                        }
                        if($pr==false){
                            echo '<a href="./auth/signup.php" class="ml-[50px]">SIGN UP</a>';
                            echo '<a href="./auth/signin.php" class="ml-[50px]">SIGN IN</a>';

                        }
                    }else{
                        echo '<a href="./auth/signup.php" class="ml-[50px]">SIGN UP</a>';
                        echo '<a href="./auth/signin.php" class="ml-[50px]">SIGN IN</a>';
                    }
                ?>
            </div>
    </div>
</body>
</html>