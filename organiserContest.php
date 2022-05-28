<?php
include ("conn.php");

$loginData = mysqli_query($con, "SELECT * FROM login");
$loginResult = mysqli_fetch_array($loginData);

$organiserData = mysqli_query($con, "SELECT * FROM organiser");
$organiserResult = mysqli_fetch_array($organiserData);

//for conducted contest
$conductedData = mysqli_query($con, "SELECT * FROM contest WHERE DATE(endDate)<DATE(NOW())");
while ($conductedResult = mysqli_fetch_array($conductedData)){
    $conductedId[] = $conductedResult["contestId"];
    $conductedName[] = $conductedResult["contestName"];
}

//for ongoing contest
$ongoingData = mysqli_query($con, "SELECT * FROM contest WHERE DATE(endDate)>=DATE(NOW())");
while ($ongoingResult = mysqli_fetch_array($ongoingData)){
    $ongoingId[] = $ongoingResult["contestId"];
    $ongoingName[] = $ongoingResult["contestName"];
}

$countEnd= mysqli_num_rows($conductedData);
$countOn = mysqli_num_rows($ongoingData); 

?> 

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | Organiser Contest </title>
        <link href = "css/organiserContest.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <?php //require "header.php"?> 
        <div class = headerSection>
            <p>Organiser</p>
            <div class = "userName">
                <?php
                    if ($loginResult["loginId"] == $organiserResult["organiserID"]){
                        echo "$organiserResult[name]";
                        echo "<img src='images/". $organiserResult['profilePic']."'/>";
                    }
                ?>
            </div>
            
            <div class = "pageInfo">
                <ul>
                    <li><a href = "organiserProfile.php"> Personal Information </a></li>
                    <li><a href = "organiserContest.php"> Contest </a></li>
                    <li><a href = "organiserReport.php"> Report </a></li>
                </ul>
            </div>
        </div>

        <div class = "contest">
            <p>CONTEST</p>
            <div class = "data">
                <div class = "conducted">
                    <h1>Conducted Contest</h1>
                    <br>
                    <?php
                        if ($countEnd>0){
                            if ($loginResult["loginId"] == $organiserResult["organiserID"]){
                                for ($i= 0; $i<$countEnd; $i++ ){
                                    echo("<a href ='$conductedId[$i].php'>$conductedName[$i]</a><br><br><br><br>");
                                }
                            }else{
                                echo "No Conducted Contest";
                            }
                        }else{
                            echo "No Contest Found";
                        }  
                    ?>
                </div>

                <div class = "ongoing">
                    <h1>Ongoing Contest</h1>
                    <br>
                    <?php
                       if ($countOn>0){
                        if ($loginResult["loginId"] == $organiserResult["organiserID"]){
                            for ($i= 0; $i<$countOn; $i++ ){
                                echo("<a href ='$ongoingId[$i].php'>$ongoingName[$i]</a><br><br><br><br>");
                            }
                        }else{
                            echo "No Ongoing Contest";
                        }
                    }else{
                        echo "No Contest Found";
                    }  
                        mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
        <?php //require "footer.php"?>
    </body>
</html>