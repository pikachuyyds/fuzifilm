<?php
require "conn.php";
require "header.php";

if (isset($_SESSION['loginId'])){

    $userType = 'participant';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$_SESSION[loginId]' ");
    $userResult = mysqli_fetch_array($userData);

    $name = $userResult['name'];
    $pic = $userResult['profilePic'];
    $banStart = $userResult['banStartDate'];
    $banEnd = $userResult['banEndDate'];

    $profileUrl =  "<a href = 'userProfile.php'> Personal Information </a>";
    $portfolioUrl = "<a href = 'participantPortfolio.php'> Portfolio </a>";
    
    $portfolio = mysqli_query($con, "SELECT * FROM participantlist WHERE participanId = '$_SESSION[loginId]'");
    $countPic = mysqli_num_rows($portfolio);
}




?> 

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | Participant Portfolio </title>
        <link href = "css/participantPortfolio.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = headerSection>
            <div class = "userInfo">
                <?php   
                    echo strtoUpper("<p>$userType</p>");
                    if ($banStart!= null){
                        echo "<banDate> banned until  " .$banEnd. "</banDate>";
                    }
                    
                ?>
            </div> 
                
            <div class = "userName">
                <?php
                    echo "$name";
                    echo "<img src='images/" .$pic. "'/>";
                ?>
            </div>

            <div class = "pageInfo">
                <?php
                    echo "<ul>";
                    echo "<li>$profileUrl</li>";
                    echo "<li>$portfolioUrl</li>";
                    echo "</ul>";
                ?>
            </div>
        </div>
        
        <div class = portfolio>
            <p>PORTFOLIO</p>
            <div class = picture>
                <?php
                    if ($countPic>0){
                        while($portfolioResult = mysqli_fetch_array($portfolio)){
                            echo"<img src='images/". $portfolioResult['photo']."'/><br>";
                        }
                    }else{
                        echo"<b>No Pictures</b>";
                    }
                    mysqli_close($con);
                ?>
            </div> 
        </div>
        <?php require "footer.php"?>
    </body>
</html>    