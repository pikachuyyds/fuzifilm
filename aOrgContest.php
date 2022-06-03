<?php
    require "header.php";
    require "conn.php";

    $id = $_GET["id"];
    $userType = 'organiser';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE organiserID = '$id' ");
    $userResult = mysqli_fetch_array($userData);

    $name = $userResult['name'];
    $phoneNo = $userResult['phoneNo'];
    $companyNo = $userResult['companyNo'];
    $street = $userResult['street'];
    $city = $userResult['city'];
    $state = $userResult['state'];
    $postcode = $userResult['postCode'];
    $country = $userResult['country']; 

    if ($userResult['profilePic'] === null){
        $pic = 'uploads/defaultProfile.png';
    }else{
        $pic = $userResult['profilePic'];
    }

    $profileUrl = "<a href = 'aOrgProfile.php?id=$id '> Personal Information </a>";
    $contestUrl =  "<a href = 'aOrgContest.php?id=$id'> Contest History</a>";
    $reportUrl = "<a href = 'aOrgReport.php?id=$id'> Report </a>";

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
?>

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | View Organiser Contest History </title>
        <link href = "css/aOrgContest.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = headerSection>
            <div>
                <div class = "userInfo"><?php echo strtoUpper("<p>$userType</p>") ?></div>
                <div class = "userName"><?php echo "$name"?></div>
                
                <div class = "pageInfo">
                    <?php
                        echo "<ul>";
                        echo "<li>$profileUrl</li>";
                        echo "<li>$contestUrl</li>";
                        echo "<li>$reportUrl</li>";
                        echo "</ul>";
                    ?>
                </div>
                <form method = "post">
                <div class = "btn">
                    <a href="deleteOrg.php?id=<?php echo $id ?>" class="button" onclick="return confirm('Do you really want to delete this organiser?')"><img src="images\removebtn.png" alt="remove btn"></a>
                </div>
            </form>
            </div>
            <div class="image"><img src="<?php echo $pic?>" alt="profile picture"></div>
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
                                echo("<a href ='contest_aContest.php?id=$conductedId[$i]'>$conductedName[$i]</a><br><br><br><br>");
                            }
                        }else{
                            echo "<b>No Conducted Contest</b>";
                        }
                        
                    ?>
                </div>

                <div class = "ongoing">
                    <h1>Ongoing Contest</h1>
                    <br>
                    <?php
                       if ($countOn>0){
                            for ($i= 0; $i<$countOn; $i++ ){
                                echo("<a href ='contest_aContest.php?id=$ongoingId[$i]'>$ongoingName[$i]</a><br><br><br><br>");
                            }
                        }else{
                            echo "<b>No Ongoing Contest</b>";
                        }
                        mysqli_close($con);
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
<?php require "footer.php"?>
