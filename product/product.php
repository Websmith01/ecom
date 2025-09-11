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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
    <link rel="stylesheet" href="./product.css">
</head>
<body>
    <h1 class="pheader">ALL PRODUCT CATEGORIES</h1>
    <div class="phead">
        <button class="catbtn">GROCERY</button>
        <button class="catbtn">CLOTHING</button>
        <button class="catbtn">ELECTRONICS</button>
    </div>
        <div id="grocery">
            <div class="grid grid-cols-3">
                <?php 
            $datasql = $con->prepare("select * from product where pcategory = 'grocery'; ") ;
            $datasql->execute();
            $data= $datasql->fetchAll();
            foreach($data as $d){
                ?>
                <div class="grid grid-cols-2 border-2 border-black m-3">
                    <img class="catimg ml-8" src="<?php echo $d['imglink'];?>" alt="">
                    <div class="flex items-center flex-col justify-center">
                        <h2><?php echo $d['pname'];?></h2>
                        <h3>Rs. <?php echo $d['pprice'];?></h3>
                        <div class="flex items-center text-[15px]">
                            <select class="border-2 border-black">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                                <option value="">4</option>
                                <option value="">5</option>
                                <option value="">6</option>
                                <option value="">7</option>
                                <option value="">8</option>
                                <option value="">9</option>
                                <option value="">10</option>
                            </select>
                            <button class="border-2 text-[15px] ml-2">ADD TO CART</button>
                        </div>

                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        <div id="clothing">
            <div class="grid grid-cols-3">
                <?php 
            $datasql = $con->prepare("select * from product where pcategory = 'clothing'; ") ;
            $datasql->execute();
            $data= $datasql->fetchAll();
            foreach($data as $d){
                ?>
                <div>
                    <h2><?php echo $d['pname'];?></h2>
                    <h3>Rs. <?php echo $d['pprice'];?></h3>
                </div>
                <?php }?>
            </div>
        </div>
        <div id="electronics">
            <div class="grid grid-cols-3">
                <?php 
            $datasql = $con->prepare("select * from product where pcategory = 'electronics'; ") ;
            $datasql->execute();
            $data= $datasql->fetchAll();
            foreach($data as $d){
                ?>
                <div>
                    <h2><?php echo $d['pname'];?></h2>
                    <h3>Rs. <?php echo $d['pprice'];?></h3>
                </div>
                <?php }?>
            </div>
        </div>
        <script>
            let gro = document.getElementById("grocery")
            let clo = document.getElementById("clothing")
            let elec = document.getElementById("electronics")
            let catbtn = document.getElementsByClassName("catbtn")
            console.log(gro);
            
            for( let btn of catbtn){
                
                btn.addEventListener("click", function(){
                    
                    if (btn.innerText=='GROCERY'){
                        gro.style.height='80vh'
                        clo.style.height='0px'
                        elec.style.height='0px'
                    }else if (btn.innerText=='CLOTHING'){
                        gro.style.height='0px'
                        clo.style.height='80vh'
                        elec.style.height='0px'
                    }else if (btn.innerText=='ELECTRONICS'){
                        gro.style.height='0px'
                        clo.style.height='0px'
                        elec.style.height='80vh'
                    }
                    });
            }
        </script>
</body>
</html>