<?php
    require "header.php";
    require "conn.php";
    $contestId = $_GET['id'];
    $loginId = $_SESSION['loginId'];

    if ($user != "participant") 
    {
        die("page unavailable");
    }

    // get contest information from database
    $sql_contest = "SELECT * FROM contest WHERE contestId = '$contestId';";
    $sql_contestQuery = mysqli_query($con,$sql_contest);
    $contestInfo = mysqli_fetch_array($sql_contestQuery);

    // contest information
    $name = $contestInfo['contestName'];
    $startDate = $contestInfo['startDate'];
    $endDate = $contestInfo['endDate'];

    // paid or free
    $paidOrFree = $contestInfo['paidOrFree'];

    if ($paidOrFree == "free")
    {
        $price = "free";
    } 
    else if ($paidOrFree == "paid")
    {
        $price = $contestInfo['price'];
    }


    // to get the status that shows on every contest's image (either due join date, judging, announced)
    $now = time()-(60*60*24);
    $announcement = date('Y/m/d', strtotime($endDate . ' +14 day')); 

    if ($now >= strtotime($announcement))
    {
        $status = "announced";
    }
    else if($now > strtotime($endDate))
    {
        $status = "judging";  
    }
    else
    {
        if ($now >= strtotime($startDate)) 
        {
            $status = "opening";
        }
        else
        {
            $status = "opening soon";
        }
    }

    // free or paid status
    if ($paidOrFree == "free")
    {
        $requiredPrice = "free";
    }
    else if ($paidOrFree == "paid") 
    {
        $requiredPrice = "RM ".$price;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\contest_join.css">
    <link rel="stylesheet" href="css\reward_add.css">
    <script src="js\reward_add.js"></script>
    <title>Join contest</title>
</head>
<body>
    <div class="title">Join Contest</div>
    <form method="POST" enctype="multipart/form-data">
    <div class="addReward_container">

        <!-- contest information -->
        <div class="others">
            <div>
                <label for="name">Name</label><br>
                <input type="text" name="name" id="name" value="<?php echo $name; ?>" disabled></input><br>
            </div>

            <div>
                <label for="points">End date</label><br>
                <input type="text" name="points" id="points" value="<?php echo $endDate; ?>" disabled></input><br>
            </div>

            <div>
                <label for="stock">Price</label><br>
                <input type="text" name="stock" id="stock" value="<?php echo $requiredPrice; ?>" disabled></input><br>
            </div>

            <!-- payment (for paid contest only) -->
            <?php if ($requiredPrice != "free") { ?>
                
                <div> 
                    Credit Card Number
                    <input name="credit-number" id="cc-number" type="tel" placeholder="0000-0000-0000-0000" pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}" required>
                </div>

                <div>
                    Expiry Date
                    <input name="credit-expires" id="cc-expires" type="tel" placeholder="00/00" pattern="[0-9]{2}/[0-9]{2}" required>
                </div>

                <div>
                    CVV
                    <input name="credit-cvc" id="cc-cvc" type="number" placeholder="000" pattern="[0-9]{3}" required></span>
                </div>

            <?php } ?>
            <input type="submit" name="submit" class="button" value="Join contest">
        </div>

        <!-- reward image -->
        <div class="addImage">
            <img id="preview" src="images\homePhoto1.jpg" alt="Profile Image">
            <label class="addImg"><input type="file" accept="image/jpg, image/jpeg, image/png" name="image" id="image" onchange="previeww()" required>select image</label> 
        </div>

        </form>
    </div>

</body>
</html>

<?php
    require "footer.php";

    if (isset($_POST['submit'])) 
    {
        // participant image transfer from temporary location to desire location
        if (basename($_FILES['image']['name']) != ""){
            $targetImg_dir = "uploads/";
            $targetFile = $targetImg_dir . basename($_FILES['image']['name']);
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
                die('reward item picture transfering failed');
            } else { $fileLocation = $targetImg_dir . basename($_FILES['image']['name']); }
        } else {
            die("participant image transfering failed");
        }

        // current date & time
        $now = date("Y/m/d H:i:s");

        // get participant id by using login id
        $sql_participantInfo = "SELECT participantId FROM participant WHERE loginId = '$loginId';";
        $participantInfo = mysqli_fetch_array(mysqli_query($con,$sql_participantInfo));
        $participantId = $participantInfo['participantId'];

        $sql_upload = "INSERT INTO participantlist (joinDate, photo, participantId, contestId ) VALUES ('$now', '$fileLocation', '$participantId', '$contestId');";

        if (!mysqli_query($con, $sql_upload))
        {
            echo $sql_upload;
            die("upload participant list failed");
        } 
        else 
        {
            if ($requiredPrice != "free") 
            {
                $sql_paymentHistory = "INSERT INTO paymentrecord (amount, date, purpose, payer, receiver, contestId, participantId , organiserID) 
                VALUES ('$price', '$now', 'join contest', 'Participant', 'Organiser', '$contestId', '$participantId', '$contestInfo[organiserID]');";

                if (!mysqli_query($con, $sql_paymentHistory)) 
                {
                    die("upload payment history failed");
                }
                else 
                {
                    echo "<script>
                    alert('Congratulations, you,ve joined the contest');
                    window.location.href = 'contest_aContest.php?id=". $contestId ."';
                    </script>";
                }
            }
        }
    }
?>