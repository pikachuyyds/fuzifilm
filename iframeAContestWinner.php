<!DOCTYPE html>
<html>
<head>
	<title>Participant List</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/contestStatusOfApproval.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/iframeAContestMarking.js"></script>
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
    require "conn.php";
    $sql ="SELECT photo,score FROM participantlist WHERE participantId ='$_GET[participantId]' AND contestId ='$_GET[contestId]'";
    $result =mysqli_query($con, $sql);
    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_array($result);}
    /* main data */$participantPhoto = $row['photo'];
    /* main data */$participantScore = strval($row['score']);
?>

<div class="d-flex justify-content-start"> <button class='backbutton' onclick="window.location.href='iframeAContestWinnerList.php?id=<?php echo $_GET['contestId'];?>'">Back</button></div>
<div class="w-100">
    <img class="iframeimg" src="uploads/<?php echo $participantPhoto;?>" alt="Italian Trulli">
</div>
    <div class="d-flex justify-content-center pt-4" >
       <p class="scoreCss"> Score : <?php echo $participantScore;?></p>
    </div>

</body>


