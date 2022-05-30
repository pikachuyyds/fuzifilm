<?php
require "conn.php";
require "header.php";

if (isset($_SESSION['loginId'])){

    $userType = 'participant';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$_SESSION[loginId]' ");
    $userResult = mysqli_fetch_array($userData);

    $name = $userResult['name'];
    $banStart = $userResult['banStartDate'];
    $banEnd = $userResult['banEndDate'];

    $profileUrl =  "<a href = 'userProfile.php'> Personal Information </a>";
    $portfolioUrl = "<a href = 'participantPortfolio.php'> Portfolio </a>";

    if ($userResult['profilePic'] === null){
        $pic = 'uploads/defaultProfile.png';
    }else{
        $pic = $userResult['profilePic'];
    }
    
    $portfolio = mysqli_query($con, "SELECT * FROM participantlist WHERE participantId = '$_SESSION[loginId]'");
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
        </div>
        
        <div class = portfolio>
            <p>PORTFOLIO</p>
            <div class = image>
                <?php
                    if ($countPic>0){
                        while($portfolioResult = mysqli_fetch_array($portfolio)){
                            echo"<div class = 'img' img src=". $portfolioResult['photo']." alt = 'portfolio img'>";
                        }
                    }else{
                        echo"<b>No Pictures</b>";
                    }
                    mysqli_close($con);
                ?>
            </div> 
        </div>
    </body>
</html>         
<?php require "footer.php"?>   