<?php
require "conn.php";
require "header.php";
$_SESSION['loginId'] = 11;
if (isset($_SESSION['loginId'])){
// to determine participant or organiser or admin
    $userType = $_SESSION['userType'];
    $userType = 'participant';
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$_SESSION[loginId]' ");
    $userResult = mysqli_fetch_array($userData);

    if ($userType == 'participant'){
        $name = $userResult['name'];
        $dob = $userResult['dob'];
        $phoneNo = $userResult['phoneNo'];
        $pic = $userResult['profilePic'];
        $street = $userResult['street'];
        $city = $userResult['city'];
        $state = $userResult['state'];
        $postcode = $userResult['postCode'];
        $country = $userResult['country'];

    } else if ($userType == 'organiser'){
        $name = $userResult['name'];
        $phoneNo = $userResult['phoneNo'];
        $street = $userResult['street'];
        $city = $userResult['city'];
        $state = $userResult['state'];
        $postcode = $userResult['postCode'];
        $country = $userResult['country']; 
        $pic = $userResult['profilePic'];

    } else{ //admin
        $name = $userResult['name'];
        $dob = $userResult['dob'];
        $phoneNo = $userResult['phoneNo'];
        $pic = $userResult['profilePic'];

    }  
    $profile = "userProfile.php";
}
?>

<!DOCTYPE html>
    <html lang = en>
        <head>
            <title>Fuzifilm | Edit Profile</title>
            <link href = "css/editProfile.css" rel = "stylesheet" type = "text/css">
        </head>
        <body>
            <div class="title">
                EDIT PROFILE
            </div>
            <div class="data">
                <?php //picture havent done
                    if ($userType == 'participant'){
                        echo"
                            <form method = 'POST'>
                                <label for = 'name'>Name: </label>
                                <input type = 'text' name = 'name' value = '$name' id='name' pattern='[A-Za-z ]{1,50}' oninvalid='invalidMessage(\"FnameID\")' required>
                                <br>
                                <label for = 'dob'>Date of Birth: </label>
                                <input type = 'text' name = 'dob' value = '$dob' onfocus='(this.type=\"date\")' onblur='(this.type=\"text\")' required>
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
                                <input type= 'submit' name='submit' value='SUBMIT' class='btn'>
                                <input type= 'submit' value = 'BACK' class='btn' name = 'back'> 
                            </form>";
                    
                    }else if ($userType == 'organiser'){
                        echo "
                            <form method = 'POST'> 
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
                                <input type= 'submit' name='submit' value='SUBMIT' class='btn'>
                                <input type= 'submit' value = 'BACK' class='btn' name = 'back'>
                            </form>";

                    }else if ($userType == 'admin'){
                        echo "
                            <form method = 'POST'> 
                                <label for = 'name'>Name: </label>
                                <input type = 'text' name = 'name' value = '$name' id='name' pattern='[A-Za-z ]{1,50}' oninvalid='invalidMessage(\"FnameID\")' required>
                                <br>
                                <label for = 'dob'>Date of Birth: </label>
                                <input type = 'text' name = 'dob' value = '$dob' onfocus='(this.type=\"date\")' onblur='(this.type=\"text\")' required>
                                <br>
                                <label for = 'phone'>Phone Number: </label>
                                <input type = 'text' name = 'phone' value = '$phoneNo' id='phone' pattern='0.{9,12}' title='phone number invalid' required>
                                <br>
                                <input type= 'submit' name='submit' value='SUBMIT' class='btn'>
                                <input type= 'submit' value = 'BACK' class='btn' name = 'back'>
                            </form>"; 
                    
                    }else{
                        echo '<b>You are not participant or organiser or admin.</b>';
                    }
                ?>
            </div>
        </body>
    </html>
<?php require "footer.php" ?>
<?php
    if (isset($_POST['submit'])){
        if ($userType == 'participant'){
            $sql = "UPDATE participant SET
                            name = '$_POST[name]',
                            dob = '$_POST[dob]',
                            phoneNo = '$_POST[phone]',
                            street = '$_POST[street]',
                            city = '$_POST[city]',
                            state = '$_POST[state]',
                            postCode = '$_POST[postcode]',
                            country = '$_POST[country]'
                    WHERE loginId = '$_SESSION[loginId]'";
        }else if ($userType == 'organiser'){
            $sql = "UPDATE organiser SET
                            name = '$_POST[name]',
                            phoneNo = '$_POST[phone]',
                            street = '$_POST[street]',
                            city = '$_POST[city]',
                            state = '$_POST[state]',
                            postCode = '$_POST[postcode]',
                            country = '$_POST[country]'
                    WHERE loginId = '$_SESSION[loginId]'";
        }else{ //admin
            $sql = "UPDATE admin SET
                            name = '$_POST[name]',
                            dob = '$_POST[dob]',
                            phoneNo = '$_POST[phone]'
                    WHERE loginId = '$_SESSION[loginId]'";
        }
        
        if(!mysqli_query($con, $sql)){
            die('error'.mysqli_error($con));
        }else{
            echo "<script>alert('Data updated');
            window.location.href = 'userProfile.php';
            </script>";
        }
    }
    
    if (isset($_POST['back'])){
        echo "<script>window.location.href = 'userProfile.php';</script>";
    }
?>