<?php
    require "header.php";
    require "conn.php";

    $id = $_GET["id"];
    $userType = 'organiser';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$id' ");
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

    $profileUrl = "<a href = 'aOrgProfile.php?id = $id '> Personal Information </a>";
    $contestUrl =  "<a href = 'aOrgContest.php?id = $id'> Contest History</a>";
    $reportUrl = "<a href = 'aOrgReport.php?id = $id'> Report </a>";
?>

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | View Organiser Profile </title>
        <link href = "css/aOrgProfile.css" rel = "stylesheet" type = "text/css">
    </head>
    <body> 
        <div class = headerSection>
            <div class="image"><img src="<?php echo $pic?>" alt="profile picture"></div>
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
                    <button type= 'submit' name='edit' onclick = 'window.location.href = "adminEditOrg.php?id = <?php $id ?>"'>EDIT</button>
                    <button type= 'submit' name ='delete' onclick = 'deleteProfile();'>DELETE</button> 
                </div>
            </form>
        </div>

        <div class = "userProfile">
            <p>PROFILE</p>
            <div class = "data">
                <?php
                    echo '<b>Name</b><br>'.$name.'<br>'.'<br>';
                    echo '<b>Phone Number</b><br>'.$phoneNo.'<br>'.'<br>';
                    echo '<b>Company Number</b><br>'.$companyNo.'<br>'.'<br>';
                    echo '<b>Street</b><br>'.$street.'<br>'.'<br>';
                    echo '<b>City</b><br>'.$city.'<br>'.'<br>';
                    echo '<b>State</b><br>'.$state.'<br>'.'<br>';
                    echo '<b>Postcode</b><br>'.$postcode.'<br>'.'<br>';
                    echo '<b>Country</b><br>'.$country.'<br>'.'<br>'.'<br>'; 

                    mysqli_close($con);
                ?>
            </div>
        </div>
    </body>
</html>
<?php require "footer.php" ?>

<script>
    function deleteProfile(){
        if (confirm("Do you really want to delete this organiser?")){
            window.location.href = 'deleteOrg.php?id = <?php $id ?>';
        }
    }
</script>