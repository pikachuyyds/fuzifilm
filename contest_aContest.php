<?php
    require "header.php";
    require "conn.php";
    $contestId = $_GET['id'];


    // get contest information from database
    $sql_contest = "SELECT * FROM contest WHERE contestId = '$contestId';";
    $sql_contestQuery = mysqli_query($con,$sql_contest);
    $contestInfo = mysqli_fetch_array($sql_contestQuery);

    // contest information
    $Name = $contestInfo['contestName'];
    $image = $contestInfo['contestImage'];
    $description = $contestInfo['description'];
    $startDate = $contestInfo['startDate'];
    $endDate = $contestInfo['endDate'];
    $type = $contestInfo['contestType'];

    // paid or free
    $paidOrFree = $contestInfo['paidOrFree'];

    if ($paidOrFree == "free")
    {
        $price = "free";
    } 
    else if ($paidOrFree == "paid")
    {
        $price = $contestInfo['price'];
    }

    // if theres organiser prize
    if ($contestInfo['championPrize'] != "")
    {
        $championPrize = $contestInfo['championPrize'];
        $firstRunnerUpPrize = $contestInfo['firstRunnerUpPrize'];
        $secondRunnerUpPrize = $contestInfo['secondRunnerUpPrize'];
    }

    $organiserID = $contestInfo['organiserID'];
    $sql_organiser = "SELECT organiserID, name FROM organiser WHERE organiserID = '$organiserID';";
    $sql_organiserQuery = mysqli_query($con,$sql_organiser);
    $organiserInfo = mysqli_fetch_array($sql_organiserQuery);
    $organiserName = $organiserInfo['name'];

    // to get the status that shows on every contest's image (either due join date, judging, announced)
    $now = time()-(60*60*24);
    $announcement = date('Y/m/d', strtotime($endDate . ' +14 day')); 

    if ($now >= strtotime($announcement))
    {
        $status = "announced";
    }
    else if($now > strtotime($endDate))
    {
        $status = "judging";  
    }
    else
    {
        if ($now >= strtotime($startDate)) 
        {
            $status = "opening";
        }
        else
        {
            $status = "opening soon";
        }
    }

    // free or paid status
    if ($paidOrFree == "free")
    {
        $requiredPrice = "free";
    }
    else if ($paidOrFree == "paid") 
    {
        $requiredPrice = "RM ".$price;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\aContest.css">
    <title>Contest</title>
</head>
<body>

    <!--------------------------------------------- contest part 1 (basic information) ---------------------------------------------->
    
    <div class="aContest1">
        <!-- 1st part (contest type and status) -->
        <div class="typeNStatus">
            <div class="contestType">
                <?php echo $type ?>
            </div>
            <div class="contestStatus"><?php echo $status ?></div>
        </div>

        <!-- 2nd part (contest image) -->
        <div class="contestImg">
            <img src="<?php echo $image ?>" alt="contest img">
            <!-- images\loginBg.jpeg -->
        </div>

        <!-- 3rd part (contest information) -->
        <div class="contestInfo">
            <div class="organiser"><a href="#organiserProfile">by <?php echo $organiserName; ?></a></div>
            <div class="contestName"><?php echo $Name ?></div>
            <div class="contestDscrpt"><?php echo $description ?></div>
        </div>
    </div>

    <!--------------------------------------------- contest part 2 (price) ---------------------------------------------->
    
    <div class="aContest2">

        <div class="circle">

            <div class="rewardTitle">Reward</div>

            <div class="rewardRow">
                <div class="reward">
                    <div class="number">1</div>
                    <div class="allReward">
                        <div class="rewardType">Leaderboard point</div>
                        <div class="reward">200pt</div>
                        <div class="rewardType">Reward point</div>
                        <div class="reward">200pt</div>

                        <?php     
                            if ($contestInfo['championPrize'] != "")
                            { ?>
                                <div class="rewardType">Organiser reward</div>
                                <div class="reward"><?php echo $championPrize ?></div>
                        <?php } ?>
                        
                    </div>
                </div>

                <div class="reward">
                    <div class="number">2</div>
                    <div class="allReward">
                        <div class="rewardType">Leaderboard point</div>
                        <div class="reward">200pt</div>
                        <div class="rewardType">Reward point</div>
                        <div class="reward">200pt</div>
                        <?php     
                            if ($contestInfo['firstRunnerUpPrize'] != "")
                            { ?>
                                <div class="rewardType">Organiser reward</div>
                                <div class="reward"><?php echo $firstRunnerUpPrize ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="rewardRow">

                <div class="reward">
                    <div class="number">3</div>
                    <div class="allReward">
                        <div class="rewardType">Leaderboard point</div>
                        <div class="reward">200pt</div>
                        <div class="rewardType">Reward Point</div>
                        <div class="reward">200pt</div>
                        <?php     
                            if ($contestInfo['secondRunnerUpPrize'] != "")
                            { ?>
                                <div class="rewardType">Organiser reward</div>
                                <div class="reward"><?php echo $secondRunnerUpPrize ?></div>
                        <?php } ?>
                    </div>
                </div>

                <div class="reward">
                    <div class="number">All</div>
                    <div class="allReward">
                        <div class="rewardType">Leaderboard Point</div>
                        <div class="reward">200pt</div>
                        <div class="rewardType">Reward Point</div>
                        <div class="reward">200pt</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------------- contest part 3 (timeline) ---------------------------------------------->
    
    <div class="aContest3">
        <div class="timelineTitle">Timeline</div>
        <div class="timeline">
            <div class="line"></div>
            <div class="allStatus">
                <div class="aStatus">
                    <div class="circleContainer"><div class="statusCircle"></div></div>
                    <div class="status">
                        <div class="statusName">Start</div>
                        <div class="statusDate"><?php echo $startDate ?></div>
                    </div>
                </div>
                <div class="aStatus">
                    <div class="circleContainer"><div class="statusCircle"></div></div>
                    <div class="status">
                        <div class="statusName">Entries</div>
                        <div class="statusDate">due <?php echo $endDate ?></div>
                    </div>
                </div>
                <div class="aStatus">
                    <div class="circleContainer"><div class="statusCircle"></div></div>
                    <div class="status">
                        <div class="statusName">Judging</div>
                        <div class="statusDate">2 weeks</div>
                    </div>
                </div>
                <div class="aStatus">
                    <div class="circleContainer"><div class="statusCircle"></div></div>
                    <div class="status">
                        <div class="statusName">Announcement</div>
                        <div class="statusDate"><?php echo $announcement ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--------------------------------------------- contest part 4 (button before judging) ---------------------------------------------->
    
    <?php
        if ($status == "opening") {
    ?>
        <div class="btnContainer">
            <div class="price"><?php echo $requiredPrice ?></div>

            <!-- Join contest validation -->
            <!-- 
                if it's GUEST
                    no button

                if it's PARTICIPANT, check if the participant has joined or not
                    if participant joined, button disabled
                    if participant doesnt join, button enable 
            -->
            <?php
                if ($user == "guest")
                {
                    echo "\"Sign in as a participant to join the contest\"";
                }
                else if ($user == "participant")
                {
                    $loginId = $_SESSION['loginId'];
                    
                    // get participant id by using login id
                    $sql_participantInfo = "SELECT participantId FROM participant WHERE loginId = '$loginId';";
                    $participantInfo = mysqli_fetch_array(mysqli_query($con,$sql_participantInfo));
                    $participantId = $participantInfo['participantId'];

                    // check if the participant has joined the contest or not
                    $sql_participantlistInfo = "SELECT participantListId FROM participantlist WHERE participantId = '$participantId' AND contestId = '$contestId';";
                    $participantlistInfo = mysqli_fetch_array(mysqli_query($con,$sql_participantlistInfo));

                    if ($participantlistInfo == "") 
                    {
                        echo "<a href='contest_join.php?id=" . $contestId . "'><button type='button'>Join</button></a>";
                    }
                    else if ($participantlistInfo != "")
                    {
                        echo "<button type='button' style='background-color: #c2c2c2;'>Joined</button>";
                    }
                }
            ?>
        </div>

    <?php
        } else if ($status = "announced") {
    ?>

    <!--------------------------------------------- contest part 4 (announced) ---------------------------------------------->
    <!-- display winner iframe -->
        

    <?php
        }
    ?>

</body>
</html>

<?php
    require "footer.php";
?>