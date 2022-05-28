<?php
    require "header.php";
    require "conn.php";
    $loginId = $_SESSION['loginId'];

    // user validation
    if ($user != "admin")
    {
        die("page unavailable");
    }
    
    // all report id s 
    $sql_rewardReport = "SELECT DISTINCT rewardId FROM rewardpointhistory;";
    $sql_rewardReportQuery = mysqli_query($con, $sql_rewardReport);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\reward_viewReport.css">
    <title>reward report</title>
</head>
<body>
     <div class="reportTitle">Redeem reward history</div>
     <div class="allRewardContainer">

     <?php 
        while ($allRewardId = mysqli_fetch_array($sql_rewardReportQuery))
        {
            // the specific report history information
            $sql_rewardHistoryInfo = "SELECT * FROM rewardpointhistory WHERE rewardId = '$allRewardId[rewardId]';";
            $sql_rewardHistoryInfoQuery = mysqli_query($con, $sql_rewardHistoryInfo);

            // the specific reward information
            $sql_rewardInfo = "SELECT itemName FROM reward WHERE rewardId = '$allRewardId[rewardId]';";
            $itemName = mysqli_fetch_array(mysqli_query($con, $sql_rewardInfo));
            $rewardName = $itemName['itemName'];
    ?>
            <div class="aReward">
                <div class="rewardHeader">
                    <div class="rewardName"><?php echo $rewardName; ?></div>
                    <div class="rewardId">reward id : <?php echo $allRewardId['rewardId']; ?></div>
                </div>
                <div class="others">
                    <?php 
                        while ($rewardHistoryInfo = mysqli_fetch_array($sql_rewardHistoryInfoQuery))
                        {
                            $amount = 1;
                            // get participant name
                            $participantId = $rewardHistoryInfo['participantId'];
                            $sql_participantName = "SELECT name FROM participant WHERE participantId = '$participantId'";
                            $participantInfo = mysqli_fetch_array(mysqli_query($con, $sql_participantName));
                            $participantName = $participantInfo['name'];

                            // date & time
                            $date_time  = $rewardHistoryInfo['date'];
                    ?>
                        <div class="aDetail">
                            <div class="amount"><?php echo $amount; ?>.</div>
                            <div class="participantName"><?php echo $participantName; ?></div>
                            <div class="date_time"><?php echo $date_time; ?></div>
                        </div>
                    <?php
                        $amount = $amount + 1;
                    }
                    ?>
                </div>
            </div>
    <?php
        }

     ?>
     </div>
</body>
</html>


<?php
    require "footer.php";
?>