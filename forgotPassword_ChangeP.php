<?php 
    require "conn.php";

    if (!isset($_GET['loginId']))
    {
        die("page unavailable");
    }

    $loginId = $_GET['loginId'];

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
                            <li class="togglerItem"><a href="contest_allContest.php">Contest</a></li><br>
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
    
    <!-------------------------------------------------------- enter email interface -------------------------------------------------------->            
    <div class="signUpMain">
        <div class="form">
        <div class="title">Forgot Password</div><br>
        <div style="width: 80%; font-size: 12px"> Please enter your new password</div><br><br>
        <form method="post">

            <label for="passw">New password </label><span id="passdwordError1" style="display: none; color: red;"> *password should not contain '</span><br>
            <input type="password" placeholder="minimum 8 character" name="passw" id="passw" pattern=".{8,}" title="at least 8 characters" onkeyup="" required></input><br>

            <label for="confirmPw">Confirm password </label><span id="passdwordError2" style="color: red;display:none;"> *confirm password does not same with password</span><br>
            <input type="password" placeholder="Confirm password" name="confirmPw" id="confirmPw" title="at least 8 characters" required></input><br>    

            <input type="submit" name="submit" value="submit">

        </form>
        </div>
    </div>
    <div class="someHeight"></div>
</body>
</html>

<?php
    if(isset($_POST['submit']))
    {
         // clearing previous error message
        echo "<script>document.getElementById('passdwordError1').style.display = 'none';</script>";
        echo "<script>document.getElementById('passdwordError2').style.display = 'none';</script>";


        // password confirmation (make sure the password and confirm password are identical)
        $passw =  htmlspecialchars($_POST['passw']);
        $conPassw =  htmlspecialchars($_POST['confirmPw']);

        if($passw != $conPassw)
        {
            echo "<script>document.getElementById('passdwordError2').style.display = 'inline-block';</script>";
        } 
        else if ($passw == $conPassw)
        {
            $PWvldt = str_replace("'","",$passw);
            if ($PWvldt === $passw) 
            {
                $sql_updatePassword = "UPDATE login SET loginPassword = '$passw' WHERE loginId = '$loginId';";
                if (!mysqli_query($con, $sql_updatePassword))
                {
                    die("password change unsuccessfully");
                }
                else
                {
                    echo "<script>
                    alert('Successfully change password');
                    window.location.href = 'login.php';
                    </script>";
                }
            } 
            else 
            {
                echo "<script>document.getElementById('passdwordError1').style.display = 'inline-block';</script>";
            }
        }

        mysqli_close($con);
    }
?>