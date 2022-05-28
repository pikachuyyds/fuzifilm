<?php
    require "header.php";
    require "conn.php";

    $participantData = mysqli_query($con, "SELECT * FROM participant");
    $participantresult = mysqli_fetch_array($participantData);
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

    </body>