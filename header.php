<?php
    session_start();
    date_default_timezone_set("Asia/Kuala_Lumpur");
    if (isset($_SESSION['userType']))
    {
        // 
        $user = $_SESSION['userType'];
    }
    else
    {
        $user = "guest";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images\favicon.ico">
    <link rel="stylesheet" href="css\header.css">
    <script src="js\header.js"></script>
</head>
<body>
    <!-------------------------------------------------------- header -------------------------------------------------------->
    <div class="naviBar_main" id="header">
        <div class="naviBar_sub1">
            <a href="home.php"><img class="logo_header naviBar_sub1_item" src="images\logo.png" alt="logo"></a>
            <?php
            // guess & participant
            if ($user=="guest"||$user=="participant") {?>
            <a class="naviBar_sub1_item " href="home.php">home</a>
            <a class="naviBar_sub1_item" href="contest_allContest.php">contest</a>
            <a class="naviBar_sub1_item" href="leaderboard.php">leaderboard</a>
            <?php }

            // organiser
            else if ($user=="organiser") { ?>
            <a class="naviBar_sub1_item " href="home.php">home</a>
            <a class="naviBar_sub1_item" href="allContest.php">contest</a> <!-- dropdown button (view all responsible contest, contest request (create & modify), create new contest) -->
            <a class="naviBar_sub1_item" href="leaderboard.php">leaderboard</a>
            <?php }

            //  admin
            else if ($user=="admin") { ?>
            <a class="naviBar_sub1_item " href="home.php">home</a>
            <a class="naviBar_sub1_item" href="allContest.php">contest</a> <!-- dropdown button(view all contest, conteset request) -->
            <a class="naviBar_sub1_item" href="#profile">profile</a> <!-- guess, organiser account -->
            <?php } ?>

        </div>
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
                <?php

                // guest
                if ($user=="guest") {?>
                <div style="display: flex; justify-content: space-between;">
                    <ul>
                        <li class="togglerItem"><a href="home.php">home</a></li><br>
                        <li class="togglerItem"><a href="#Aboutus">About us</a></li><br>
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
                <?php }

                // participant
                else if ($user=="participant") { ?>
                    <div style="display: flex; justify-content: space-between;">
                        <ul>
                            <li class="togglerItem"><a href="home.php">home</a></li><br>
                            <li class="togglerItem"><a href="#About us">About us</a></li><br>
                            <li class="togglerItem"><a href="contest_allContest.php">Contest</a></li><br>
                            <li class="togglerItem"><a href="leaderboard.php">Leaderboard</a></li><br>
                            <li class="togglerItem"><a href="reward_all.php">Reward</a></li>
                        </ul>
                    </div>
                
                    <div class="profileNSetting">
                        <ul>
                            <li> <p class="togglerItemTitle">Profile</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="userProfile.php">personal information</a></li>
                                    <li class="togglerItem"><a href="participantPortfolio.php">portfolio</a></li>
                                    <li class="togglerItem"><a href="contest_participantJoinHistory.php">contest history</a></li>
                                    <li class="togglerItem"><a href="reward_viewReport.php">redeem reward history</a></li>
                                </ul>
                            </li>
                        </ul>
                        <br><br>
                        <ul>
                            <li> <p class="togglerItemTitle">Setting</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="editProfile.php">edit profile</a></li>
                                    <li class="togglerItem"><a href="changePwd.php">change password</a></li>
                                    <li class="togglerItem"><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php }

                // organiser
                else if ($user=="organiser") { ?>
                    <div class="profileNSetting">
                        <ul>
                            <li><a href="home.php" class="togglerItemTitle" style="color:#5B3E38;">home</a></li>
                        </ul>
                        <br><br>
                        <ul>
                            <li><a href="#aboutus" class="togglerItemTitle" style="color:#5B3E38;">about us</a></li>
                        </ul>
                        <br><br>
                        <ul>
                            <li> <p class="togglerItemTitle">Contest</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="#">all contest</a></li>
                                    <li class="togglerItem"><a href="#">create contest</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                
                    <div class="profileNSetting">
                        <ul>
                            <li> <p class="togglerItemTitle">Profile</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="userProfile.php">personal information</a></li>
                                    <li class="togglerItem"><a href="organiserContest.php">contest history</a></li>
                                    <li class="togglerItem"><a href="organiserReport.php">reports</a></li>
                                </ul>
                            </li>
                        </ul>
                        <br>
                        <ul>
                            <li> <p class="togglerItemTitle">Setting</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="editProfile.php">edit profile</a></li>
                                    <li class="togglerItem"><a href="changePwd.php">change password</a></li>
                                    <li class="togglerItem"><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php }

                //  admin
                else if ($user=="admin") { ?>
                    <div class="profileNSetting">
                        <ul>
                            <li><a href="home.php" class="togglerItemTitle" style="color:#5B3E38;">home</a></li>
                        </ul>
                        <br><br>
                        <ul>
                            <li> <p class="togglerItemTitle">Contest</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="#">all contests</a></li>
                                    <li class="togglerItem"><a href="#">request</a></li>
                                </ul>
                            </li>
                        </ul>
                        <br>
                        <ul>
                            <li> <p class="togglerItemTitle">User</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="adminViewParticipant.php">participant</a></li>
                                    <li class="togglerItem"><a href="adminViewOrganiser.php">organiser</a></li>
                                </ul>
                            </li>
                        </ul>
                        <br>
                        <ul>
                            <li> <p class="togglerItemTitle">Reward</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="reward_all.php">all rewards</a></li>
                                    <li class="togglerItem"><a href="reward_add.php">add new reward</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                
                    <div class="profileNSetting">
                        <ul>
                            <li> <p class="togglerItemTitle">Profile</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="userProfile.php">personal information</a></li>
                                    <li class="togglerItem"><a href="adminReport.php">report</a></li>
                                </ul>
                            </li>
                        </ul>
                        <br>
                        <ul>
                            <li> <p class="togglerItemTitle">Setting</p> 
                                <ul style="list-style-type:none;">
                                    <li class="togglerItem"><a href="editProfile.php">edit profile</a></li>
                                    <li class="togglerItem"><a href="changePwd.php">change password</a></li>
                                    <li class="togglerItem"><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

            </div>       
        </div>
        <div class="closeToggler" onclick="off()">
            <img class="logo_toggler" src="images\x.png" alt="cancel">
        </div>
    </div>
    
</body>
</html>