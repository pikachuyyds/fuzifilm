<?php
    require "header.php";
    require "conn.php";

    $sql_allParticipant = "SELECT participantId, name, leaderboardPoint FROM participant ORDER BY leaderboardPoint DESC;";
    $sql_allParticipantQuery = mysqli_query($con, $sql_allParticipant);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\leaderboard.css">
    <title>Leaderboard</title>
</head>
<body>
    <div class="container">
        <!-------------------------------------------------- title -------------------------------------------------->
        <div class="title_leaderboard">Leaderboard</div><br>
        <div class="dcrptn_leaderboard">check out who's the best photographer</div>

        <!-------------------------------------------- the 20 participants -------------------------------------------->     
        <div class="leaderboard">
            <?php
                $number = 1; 
                while ($participantInfo = mysqli_fetch_array($sql_allParticipantQuery)) { ?>
                    <div class="participant">
                    <div class="number"><?php echo $number; ?></div>
                    <div class="name"><?php echo $participantInfo['name']; ?></div>
                    <div class="points"><?php echo $participantInfo['leaderboardPoint']; ?> point</div>
            </div>
            <?php $number = $number + 1; } ?>
        </div>
    </div>
</body>
</html>

<?php
    require "footer.php";
?>