<?php
    require "header.php";
    require "conn.php";
    $loginId = $_SESSION['loginId'];
    $rewardId = $_GET['rewardId'];

    // user validation
    if ($user != "admin")
    {     
        die("you're not allow to access to this page");
    }

    $sql_rewardInfo = "SELECT * FROM reward WHERE rewardId = '$rewardId';";
    $rewardInfo = mysqli_fetch_array(mysqli_query($con,$sql_rewardInfo));

    $name = $rewardInfo['itemName'];
    $image = $rewardInfo['rewardImage'];
    $pointRequired = (int)$rewardInfo['pointRequired'];
    $stock = (int)$rewardInfo['stock'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\reward_add.css">
    <title>modify reward</title>
    <script src="js\reward_add.js"></script>
</head>
<body>
    <div class="title">Modify reward</div>
    <form method="POST" enctype="multipart/form-data">
    <div class="addReward_container">
        <!-- reward image -->
        <div class="addImage">
            <img id="preview" src="<?php echo $image; ?>" alt="Profile Image">
            <label class="addImg"><input type="file" accept="image/jpg, image/jpeg, image/png" name="image" id="image" onchange="previeww()">select image</label> 
        </div>

        <!-- input reward information -->
        <div class="others">
            <div>
                <label for="name">Name</label><br>
                <input type="text" placeholder="enter a name" pattern="[a-zA-Z0-9- ]+" name="name" id="name" value="<?php echo $name; ?>" required></input><br>
            </div>

            <div>
                <label for="points">Required points</label><br>
                <input type="number" name="points" id="points" min="1" value="<?php echo (int)$pointRequired; ?>" required></input><br>
            </div>

            <div>
                <label for="stock">Stocks amount</label><br>
                <input type="number" name="stock" id="stock" min="0" value="<?php echo (int)$stock; ?>" required></input><br>
            </div>
            <input type="submit" name="submit" class="button" value="Edit">
        </div>
        </form>
    </div>
</body>
</html>


<?php
    require "footer.php";

    if (isset($_POST['submit'])) 
    {
        // reward image transfer from temporary location to desire location
        if (basename($_FILES['image']['name']) != ""){
            $targetImg_dir = "uploads/";
            $targetFile = $targetImg_dir . basename($_FILES['image']['name']);
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
                die('reward item picture transfering failed');
            } else { $fileLocation = $targetImg_dir . basename($_FILES['image']['name']); }
        } else {
            $fileLocation = $image;
        }


        $sql_editReward = "UPDATE reward SET itemName = '$_POST[name]', rewardImage = '$fileLocation', pointRequired='$_POST[points]' , stock ='$_POST[stock]' WHERE rewardId  = $rewardId;";


        if(!mysqli_query($con, $sql_editReward))
        {
            die('edit error'.mysqli_error($con));
        }
        else
        {
            echo "<script>alert('edited successfully');
            window.location.href = 'reward_all.php';
            </script>";
        }
    }
?>