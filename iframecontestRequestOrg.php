<!DOCTYPE html>
<html>
<head>
	<title>Status Of Approval: Contest Creation</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/contestStatusOfApproval.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		::-webkit-scrollbar {
	width: 10px;
	}

	/* Track */
	::-webkit-scrollbar-track {
	box-shadow: inset 0 0 2px #d6ccc9; 
	border-radius: 5px;
	}
	
	/* Handle */
	::-webkit-scrollbar-thumb {
	background: #5B3E38;
	border-radius: 5px;
	}
	</style>
</head>
<body>

<?php
// get organiser information from database
$sql_organiser = "SELECT organiserID FROM organiser WHERE loginId = '$_SESSION[loginId]';";
$sql_organiserQuery = mysqli_query($con,$sql_organiser);
$organiserInfo = mysqli_fetch_array($sql_organiserQuery);

// organiser information
$organiserId = $organiserInfo['organiserID'];

            require "conn.php";
            $sql_allContest = "SELECT contestId, contestName, approvalStatus, startDate FROM contest WHERE organiserID='$organiserId' AND approvalStatus = 'pending';";
            $sql_allContestQuery = mysqli_query($con,$sql_allContest);
            while ($contestInfo = mysqli_fetch_array($sql_allContestQuery)) {
                /* main data */$id = $contestInfo['contestId'];
                /* main data */$name = $contestInfo['contestName'];
                /* main data */$status = $contestInfo['approvalStatus'];
                /* main data*/$sDate = $contestInfo['startDate'];

        ?>
            <a class="linkColor" href="aContestRequest.php?id=<?php echo $id;?>" target="_top">
			<div class='w-100 d-flex statusOfApprovalSelectContainer linkColor' style="overflow-x: hidden;">
			<div >
				<p> Contest ID : <?php echo $id; ?></p> <span class="positionContentDiv"> Status :  <?php echo $status; ?></span>
				<p> Contest Name : <?php echo $name; ?></p>
				<p> Starting Date : <?php echo $sDate; ?> </p>
			</div>
			</div>
			</a>
        <?php } ?>


</body>