<?php
require "conn.php";
require "header.php";

if (isset($_SESSION['loginId'])){
// to determine participant or organiser or admin
    $userType = $_SESSION['userType'];
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
                        echo "
                            <form method = 'POST'>
                                <label for = 'name'>Name: </label>
                                <input type = 'text' name = 'name' value = '$name'>
                                <br>
                                <label for = 'dob'>Date of Birth: </label>
                                <input type = 'date' name = 'dob' value = '$dob'>
                                <br>
                                <label for = 'phone'>Phone Number: </label>
                                <input type = 'text' name = 'phone' value = '$phoneNo'>
                                <br>
                                <label for = 'street'>Street: </label>
                                <textarea name = 'street'>$street</textarea>
                                <br>
                                <label for = 'city'>City: </label>
                                <input type = 'text' name = 'city' value = '$city'>
                                <br>
                                <label for = 'state'>State: </label>
                                <input type = 'text' name = 'state' value = '$state'>
                                <br>
                                <label for = 'postcode'>Postcode: </label>
                                <input type = 'number' name = 'postcode' value = '$postcode'>
                                <br>
                                <label for = 'country'>Country: </label>
                                <input type = 'text' name = 'country' value = '$country'>
                                <br>
                                <input type= 'submit' name='submit' value='SUBMIT' class='btn'>
                                <input type= 'submit' value = 'BACK' class='btn' onclick= 'window.location.href = \'userProfile.php' '> //error
                            </form>";
                    
                    }else if ($userType == 'organiser'){
                        echo "
                            <form method = 'POST'> 
                                <label for = 'name'>Name: </label>
                                <input type = 'text' name = 'name' value = '$name'>
                                <br>
                                <label for = 'phone'>Phone Number: </label>
                                <input type = 'text' name = 'phone' value = '$phoneNo'>
                                <br>
                                <label for = 'street'>Street: </label>
                                <textarea name = 'street'>$street</textarea>
                                <br>
                                <label for = 'city'>City: </label>
                                <input type = 'text' name = 'city' value = '$city'>
                                <br>
                                <label for = 'state'>State: </label>
                                <input type = 'text' name = 'state' value = '$state'>
                                <br>
                                <label for = 'postcode'>Postcode: </label>
                                <input type = 'number' name = 'postcode' value = '$postcode'>
                                <br>
                                <label for = 'country'>Country: </label>
                                <input type = 'text' name = 'country' value = '$country'>
                                <br>
                            </form>";

                    }else if ($userType == 'admin'){
                        echo "
                            <form method = 'POST'> 
                                <label for = 'name'>Name: </label>
                                <input type = 'text' name = 'name' value = '$name'>  
                                <br>
                                <label for = 'dob'>Date of Birth: </label>
                                <input type = 'date' name = 'dob' value = '$dob'>
                                <br>
                                <label for = 'phone'>Phone Number: </label>
                                <input type = 'text' name = 'phone' value = '$phoneNo'>
                                <br>
                            </form>"; 
                    
                    }else{
                        echo '<b>You are not participant or organiser or admin.</b>';
                    }
                ?>
            </div>
            <?php require "footer.php" ?>
        </body>
    </html>

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
?>