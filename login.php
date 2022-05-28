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
    <link rel="stylesheet" href="css\login_iframe.css">
    <link rel="stylesheet" href="css\login.css">
    <script src="js\header.js"></script>
    <title>Login</title>
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
                            <li class="togglerItem"><a href="#About us">About us</a></li><br>
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
        <div class="iframeContainer">
        <!-------------------------------------------------------- login interface -------------------------------------------------------->            
            <div class="loginMain">
                <div class="logo">
                    <img src="images\logo.png" alt="Fuzifilm logo">
                </div>
                <div class="credentialInput">
                    <form method="post">
                        <!--------------------------------------------- input credential --------------------------------------------->
                        <input type="text" placeholder="Email address" name="emailAddress" id="emailAddress" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                        value="<?php if(isset($_COOKIE['cookieemail'])){echo $_COOKIE['cookieemail'];} ?>" required></input><br>
                        <input type="password" placeholder="Password" name="login_pw" id="login_pw" required></input>

                        <!---------------------------------------- remember me & forgot password -------------------------------------->
                        <div class="others">
                            <div>
                                <input type="checkbox" id="rmbMe" name="rmbMe">
                                <label for="rmbMe"> Remember me</label><br>
                            </div>
                            <div><a href="forgotPassword_email.php">Forgot password</a></div>
                        </div>

                        <!----------------------------------------------- buttons -------------------------------------------------->
                        <div class="btn">
                            <input type="submit" class="loginBtn" name="login" value="login">
                            <a href="signUp_participant.php">Sign up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="someHeight"></div>
</body>
</html>

<?php
    if(isset($_POST["login"])){
        $findUserInfo = "SELECT loginId, loginEmail, loginPassword, userType FROM login WHERE loginEmail = '$_POST[emailAddress]';";
        $findUserInfo_query = mysqli_query($con, $findUserInfo);
        $userInfo = mysqli_fetch_array($findUserInfo_query);
        
        if(!empty($userInfo)){
            if($userInfo['loginPassword'] != $_POST['login_pw']){
                echo "<script>alert('invalid password');</script>";
            } else {
                if(isset($_POST["rmbMe"])){
                    setcookie("cookieemail", $userInfo['email'], time() + (86400 * 30), "/");
                }
                $_SESSION['loginId'] = $userInfo['loginId'];
                $_SESSION['userType'] = $userInfo['userType'];
                echo "<script>window.location.href = 'home.php';</script>";
            }
        } else {
            echo "<script>alert('invalid email or password');</script>";
        }
    }
?>
