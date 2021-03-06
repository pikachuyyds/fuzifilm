<?php
    require "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\home.css">
    <script src="js\header.js"></script>
    <title>Fuzifilm</title>
</head>
<body>
    <div class="allHome">
     <!---------------------------------------------- home 1 ---------------------------------------------->

        <div class="home1">
            <div class="part1">
                <img src="images\logo.png" class="home1Logo" alt="logo">
                <div class="home1P"><br>Join competition & display your portfolio to</div>
                <div class="home1H1">Show the world that you're a photographer</div>
            </div>
            <div class="part2">
                <img src="images\homePhoto1.jpg" class="home1Photo1" alt="photo1">
            </div>
        </div>

        <!---------------------------------------------- home 2 ---------------------------------------------->

        <div class="home2">
            <div class="home2Photo">
                <img src="images\homePhoto2.jpg" class="home2Photo2" alt="photo1">
            </div>
            <div class="home2Dscrpt">
                <div class="home2Title">Join contest <br> / Create contest</div>
                <div class="home2Text">You can always join a contest as a participant or create a contest as an organiser on this platform</div>
                <a href="#contest"><div class="home2Btn">Learn more</div></a>
            </div>
        </div>

        <!---------------------------------------------- home 3 ---------------------------------------------->
        
        <div class="home4">
            <div class="contentDetails">
                <div class="home4Title">
                    <h2>Contact us</h2>
                    <p>"feel free to contact us if you need any help"</p>
                </div>
                <div class="home4Content">
                    <div class="phoneBox">+6019-47980223</div>
                    <div class="emailBox">email@emai.com</div>
                </div>
            </div>
        </div>
        <?php
            require "footer.php";
        ?>
    </div>
</body>
</html>