<?php
require "conn.php";
require "header.php";

$loginData = mysqli_query($con, "SELECT * FROM login");
$loginResult = mysqli_fetch_array($loginData);

$participantData = mysqli_query($con, "SELECT * FROM participant");
$participantResult = mysqli_fetch_array($participantData);

$portfolio = mysqli_query($con, "SELECT * FROM participantlist WHERE participantListId = '$loginResult[loginId]'");


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
                <p>Participant
            <?php   
                if ($loginResult["loginId"] == $participantResult["participantId"]){
                    if ($participantResult["banStartDate"] != null){
                        echo "<banDate> banned until  " .$participantResult['banEndDate']. "</banDate>";
                    }
                } 
            ?>
            </p>
            </div> 
                
            <div class = "userName">
                <?php
                    if ($loginResult["loginId"] == $participantResult["participantId"]){
                        echo "$participantResult[name]";
                        echo "<img src='images/". $participantResult['profilePic']."'/>";
                    }
                ?>
            </div>

            <div class = "pageInfo">
                <ul>
                    <li><a href = "participantProfile.php"> Personal Information </a></li>
                    <li><a href = "participantPortfolio.php"> Portfolio </a></li>
                </ul>
            </div>
        </div>
        
        <div class = portfolio>
            <p>PORTFOLIO</p>
            <div class = picture>
                <?php
                    if (mysqli_num_rows($portfolio)>0){
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