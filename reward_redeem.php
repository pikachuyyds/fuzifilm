<?php
    require "header.php";
    require "conn.php";
    $loginId = $_SESSION['loginId'];
    $rewardId = $_GET['rewardId'];

    // user validation
    if ($user != "participant")
    {
        die("you're not allow to access to this page");
    }

    // reward information
    $sql_rewardInfo = "SELECT * FROM reward WHERE rewardId = '$rewardId';";
    $rewardInfo = mysqli_fetch_array(mysqli_query($con,$sql_rewardInfo));

    $name = $rewardInfo['itemName'];
    $image = $rewardInfo['rewardImage'];
    $pointRequired = (int)$rewardInfo['pointRequired'];
    $stock = (int)$rewardInfo['stock'];

    
    // participant informtion
    $sql_participantPoints = "SELECT participantId, rewardRedemptionPoint FROM participant WHERE loginId = '$loginId';";
    $participantInfo = mysqli_fetch_array(mysqli_query($con,$sql_participantPoints));
    $participantId = $participantInfo['participantId'];
    $participantPoints = (int)$participantInfo['rewardRedemptionPoint'];
    
    if ($stock == 0) 
    {
        $stockCaption = "no stock";
    }
    else
    {
        $stockCaption = "Stock : " . $stock;
    }

    $red = "color: red;";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\reward_add.css">
    <title>reward</title>
    <script src="js\reward_add.js"></script>
</head>
<body>
    <div class="title">Redeem reward</div>
    <form method="POST" enctype="multipart/form-data">
    <div class="addReward_container">
        <!-- reward image -->
        <div class="addImage">
            <img id="preview" src="<?php echo $image; ?>" alt="Profile Image">
            <label class="addImg" style="cursor: default;<?php if ($stock == 0){ echo $red;} ?>"><?php echo $stockCaption; ?></label> 
        </div>

        <!-- input reward information -->
        <div class="others">
            <div>
                <label for="name">Name</label><br>
                <input type="text" placeholder="enter a name" pattern="[a-zA-Z0-9-]+" name="name" id="name" value="<?php echo $name; ?>" disabled></input><br>
            </div>

            <div>
                <label for="points">Required points</label><br>
                <input type="number" name="points" id="points" value="<?php echo (int)$pointRequired; ?>" disabled></input><br>
            </div>

            <div>
                <label for="stock">Your points</label><br>
                <input type="number" name="stock" id="stock" value="<?php echo $participantPoints; ?>" style="<?php if ((int)$pointRequired > (int)$participantPoints){ echo $red;} ?>" disabled></input><br>
            </div>
            <input type="submit" name="submit" class="button" value="redeem" <?php if (($stock == 0) ||((int)$pointRequired > (int)$participantPoints)) { echo "disabled";} ?> onclick="return confirm('Are you sure you wanna redeem the reward?')">
        </div>
        </form>
    </div>
</body>
</html>


<?php
    require "footer.php";

    if (isset($_POST['submit']))
    {
        // minus participant's point
        $finalPPoint = (int)$participantPoints - (int)$pointRequired;
        $sql_updatePPoint = "UPDATE participant SET rewardRedemptionPoint = '$finalPPoint' WHERE loginId = '$loginId';";
        
        // minus stock 
        $finalStock = $stock - 1;
        $sql_updateStock = "UPDATE reward SET stock = '$finalStock' WHERE rewardId = '$rewardId';";

        // update redeem reward history
        $now = date('Y/m/d h:i:sa');
        $sql_rrh = "INSERT INTO rewardpointhistory (date, rewardId , participantId) VALUES ('$now', '$rewardId', '$participantId');";



        if (!mysqli_query($con, $sql_updatePPoint)) 
        {
            die("update participant point failed");
        } 
        else 
        {
            if (!mysqli_query($con, $sql_updateStock)) 
            {
                die("update stock failed");
            }
            else 
            {
                if (!mysqli_query($con, $sql_rrh)) 
                {
                    die("update redeem reward history failed");
                }
                else
                {
                    echo "<script>alert('redeemed successfully');
                    window.location.href = 'reward_all.php';
                    </script>";
                }
            }
        }
    }
?>