<?php
    require "header.php";
    require "conn.php";


    // user validation
    if ($user == "organiser")
    {
        die("you're not allow to access to this page");
    } 
    else if ($user != "guest") 
    {
        $loginId = $_SESSION['loginId'];
    }

    $sql_allRewards = "SELECT * FROM reward;";
    $sql_allRewardsQuery = mysqli_query($con, $sql_allRewards);

    if ($user == "guest")
    {
        $caption = "Sign up as a participant to get points";
    }
    else if ($user == "participant")
    {
        $sql_participantPoints = "SELECT rewardRedemptionPoint FROM participant WHERE loginId = '$loginId';";
        $participantInfo = mysqli_fetch_array(mysqli_query($con,$sql_participantPoints));
        $participantPoints = $participantInfo['rewardRedemptionPoint'];
        $caption = "Available points : " . $participantPoints;
    } 
    else if ($user == "admin") 
    {
        $caption = "Welcome, Admin";
    } 
    else {
        die("page unavailable");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\reward_all.css">
    <title>reward</title>
</head>
<body>
    <div class="title">Rewards</div>
    <div class="caption"><?php echo $caption; ?></div>
    <div class="allRewards">
        <?php
        $loopCounter = 0;
        while ($reward = mysqli_fetch_array($sql_allRewardsQuery)) {
            $rewardId = $reward['rewardId'];
            $name = $reward['itemName'];
            $image = $reward['rewardImage'];
            $pointRequired = $reward['pointRequired'];
            $stock = $reward['stock'];
        ?>

        <div class="aReward">
            <div class="reward_image">
                <img src="<?php echo $image; ?>" alt="reward img">
            </div>
            <div class="reward_details">
                <div>
                    <div class="name"><?php echo $name; ?></div>
                    <div class="points"><?php echo $pointRequired; ?> points</div>
                </div>
                <div>
                    <form method="POST">
                        <input type="text" value="<?php echo $rewardId; ?>" name="rewardId" value="rewardId" style="display: none;">
                        <?php
                        $redeem = "<a href='reward_redeem.php?rewardId=". $rewardId ."; ?>' class='redeemBtn' style= color:white;'>redeem</a>";
                        $redeemDisabled = "<div class='redeemBtn'>redeem</div>";
                        if (isset($participantPoints)) 
                        {
                            echo $redeem;
                        }
                        else if ($user == "admin")
                        { ?>
                            <a href="reward_edit.php?rewardId=<?php echo $rewardId; ?>" class="editBtn"><img src="images\editbtn.png" alt="edit btn"></a>
                            <a href="reward_remove.php?rewardId=<?php echo $rewardId; ?>" class="editBtn" onclick="return confirm('Are you sure you wanna delete the reward?')"><img src="images\removebtn.png" alt="remove btn"></a>
                        <?php }
                        else 
                        {
                            echo $redeemDisabled;
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <?php 
            $loopCounter = $loopCounter + 1;
            } if ($loopCounter == 0) {
                echo "Sorry, there is no reward to redeem currently.";
            }?>
    </div>

    
</body>
</html>


<?php
    require "footer.php";
 
    if (isset($_POST['removeReward'])) 
    {
        echo "hi";
    }
?>