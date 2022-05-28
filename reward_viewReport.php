<?php
    require "header.php";
    require "conn.php";
    $loginId = $_SESSION['loginId'];

    if ($user != "participant") 
    {
        die("page unavailable");
    }

    // participant information
    $sql_particiapntInfo = "SELECT participantId, name FROM participant WHERE loginId = '$loginId';";
    $participantInfo = mysqli_fetch_array(mysqli_query($con, $sql_particiapntInfo));
    $participantId = $participantInfo['participantId'];
    $participantName = $participantInfo['name'];


    // report info
    $sql_rewardReport = "SELECT * FROM rewardpointhistory WHERE participantId = '$participantId';";
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
    
        <div class="aReward">
            <div class="rewardHeader">
                <div class="rewardName"><?php echo $participantName ; ?></div>
                <div class="rewardId">id : <?php echo $participantId ; ?></div>
            </div>
            <div class="others">
                <?php
                    $amount = 1;
                    while ($rewardReport = mysqli_fetch_array($sql_rewardReportQuery))
                    { 

                        $date_time = $rewardReport['date'];

                        // reward information
                        $sql_rewardInfo = "SELECT itemName FROM reward WHERE rewardId = '$rewardReport[rewardId]';";
                        $rewardInfo = mysqli_fetch_array(mysqli_query($con, $sql_rewardInfo));
                        $rewardName = $rewardInfo['itemName'];
                ?>
                    <div class="aDetail">
                        <div class="amount"><?php echo $amount ; ?>.</div>
                        <div class="participantName"><?php echo $rewardName ; ?></div>
                        <div class="date_time"><?php echo $date_time ; ?></div>
                    </div>       

                <?php
                    $amount = $amount + 1;
                    } 
                    if ($amount == 1) 
                    {
                        echo "there is no record";
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