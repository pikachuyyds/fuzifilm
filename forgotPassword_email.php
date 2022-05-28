<?php 
    require "conn.php";
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
    
    <!-------------------------------------------------------- enter email interface -------------------------------------------------------->            
    <div class="signUpMain">
        <div class="form">
        <div class="title">Forgot Password</div><br>
        <div style="width: 80%; font-size: 12px"> Please enter your email address</div><br><br>
        <form method="post">

            <label for="email">Email address <span id="emailError" style="color: red; display:none;" > * email does not exist</span></label><br>
            <input type="text" placeholder="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required></input>

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
        echo "<script>document.getElementById('emailError').style.display = 'none';</script>";

        $input_email = $_POST['email'];
        $sql_searchEmail = "SELECT loginId FROM login WHERE loginEmail = '$input_email';";
        $searchEmail = mysqli_fetch_array(mysqli_query($con, $sql_searchEmail));

        if (empty($searchEmail)) 
        {
            echo "<script>document.getElementById('emailError').style.display = 'inline-block';</script>";
        } 
        else
        {
            $loginId = $searchEmail['loginId'];
            echo "<script>
            window.location.href = 'forgotPassword_secretP.php?loginId=" . $loginId . "';
            </script>";
        }
        
        mysqli_close($con);
    }
?>