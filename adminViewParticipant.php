<?php
    require "header.php";
    require "conn.php";

    $participantData = mysqli_query($con, "SELECT * FROM participant");
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> FUZIFILM | View Participant Profile </title>
        <link href = "css/adminViewParticipant.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = "headerSection">
            <div class = "title">Participant Profile</div>
            <div class = "search">
                <form method = "post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" >
                    <label for = "searchTitle">Search: </label>
                    <input type = "search" id = "search" name = "search">
                </form>
            </div>
        </div>

        <div class = "data">
            <?php
                while($participantresult = mysqli_fetch_array($participantData)){
                    
                    $id = $participantresult["participantId"];
                    $name = $participantresult["name"];
                    $pic = $participantresult["profilePic"];

            ?>
                <a href = "aUserProfile.php?id = <?php echo $id; ?>"><div class = "aUserProfile">
                    <div class = "profileInfo"><?php echo $name ?></div>
                    <div class = "profileInfo">
                        <div class = "img">
                            <img src = "<?php echo $pic ?>" alt = "profile pic">
                        </div>
                    </div>

                </div></a>

            <?php } ?>
        </div>
    </body>
</html>
<?php require "footer.php" ?>
