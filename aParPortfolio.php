<?php
    require "header.php";
    require "conn.php";

    $id = $_GET["id"];
    $userType = 'participant';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE participantId = '$id' ");
    $userResult = mysqli_fetch_array($userData);

    $name = $userResult['name'];
    $banStart = $userResult['banStartDate'];
    $banEnd = $userResult['banEndDate'];

    $profileUrl =  "<a href = 'aParProfile.php?id=$id '> Personal Information </a>";
    $portfolioUrl = "<a href = 'aParPortfolio.php?id=$id '> Portfolio </a>";

    if ($userResult['profilePic'] === null){
        $pic = 'uploads/defaultProfile.png';
    }else{
        $pic = $userResult['profilePic'];
    }
    
    $portfolio = mysqli_query($con, "SELECT * FROM participantlist WHERE participantId = '$id'");
    $countPic = mysqli_num_rows($portfolio);

?> 

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | View Participant Portfolio </title>
        <link href = "css/aParPortfolio.css" rel = "stylesheet" type = "text/css">
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
                    <button type= 'submit' name ='delete' onclick = 'deleteProfile();'>DELETE</button> 
                </div>
            </form>
        </div>
        
        <div class = portfolio>
            <p>PORTFOLIO</p>
            <div class = "image">
                <?php
                    if ($countPic>0){
                        while($portfolioResult = mysqli_fetch_array($portfolio)){
                            echo"<div class = 'img' img src=". $portfolioResult['photo']." alt = 'portfolio img'>";
                        }
                    }else{
                        echo"<b>No Picture</b>";
                    }
                    mysqli_close($con);
                ?>
            </div> 
        </div>
    </body>
</html>         
<?php require "footer.php"?>   

<script>
    function deleteProfile(){
        if (confirm("Do you really want to delete this participant?")){
            window.location.href = 'deletePar.php?id=<?php $id ?>';
        }
    }
</script>