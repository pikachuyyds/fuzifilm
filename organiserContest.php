<?php
require "conn.php";
require "header.php";

if (isset($_SESSION['loginId'])){

    $userType = 'organiser';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$_SESSION[loginId]' ");
    $userResult = mysqli_fetch_array($userData);

    $id = $userResult["organiserID"];
    $profileUrl = "<a href = 'userProfile.php'> Personal Information </a>";
    $contestUrl =  "<a href = 'organiserContest.php'> Contest </a>";
    $reportUrl = "<a href = 'organiserReport.php'> Report </a>";

    //for conducted contest
    $conductedData = mysqli_query($con, "SELECT * FROM contest WHERE DATE(endDate)<DATE(NOW()) 
                                        AND organiserID = '$id' ");
    while ($conductedResult = mysqli_fetch_array($conductedData)){
        $conductedId[] = $conductedResult["contestId"];
        $conductedName[] = $conductedResult["contestName"];
    }

    //for ongoing contest
    $ongoingData = mysqli_query($con, "SELECT * FROM contest WHERE DATE(endDate)>=DATE(NOW())
                                        AND organiserID = '$id'");
    while ($ongoingResult = mysqli_fetch_array($ongoingData)){
        $ongoingId[] = $ongoingResult["contestId"];
        $ongoingName[] = $ongoingResult["contestName"];
    }

    $countEnd= mysqli_num_rows($conductedData);
    $countOn = mysqli_num_rows($ongoingData); 
}
?> 

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | Organiser Contest </title>
        <link href = "css/organiserContest.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = headerSection>
            <p>Organiser</p>
            <div class = "userName">
                <?php
                    echo "$userResult[name]";
                    echo "<img src='images/". $userResult['profilePic']."'/>";
                    
                ?>
            </div>
            
            <div class = "pageInfo">
                <?php
                    echo "<li>$profileUrl</li>";
                    echo "<li>$contestUrl</li>";
                    echo "<li>$reportUrl</li>";
                ?>
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
                            for ($i= 0; $i<$countEnd; $i++ ){
                                echo("<a href ='$conductedId[$i].php'>$conductedName[$i]</a><br><br><br><br>");
                            }
                        }else{
                            echo "No Conducted Contest";
                        }
                        
                    ?>
                </div>

                <div class = "ongoing">
                    <h1>Ongoing Contest</h1>
                    <br>
                    <?php
                       if ($countOn>0){
                            for ($i= 0; $i<$countOn; $i++ ){
                                echo("<a href ='$ongoingId[$i].php'>$ongoingName[$i]</a><br><br><br><br>");
                            }
                        }else{
                            echo "No Ongoing Contest";
                        }
                        mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
        <?php require "footer.php"?>
    </body>
</html>