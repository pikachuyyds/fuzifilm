
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
    <link rel="stylesheet" href="css\aContestRequest.css">
    <script src="js/aContestRequest.js"></script>
    <title>Contest Creation Request</title>
</head>
<body onload="button1()">

    <!--------------------------------------------- Contest page view|Code reused from aContest.php created by Chan Hong Wei| ---------------------------------------------->
    <!--------------------------------------------- contest part 1 (basic information) ---------------------------------------------->
    <div> 
        <button type="button" class="aContestRequestButton1" id="aContestRequestButton1" onclick="button1()">Contest Page View</button>
        <button type="button" class="aContestRequestButton2" id="aContestRequestButton2" onclick="button2()">Form View</button>
    </div>
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
    <div class="aContest3" id="aContestDiv3">
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
    <!--------------------------------------------- contest part 4 (button) ---------------------------------------------->
    <?php $showBtn=
    '<div class="btnContainer" id="btnContainer" >
        <form method="post" name="rejectOrApprove" >
        <button type="submit" class="btnCss" name="rejectButton">Reject</button><button type="submit" class="btnCss" name="approveButton">Approve</button>
        </form>
    </div>';
    if($_SESSION['userType'] != 'organiser'){
        echo $showBtn;
    }
    ?>
    <!--------------------------------------------- if any button is clicked ---------------------------------------------->
    <?php 
if (isset($_POST['rejectButton'])) {
	$sql="UPDATE contest SET approvalStatus ='rejected' WHERE contestId = '$_GET[id]';";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.href= 'contestRequestSelect.php';
		</script>";
	}
	mysqli_close($con);
}
if (isset($_POST['approveButton'])) {
	$sql="UPDATE contest SET approvalStatus ='approved' WHERE contestId = '$_GET[id]';";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.href= 'contestRequestSelect.php';
		</script>";
	}
	mysqli_close($con);
}
?>

    <!--------------------------------------------- Form view (hidden by default) |Code reused from editContest.php created by Ngan Jun Ming| ---------------------------------------------->
<?php 
    $sql ="SELECT * FROM contest WHERE contestId ='$_GET[id]'";
    $result =mysqli_query($con, $sql);
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_array($result);}
?>
    <form method="post" name="contestInformation" id="contestInformation"  ENCTYPE="multipart/form-data" >
<div class='w-100 d-flex'>
	<div class=' w-100 newContestHeader resizedHeader' style="display:none" id="contestHeader"> Contest Information</div>
</div>
<div class='w-100 d-flex flex-wrap newContestFormContainer' style="display:none"id="contestContainer">
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Type</div>
            <div class='newContestFormField'>
            <select name="contestType" id='contestType'  disabled>
				<option value=""disabled selected>-- Please Select --</option>
				<option <?php if($row['contestType'] == 'Portrait') {?> selected ='selected' <?php } ?> value="Portrait">Portrait</option>
				<option <?php if($row['contestType'] == 'Fashion') {?> selected ='selected' <?php } ?> value="Fashion">Fashion</option>
				<option <?php if($row['contestType'] == 'Sports') {?> selected ='selected' <?php } ?> value="Sports">Sports</option>
				<option <?php if($row['contestType'] == 'Architectural') {?> selected ='selected' <?php } ?> value="Architectural">Architectural</option>
                <option <?php if($row['contestType'] == 'Nature') {?> selected ='selected' <?php } ?> value="Nature">Nature</option>
            </select>
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Name</div>
            <div class='newContestFormField'>
                <input type="text" name="contestName" id="contestName" value="<?php echo $row['contestName'];?>" placeholder="e.g FUZIFLIM" pattern="[^'\x22]+" title="Contest Name. Please do not put quotes" disabled>
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Description</div>
            <div class='newContestFormField'>
                <textarea maxlength ="1000" rows="4" name="contestDescription" id="contestDescription"  placeholder="e.g One of the most common photography styles, portrait photography, or portraiture, aims to capture the personality and mood of an individual or group" pattern="[^'\x22]+" title="Contest Description. Please do not put quotes" disabled><?php echo $row['description'];?></textarea>
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Thumbnail Image</div>
            <div class='newContestFormField'>
				<div  id="divThumbnailPreview"><img class='newImageSize ' id="newThumbnailPreview" src="uploads/<?php echo $row['contestImage'];?>" alt='contest thumbnailimage'></div>
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Date</div>
            <div class='newContestFormField'>
				<label class='contestDateLabel'> Start Date :</label>
				<input type="date" name="startdate" id="startdate" value="<?php echo $row['startDate'];?>" disabled>
				<label class='contestDateLabel'> End Date :</label>
				<input type="date" name="enddate" id="enddate" value="<?php echo $row['endDate'];?>"  disabled>
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' >Payment</div>
            <div class='newContestFormField'>
				<input class="" type="checkbox" name="contestFormPayment" id="contestFormPayment" value="pay"  <?php if($row['price'] != 0) {?> checked <?php } ?> disabled>
  				<label for="contestFormPayment" id="contestFormPayment" class="contestPaymentLabel"> Pay </label>
				  <label for="contestFormPayment" id="contestFormPayment" class="contestPaymentLabel" style="font-size:2vmin;  margin-right:50px;">(if you choose to pay, you may request participant fee from the participants. Else, participants can join your contest for free)</label>
			</div>
	</div>
	<div class='newContestFormSection' id="newContestPrice">
			<div class='newContestFormLabel' >Price for participants (per pax)</div>
            <div class='newContestFormField'>
				<input <?php if($row['price'] > 0) {?> type="number" value="<?php echo $row['price'];?>" <?php }?>   <?php if($row['price'] <= 0) {?> type="text" value="<?php echo 'FREE';?>" <?php }?> name="newContestPriceInput" id="newContestPriceInput" placeholder="e.g. 30 " pattern="{1,2}" title="Please enter less than 100 only" disabled>
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Prize</div>
            <div class='newContestFormField'>
				<input type="text" name="contestPrize1" id="contestPrize1" value="<?php echo $row['championPrize'];?> "placeholder="Champion" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" disabled>
				<input type="text" name="contestPrize2" id="contestPrize2" value="<?php echo $row['firstRunnerUpPrize'];?>" placeholder="First Runner Up" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" disabled>
				<input type="text" name="contestPrize3" id="contestPrize3" value="<?php echo $row['secondRunnerUpPrize'];?>" placeholder="Second Runner Up" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" disabled>
			</div>
	</div>
</div>                               

</body>
</html>

<?php require "footer.php"; ?>