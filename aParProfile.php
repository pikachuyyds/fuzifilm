<?php
    require "header.php";
    require "conn.php";

    $id = $_GET["id"];
    $userType = 'participant';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE participantId = '$id' ");
    $userResult = mysqli_fetch_array($userData);

    $name = $userResult['name'];
    $dob = $userResult['dob'];
    $phoneNo = $userResult['phoneNo'];
    $joinDate = $userResult['joinDate'];
    $street = $userResult['street'];
    $city = $userResult['city'];
    $state = $userResult['state'];
    $postcode = $userResult['postCode'];
    $country = $userResult['country'];
    $leaderboard = $userResult['leaderboardPoint'];
    $rewardRedeem = $userResult['rewardRedemptionPoint'];
    $banStart = $userResult['banStartDate'];
    $banEnd = $userResult['banEndDate'];

    if ($userResult['profilePic'] === null){
        $pic = 'uploads/defaultProfile.png';
    }else{
        $pic = $userResult['profilePic'];
    }

    $profileUrl =  "<a href = 'aParProfile.php?id=$id'> Personal Information </a>";
    $portfolioUrl = "<a href = 'aParPortfolio.php?id=$id '> Portfolio </a>";
?>

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | View Participant Profile </title>
        <link href = "css/aParProfile.css" rel = "stylesheet" type = "text/css">
    </head>

    <body> 
        <div class = headerSection>
            <div class="image"><img src="<?php echo $pic?>" alt="profile picture"></div>
            <div class = "userInfo">
                <?php
                    echo strtoUpper("<p>$userType</p>"); 
                    if ($banStart!= null){
                        echo "<banDate> banned until  " .$banEnd. "</banDate>";
                    }
                    
                ?>
            </div> 
                
            <div class = "userName"><?php echo "$name"?></div>

            <div class = "pageInfo">
                <?php
                    echo "<ul>";    
                    echo "<li>$profileUrl</li>";
                    echo "<li>$portfolioUrl</li>";
                    echo "</ul>";
                ?>
            </div>
            <form method = "post">
                <div class = "btn">
                    <a href="adminEditPar.php?id=<?php echo $id; ?>" class="button"><img src="images\editbtn.png" alt="edit btn"></a>
                    <a href="deletePar.php?id=<?php echo $id ?>" class="button" onclick="return confirm('Do you really want to delete this participant?')"><img src="images\removebtn.png" alt="remove btn"></a>
                </div>
            </form>
        </div>

        <div class = "userProfile">
            <p>PROFILE</p>
            <div class = "data">
                <?php
                    echo '<b>Name</b><br>'.$name.'<br>'.'<br>';
                    echo '<b>Date of Birth</b><br>'.$dob.'<br>'.'<br>';
                    echo '<b>Phone Number</b><br>'.$phoneNo.'<br>'.'<br>';
                    echo '<b>Date Joined</b><br>'.$joinDate.'<br>'.'<br>';
                    echo '<b>Street</b><br>'.$street.'<br>'.'<br>';
                    echo '<b>City</b><br>'.$city.'<br>'.'<br>';
                    echo '<b>State</b><br>'.$state.'<br>'.'<br>';
                    echo '<b>Postcode</b><br>'.$postcode.'<br>'.'<br>';
                    echo '<b>Country</b><br>'.$country.'<br>'.'<br>'.'<br>'; 
                    echo '<b>Leaderboard Point</b><br>'.$leaderboard.'<br>'.'<br>';
                    echo '<b>Redeem Reward Point</b><br>'.$rewardRedeem.'<br>'.'<br>';

                    mysqli_close($con);
                ?>
            </div>
        </div>
    </body>
</html>
<?php require "footer.php" ?>

