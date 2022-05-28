<?php
    require "header.php";
    require "conn.php";

    $organiserData = mysqli_query($con, "SELECT * FROM organiser");
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> FUZIFILM | View Organiser Profile </title>
        <link href = "css/adminViewOrganiser.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = "headerSection">
            <div class = "title">Organiser Profile</div>
            <div class = "search">
                <form method = "post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" >
                    <label for = "searchTitle">Search: </label>
                    <input type = "search" id = "search" name = "search">
                </form>
            </div>
        </div>

        <div class = "data">
            <?php
                while($organiserResult = mysqli_fetch_array($organiserData)){
                    
                    $id = $organiserResult["organiserID"];
                    $name = $organiserResult["name"];
                    $pic = $organiserResult["profilePic"];

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
