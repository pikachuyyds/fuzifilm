<!DOCTYPE html>
<html>
<head>
	<title>Participant List</title>
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
<h1> Participant List</h1>
<?php
			session_start();
            require "conn.php";
            $sql_allContest = "SELECT participantId, joinDate, score FROM participantlist WHERE contestId = '$_GET[id]' AND qualificationStatus='qualified';";
            $sql_allContestQuery = mysqli_query($con,$sql_allContest);
            while ($contestInfo = mysqli_fetch_array($sql_allContestQuery)) {
                /* main data */$participantId = $contestInfo['participantId'];
                /* main data */$joinDate = $contestInfo['joinDate'];
                /* main data */$score = $contestInfo['score'];
                if($score!=0){
                    $status="MARKED";
                }else{$status="NOT MARKED***";}
                $sql ="SELECT name FROM participant WHERE participantId ='$participantId'";
                $result =mysqli_query($con, $sql);
                if (mysqli_num_rows($result)) {
                    $row = mysqli_fetch_array($result);}
                /* main data */$participantName = $row['name'];


        ?>
			<a class="linkColor" href="iframeAContestMarking.php?contestId=<?php echo $_GET['id'];?>&participantId=<?php echo $participantId;?>" >
			<div class='w-100 d-flex statusOfApprovalSelectContainer linkColor' style="overflow-x: hidden;">
			<div >
                <br>
                <span class="positionContentDiv"> <?php echo $status; ?></span>
				<p style="font-weight:bold; display:block;"> Participant Name : <?php echo $participantName ?> </p> 
                <p style="font-weight:bold; display:block;"> Participated Date : <?php echo $joinDate ?></p>
			</div>
			</div>
			</a>
        <?php } ?>


</body>