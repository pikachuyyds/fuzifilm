<?php
    require "header.php";
    require "conn.php";

    $id = $_GET["id"];
    $userType = 'organiser';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$id' ");
    $userResult = mysqli_fetch_array($userData);

    $name = $userResult['name'];
    $phoneNo = $userResult['phoneNo'];
    $street = $userResult['street'];
    $city = $userResult['city'];
    $state = $userResult['state'];
    $postcode = $userResult['postCode'];
    $country = $userResult['country']; 

    if ($userResult['profilePic'] === null){
        $pic = 'uploads/defaultProfile.png';
    }else{
        $pic = $userResult['profilePic'];
    }
?>

<!DOCTYPE html>
    <html lang = en>
        <head>
            <title>Fuzifilm | Admin Edit Organiser Profile</title>
            <link href = "css/adminEditOrg.css" rel = "stylesheet" type = "text/css">
            <script src="js\reward_add.js"></script>
        </head>
        <body>
            <div class="title">
                EDIT PROFILE
            </div>
            <div class="data">
                <?php
                    echo "
                    <form method = 'POST' enctype = 'multipart/form-data'> 
                        <label for = 'name'>Name: </label>
                        <input type = 'text' name = 'name' value = '$name' id='name' pattern='[A-Za-z ]{1,50}' oninvalid='invalidMessage(\"FnameID\")' required>
                        <br>
                        <label for = 'phone'>Phone Number: </label>
                        <input type = 'text' name = 'phone' value = '$phoneNo' id='phone' pattern='0.{9,12}' title='phone number invalid' required>
                        <br>
                        <label for = 'street'>Address Line: </label>
                        <input type='text' name='street' id='street' value = '$street' required>
                        <br>
                        <label for = 'city'>City: </label>
                        <input type = 'text' name = 'city' id = 'city' value = '$city' required>
                        <br>
                        <label for = 'state'>State: </label>
                        <input type = 'text' name = 'state' id = 'state' value = '$state' required>
                        <br>
                        <label for = 'postcode'>Postcode: </label>
                        <input type = 'number' name = 'postcode' id = 'postcode' value = '$postcode' required>
                        <br>
                        <label for = 'country'>Country: </label>
                        <input type = 'text' name = 'country' id = 'country' value = '$country' required>
                        <br>
                        <label for = 'picture'>Profile Picture: </label>
                        <div class = 'uploadImage'>
                            <img id='preview' src='$pic' alt='Profile Image'>
                            <label class = 'image'> <input type = 'file' name = 'file' id = 'file' accept='image/jpg, image/jpeg, image/png' onchange='previeww()'>select picture</label>
                        </div>
                        <br>
                        <button type= 'submit' name='submit'>SUBMIT</button>
                        <button type= 'submit' name = 'back'>BACK</button> 
                    </form>";
                ?>
            </div>
        </body>
    </html>
<?php require "footer.php" ?>

<?php

    if (isset($_POST['submit'])){

        if (basename($_FILES['file']['name']) != ""){

            $targetImg_dir = "uploads/";
            $targetFile = $targetImg_dir . basename($_FILES['file']['name']);
            if(!move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)){
                die('Image uploading failed');
            } else { 
                $fileLocation = $targetImg_dir . basename($_FILES['file']['name']); 
            }
        } else {
            $fileLocation = $pic;
        }

        $sql = "UPDATE organiser SET
                            name = '$_POST[name]',
                            phoneNo = '$_POST[phone]',
                            street = '$_POST[street]',
                            city = '$_POST[city]',
                            state = '$_POST[state]',
                            postCode = '$_POST[postcode]',
                            country = '$_POST[country]',
                            profilePic = '$fileLocation'
                    WHERE loginId = '$id'";

        if(!mysqli_query($con, $sql)){
            die('error'.mysqli_error($con));
        }else{
            echo "<script>alert('Data updated');
            window.location.href = 'aOrgProfile.php?id = $id';
            </script>";
        }
    }

    if (isset($_POST['back'])){
        echo "<script>window.location.href = 'aOrgProfile.php?id = $id';</script>";
    }
?>