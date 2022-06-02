<?php
    require "header.php";
    require "conn.php";
    $loginId = $_SESSION['loginId'];

    // user validation
    if ($user != "admin")
    {
        die("you're not allow to access to this page");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\reward_add.css">
    <title>add reward</title>
    <script src="js\reward_add.js"></script>
</head>
<body>
    <div class="title">New reward</div>
    <form method="POST" enctype="multipart/form-data">
    <div class="addReward_container">
        <!-- reward image -->
        <div class="addImage">
            <img id="preview" src="images\homePhoto1.jpg" alt="Profile Image">
            <label class="addImg"><input type="file" accept="image/jpg, image/jpeg, image/png" name="image" id="image" onchange="previeww()" required>select image</label> 
        </div>

        <!-- input reward information -->
        <div class="others">
            <div>
                <label for="name">Name</label><br>
                <input type="text" placeholder="enter a name" pattern="[a-zA-Z0-9- ]+" name="name" id="name" required></input><br>
            </div>

            <div>
                <label for="points">Required points</label><br>
                <input type="number" name="points" id="points" value="1" min="1" required></input><br>
            </div>

            <div>
                <label for="stock">Stocks amount</label><br>
                <input type="number" name="stock" id="stock" value="0" min="0" required></input><br>
            </div>
            <input type="submit" name="submit" class="button" value="Add">
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
            die('no image detected');
        }

        // get adminID
        $sql_adminInfo = "SELECT adminId FROM admin WHERE loginId = '$loginId';";
        $adminId = mysqli_fetch_array(mysqli_query($con,$sql_adminInfo));


        $sql_newReward = "INSERT INTO reward (itemName, rewardImage, pointRequired, stock, adminId) VALUES ('$_POST[name]', '$fileLocation', '$_POST[points]','$_POST[stock]','$adminId[adminId]');";

        if(!mysqli_query($con, $sql_newReward))
        {
            die('error'.mysqli_error($con));
        }
        else
        {
            echo "<script>alert('added successfully');</script>";
        }
    }
?>