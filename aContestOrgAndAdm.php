
<?php
    require "conn.php";
    require "header.php";
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
    $contestApprovalStatus = $contestInfo['approvalStatus'];

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

    // send Leaderboardpoint and reward point to participant once $status is in announced phase
    if($status=='announced' and $contestApprovalStatus=='approved'){
        $i=1;
        
        $sql_allParticipant = "SELECT * FROM participantlist WHERE contestId ='$contestId' AND qualificationStatus='qualified' ORDER BY score DESC;";
        $sql_allContestQuery = mysqli_query($con,$sql_allParticipant);
        while ($contestInfo = mysqli_fetch_array($sql_allContestQuery)) {
            /* main data */$participantId = $contestInfo['participantId'];
            $sql ="SELECT leaderboardPoint,rewardRedemptionPoint FROM participant WHERE participantId ='$participantId'";
            $result =mysqli_query($con, $sql);
            if (mysqli_num_rows($result)) {$row = mysqli_fetch_array($result);}
            /* main data */$leaderboardPoint = $row['leaderboardPoint'];
            /* main data */$rewardRedemptionPoint = $row['rewardRedemptionPoint'];
            if($i==1){
                $leaderboardPoint = $leaderboardPoint +200;
                $rewardRedemptionPoint = $rewardRedemptionPoint+200;
                $sql="UPDATE participant SET leaderboardPoint = '$leaderboardPoint', rewardRedemptionPoint = '$rewardRedemptionPoint' WHERE participantId ='$participantId' ;";
                if (!mysqli_query($con,$sql)){
                        die('Error: ' . mysqli_error($con));
                    }
            }elseif($i==2){
                $leaderboardPoint = $leaderboardPoint +150;
                $rewardRedemptionPoint = $rewardRedemptionPoint+150;
                $sql="UPDATE participant SET leaderboardPoint = '$leaderboardPoint', rewardRedemptionPoint = '$rewardRedemptionPoint' WHERE participantId ='$participantId' ;";
                if (!mysqli_query($con,$sql)){
                        die('Error: ' . mysqli_error($con));
                    }
            }elseif($i==3){
                $leaderboardPoint = $leaderboardPoint +100;
                $rewardRedemptionPoint = $rewardRedemptionPoint+100;
                $sql="UPDATE participant SET leaderboardPoint = '$leaderboardPoint', rewardRedemptionPoint = '$rewardRedemptionPoint' WHERE participantId ='$participantId' ;";
                if (!mysqli_query($con,$sql)){
                        die('Error: ' . mysqli_error($con));
                    }
            }else{
                $leaderboardPoint = $leaderboardPoint +10;
                $rewardRedemptionPoint = $rewardRedemptionPoint+20;
                $sql="UPDATE participant SET leaderboardPoint = '$leaderboardPoint', rewardRedemptionPoint = '$rewardRedemptionPoint' WHERE participantId ='$participantId' ;";
                if (!mysqli_query($con,$sql)){
                        die('Error: ' . mysqli_error($con));
                    }
            }
            $i++;
        }

        // update contestApprovalStatus to past so it wont give participant points repeatedly
        $sql="UPDATE contest SET approvalStatus = 'past' WHERE contestId ='$contestId' ;";
        if (!mysqli_query($con,$sql)){
                die('Error: ' . mysqli_error($con));
            }}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\aContestRequest.css">
    <script src="js/aContestRequest.js"></script>
    <title>Contest Page</title>
</head>
<body >
    <!--------------------------------------------- contest part 1 (basic information) ---------------------------------------------->
    <div class="aContest1" id="aContestDiv1">
        <!-- 1st part (contest type and status) -->
        <div class="typeNStatus">
            <div class="contestType">
                <?php echo $type ?>
            </div>
            <div class="contestStatus"><?php echo $status ?></div>
        </div>

        <!-- 2nd part (contest image) -->
        <div class="contestImg">
            <img src="uploads/<?php echo $image ?>" alt="contest img">
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
    <div class="aContest2" id="aContestDiv2">

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
    <div class="aContest3" id="aContestDiv3" style="display:inline;">
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
    <!--------------------------------------------- contest part 4 (iframe:participant list, marking) ---------------------------------------------->
    <!------------------ DIFFERENT IFRAME IF CONTEST IS IN ANNOUNCED PHASE / OVER JUDGING PHASE-------------->
    </div class="iframeDiv">
        <iframe class="iframeContainer" id="aContestIframe" src="iframeAContestParticipantList.php?id=<?php echo $_GET['id'];?>"  frameBorder="0" title="Click to view more information"></iframe>
    </div>
    <?php
        if($status=="announced"){
            echo "<script> document.getElementById('aContestIframe').src ='iframeAContestWinnerList.php?id=$_GET[id]';</script>";
        }
    ?>
    <!--------------------------------------------- contest part 5 (button) ---------------------------------------------->
    <br>
    <div class="btnContainer" id="BtnOrganiser">
        <button type="button" onclick="document.location='<?php echo 'requestModification.php?id='.$contestId.'' ?>'">Request To Edit Contest</button>
    </div>
    <div class="btnContainer" id="BtnAdmin" >
        
    <form method="post" name="deleteBtn"  ENCTYPE="multipart/form-data" >
        <button type="button" class="btnCss" onclick="document.location='<?php echo 'editContest.php?id='.$contestId.'' ?>'">Edit Contest</button><button type="submit" class="btnCss" name="deleteContest">Delete Contest</button>
    </form>
    </div>
    <?php if($_SESSION['userType']=='organiser'){echo'<script>(document.getElementById("BtnAdmin")).style.display = "none";</script>';}elseif($_SESSION['userType']=='admin'){echo'<script>(document.getElementById("BtnOrganiser")).style.display = "none";</script>';}?>


</body>
<?php
if (isset($_POST['deleteContest'])) {
	$sql="UPDATE contest SET approvalStatus = 'deleted' WHERE contestId ='$_GET[id]' ;";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
        echo "<script>
		window.location.href= 'allContestOrgAndAdm.php';
		</script>";
	}
	mysqli_close($con);
}
?>


</html>

<?php require "footer.php"; ?>