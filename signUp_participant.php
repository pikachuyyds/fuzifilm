<?php 
    require "conn.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images\favicon.ico">
    <link rel="stylesheet" href="css\login_signUp.css">
    <link rel="stylesheet" href="css\login.css">
    <script src="js\header.js"></script>
    <title>sign up</title>
</head>
<body>
        <!-------------------------------------------------------- header -------------------------------------------------------->
        <div class="naviBar_main" id="header">
            </a><div class="toggler_container" onclick="on()">
                <div class="toggler"></div>
                <div class="toggler"></div>
                <div class="toggler"></div>
            </div>
        </div>

    <!-------------------------------------------------------- toggler -------------------------------------------------------->
        <div id="theToggler" style="display: none;">
            <div class="mainToggler">
                <div class="subToggler1">
                    <div style="display: flex; justify-content: space-between;">
                        <ul>
                            <li class="togglerItem"><a href="home.php">home</a></li><br>
                            <li class="togglerItem"><a href="About us">About us</a></li><br>
                            <li class="togglerItem"><a href="allContest.php">Contest</a></li><br>
                            <li class="togglerItem"><a href="leaderboard.php">Leaderboard</a></li><br>
                            <li class="togglerItem"><a href="reward_all.php">Reward</a></li>
                        </ul>
                    </div>
                
                    <div class="profileNSetting">
                        <ul>
                            <li> <p class="togglerItemTitle">Setting</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="login.php">login</a></li>
                                    <li class="togglerItem"><a href="signUp_participant.php">sign up</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>       
            </div>
            <div class="subToggler2">
                <img class="logo_toggler" src="images\logo.png" alt="logo">
                <p>@2022 by group 15</p>
            </div>
            <div class="closeToggler" onclick="off()"      >
                <img class="logo_toggler" src="images\x.png" alt="cancel">
            </div>
        </div>

        <!-------------------------------------------------------- sign up interface -------------------------------------------------------->            
        <div class="signUpMain">
            <div class="form">
            <div class="title">Participant registration</div><br>
            <a href="signUp_organiser.php" style="width: 80%; font-size: 12px">sign up for organiser</a><br><br>
            <form method="post">
                <label for="name">Name</label><br>
                <input type="text" placeholder="maximum 50 character" name="name" id="name" pattern="[A-Za-z ]{1,50}" oninvalid="invalidMessage('FnameID')" required></input><br>
                <!-- oninvalid to display error message -->

                <label for="dob">Date of Birth</label><br>
                <input type="text" placeholder="select" name="dob" onfocus="(this.type='date')" onblur="(this.type='text')" required></input><br>

                <label for="phoneNo">Phone number</label><br>
                <input type="tel" placeholder="01234567891" name="phoneNo" id="phoneNo" pattern="0.{9,12}" title="phone number invalid" required></input><br>

                <br>

                <label for="address">Address line</label><br>
                <input type="text" placeholder="select" name="address" id="address" required></input><br>

                <label for="city">City</label><br>
                <input type="text" placeholder="select" name="city" id="city" required></input><br>

                <label for="state">State</label><br>
                <input type="text" placeholder="state" name="state" id="state" required></input><br>

                <label for="postcode">Postcode</label><br>
                <input type="number" placeholder="select" name="postcode" id="postcode" required></input><br>

                <label for="country">Country</label><br>
                <input type="text" placeholder="Malaysia" name="country" id="country" required></input><br><br>
                
                <br>
                
                <label for="email">Email address </label><span id="emailError" style="color: red;display:none;"> *email used</span><br>
                <input type="email" placeholder="email@mail.com" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" oninvalid="" required></input><br>
                <!-- oninvalid to show error message -->
                
                <label for="passw">Password </label><span id="passdwordError1" style="display: none; color: red;"> *password should not contain '</span><br>
                <input type="password" placeholder="minimum 8 character" name="passw" id="passw" pattern=".{8,}" title="at least 8 characters" onkeyup="" required></input><br>
                <!-- oninvalid to show error message -->

                <label for="confirmPw">Confirm password </label><span id="passdwordError2" style="color: red;display:none;"> *confirm password does not same with password</span><br>
                <input type="password" placeholder="Confirm password" name="confirmPw" id="confirmPw" title="at least 8 characters" required></input><br>    
                <!-- oninvalid to show error message -->
                
                <input type="submit" name="submit" value="Register">
            </form>
            </div>
        </div>
        <div class="someHeight"></div>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        // clearing previous error message
        echo "<script>document.getElementById('emailError').style.display = 'none';</script>";
        echo "<script>document.getElementById('passdwordError1').style.display = 'none';</script>";
        echo "<script>document.getElementById('passdwordError2').style.display = 'none';</script>";

        // email validation (make sure there is no redundant used email)
        $Emailvalidation = true;
        $sqlEmail = mysqli_query($con, "SELECT loginEmail FROM login;");
        while($usedEmail = mysqli_fetch_array($sqlEmail)){
            if ($usedEmail['loginEmail'] == $_POST['email']){
                echo "<script>document.getElementById('emailError').style.display = 'inline-block';</script>";
                $Emailvalidation = false;
                break;
            }
        }

        // password confirmation (make sure the password and confirm password are identical)
        $passw =  htmlspecialchars($_POST['passw']);
        $conPassw =  htmlspecialchars($_POST['confirmPw']);
        $confirmPwValidation = false;

        if($passw != $conPassw){
            echo "<script>document.getElementById('passdwordError2').style.display = 'inline-block';</script>";
        } else if ($passw == $conPassw){
            $PWvldt = str_replace("'","",$passw);
            if ($PWvldt === $passw) {
                $confirmPwValidation = true;
            } else {
                echo "<script>document.getElementById('passdwordError1').style.display = 'inline-block';</script>";
            }
        }




        if (($confirmPwValidation === true) && ($Emailvalidation === true)) {
            $sqlAppend1 = "INSERT INTO login (loginEmail, loginPassword, userType) VALUES ('$_POST[email]', '$passw', 'participant');";

            if(!mysqli_query($con, $sqlAppend1)){
                die('error'.mysqli_error($con));
            }else{
                $sql_forID = "SELECT loginId FROM login WHERE loginEmail = '$_POST[email]';";
                $sql_forIDQuery = mysqli_query($con, $sql_forID);
                $userID = mysqli_fetch_array($sql_forIDQuery);
                $joinDate = date('Y.m.d');

                $sqlAppend2 = "INSERT INTO participant (name, dob, phoneNo, joinDate, street, city, state, postCode, country, loginId) 
                VALUES ('$_POST[name]', '$_POST[dob]', '$_POST[phoneNo]', '$joinDate','$_POST[address]', '$_POST[city]', '$_POST[state]','$_POST[postcode]','$_POST[country]', '$userID[loginId]');";

                if(!mysqli_query($con, $sqlAppend2)){
                    echo "<script>alert(' up');</script>";
                    echo $sqlAppend2;
                    die('error'.mysqli_error($con));
                }else {
                $_SESSION['userType'] = "participant";
                $_SESSION["loginId"] = $userID['loginId'];

                echo "<script>alert('Successfully Signed up');
                window.location.href = 'signUp_secretPassword.php';
                </script>";
                }
            }
        }
        mysqli_close($con);
    }
?>