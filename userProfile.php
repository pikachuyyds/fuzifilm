<?php
require "conn.php";
require "header.php";

if (isset($_SESSION['loginId'])){
    // to determine participant or organiser or admin
    $userType = $_SESSION['userType'];
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$_SESSION[loginId]' ");
    $userResult = mysqli_fetch_array($userData);

    if ($userType == 'participant'){
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

        $profileUrl =  "<a href = 'userProfile.php'> Personal Information </a>";
        $portfolioUrl = "<a href = 'participantPortfolio.php'> Portfolio </a>";

    } else if ($userType == 'organiser'){
        $name = $userResult['name'];
        $phoneNo = $userResult['phoneNo'];
        $companyNo = $userResult['companyNo'];
        $street = $userResult['street'];
        $city = $userResult['city'];
        $state = $userResult['state'];
        $postcode = $userResult['postCode'];
        $country = $userResult['country']; 
    
        $profileUrl = "<a href = 'userProfile.php'> Personal Information </a>";
        $contestUrl =  "<a href = 'organiserContest.php'> Contest </a>";
        $reportUrl = "<a href = 'organiserReport.php'> Report </a>";

    } else{ //admin
        $name = $userResult['name'];
        $dob = $userResult['dob'];
        $phoneNo = $userResult['phoneNo'];

        $profileUrl = "<a href = 'userProfile.php'> Personal Information </a>";
        $reportUrl = "<a href = 'adminReport.php'> Report </a>";
    }
    
    if ($userResult['profilePic'] === null){
        $pic = 'uploads/defaultProfile.png';
    }else{
        $pic = $userResult['profilePic'];
    }
}
?> 

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | User Profile </title>
        <link href = "css/userProfile.css" rel = "stylesheet" type = "text/css">
    </head>
    <body> 
        <div class = headerSection>
            <div class="image"><img src="<?php echo $pic?>" alt="profile picture"></div>
            <div class = "userInfo">
                <?php
                    echo strtoUpper("<p>$userType</p>");   
                    if ($userType == 'participant'){
                        if ($banStart!= null){
                            echo "<banDate> banned until  " .$banEnd. "</banDate>";
                        }
                    }
                ?>
            </div> 
                
            <div class = "userName"><?php echo "$name"?></div>
            
            

            <div class = "pageInfo">
                <?php
                    echo "<ul>";    
                    if ($userType == 'participant'){
                        echo "<li>$profileUrl</li>";
                        echo "<li>$portfolioUrl</li>";
                    }
                    else if ($userType == 'organiser'){
                        echo "<li>$profileUrl</li>";
                        echo "<li>$contestUrl</li>";
                        echo "<li>$reportUrl</li>";
                    }
                    else if ($userType == 'admin'){
                        echo "<li>$profileUrl</li>";
                        echo "<li>$reportUrl</li>";
                    }else{
                        echo "";
                    }
                    echo "</ul>";
                ?>
            </div>
        </div>

        <div class = "userProfile">
            <p>PROFILE</p>
            <div class = "data">
                <?php
                    if ($userType == 'participant'){
                        echo '<b>Name</b><br>'.$name.'<br>'.'<br>';
                        echo '<b>Date of Birth</b><br>'.$dob.'<br>'.'<br>';
                        echo '<b>Phone Number</b><br>'.$phoneNo.'<br>'.'<br>';
                        echo '<b>Date Joined</b><br>'.$joinDate.'<br>'.'<br>';
                        echo '<b>Street</b><br>'.$street.'<br>'.'<br>';
                        echo '<b>City</b><br>'.$city.'<br>'.'<br>';
                        echo '<b>State</b><br>'.$state.'<br>'.'<br>';
                        echo '<b>Postcode</b><br>'.$postCode.'<br>'.'<br>';
                        echo '<b>Country</b><br>'.$country.'<br>'.'<br>'.'<br>'; 
                        echo '<b>Leaderboard Point</b><br>'.$leaderboard.'<br>'.'<br>';
                        echo '<b>Redeem Reward Point</b><br>'.$rewardRedeem.'<br>'.'<br>';
                    }
                    else if ($userType == 'organiser'){
                        echo '<b>Name</b><br>'.$name.'<br>'.'<br>';
                        echo '<b>Phone Number</b><br>'.$phoneNo.'<br>'.'<br>';
                        echo '<b>Company Number</b><br>'.$companyNo.'<br>'.'<br>';
                        echo '<b>Street</b><br>'.$street.'<br>'.'<br>';
                        echo '<b>City</b><br>'.$city.'<br>'.'<br>';
                        echo '<b>State</b><br>'.$state.'<br>'.'<br>';
                        echo '<b>Postcode</b><br>'.$postCode.'<br>'.'<br>';
                        echo '<b>Country</b><br>'.$country.'<br>'.'<br>'.'<br>'; 
                    }
                    else if ($userType == 'admin'){
                        echo '<b>Name</b><br>'.$name.'<br>'.'<br>';
                        echo '<b>Date of Birth</b><br>'.$dob.'<br>'.'<br>';
                        echo '<b>Phone Number</b><br>'.$phoneNo.'<br>'.'<br>';
                    }
                    else{
                        echo '<b>You are not participant or organiser or admin.</b>';
                    }
                    mysqli_close($con);
                ?>
            </div>
        </div>
    </body>
</html>        
<?php require "footer.php"?>