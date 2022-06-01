<?php
    require "header.php";
    require "conn.php";
    $loginId = $_SESSION['loginId'];

    if ($user != "participant") 
    {
        die("page unavailable");
    }

    // participant information
    $sql_particiapntInfo = "SELECT participantId FROM participant WHERE loginId = '$loginId';";
    $participantInfo = mysqli_fetch_array(mysqli_query($con, $sql_particiapntInfo));
    $participantId = $participantInfo['participantId'];

    // participant joined contest
    $sql_joinedContestInfo = "SELECT contestId, joinDate FROM participantlist WHERE participantId = '$participantId';";
    $sql_joinedContestInfoQuery = mysqli_query($con, $sql_joinedContestInfo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\reward_viewReport.css">
    <title>contest history</title>
</head>
<body>
     <div class="reportTitle">Contest history</div>
     <div class="allRewardContainer">
    
        <div class="aReward">
            <div class="rewardHeader">
                <div class="rewardName">Joined Contest</div>
                <div class="rewardId" style="color: #5B3E38;">empty</div>
            </div>
            <div class="others">
                <?php
                    $amount = 1;
                    while ($joinContest = mysqli_fetch_array($sql_joinedContestInfoQuery))
                    { 
                        $contestId = $joinContest['contestId'];
                        $joinDate = $joinContest['joinDate'];

                        // get contest name
                        $sql_contestInfo = "SELECT contestName FROM contest WHERE contestId = '$contestId';";
                        $contestInfo = mysqli_fetch_array(mysqli_query($con, $sql_contestInfo));
                        $contestName = $contestInfo['contestName'];
                ?>
                    <a href="contest_aContest.php?id=<?php echo $contestId; ?>">
                        <div class="aDetail">
                            <div class="amount"><?php echo $amount ; ?>.</div>
                            <div class="participantName"><?php echo $contestName ; ?></div>
                            <div class="date_time"><?php echo $joinDate ; ?></div>
                        </div>       
                    </a>

                <?php
                    $amount = $amount + 1;
                    } 
                    if ($amount == 1) 
                    {
                        echo "there is no joined contest";
                    }
                ?>
            </div>
        </div>
     </div>
</body>
</html>


<?php
    require "footer.php";
?>