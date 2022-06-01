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
    <script>
        $(document).ready(function(){
        $("input[name='percentageMark']").on('input', function() {
            $(this).val(function(i, v) {
            return v.replace('%','') + '%';  });
            });
        });
    </script>
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

<div class="d-flex justify-content-start"> <button class='backbutton' onclick="window.location.href='iframeAContestParticipantList.php?id=<?php echo $_GET['contestId'];?>'">Back</button></div>
<div class="w-100">
    <img class="iframeimg" src="uploads/<?php echo $participantPhoto;?>" alt="Italian Trulli">
</div>
<form method="post" name="markOrDisqualify"  ENCTYPE="multipart/form-data" >
    <div class="d-flex justify-content-center pt-5" id="markDiv">
        <input type='tel' id="percentageMark" name="percentageMark" maxlength="3" value="<?php if((int)$participantScore>0)echo $participantScore;?>" onkeypress="return onlyNumberKey(event)" placeholder="99% Max">
        <input class="btnCss" type="submit" name="submitMark" id="submitMark" value="Assign Marks">
    </div>
    <div class="d-flex justify-content-center pt-4">
        <input class="btnCss" type="submit" name="disqualifyParticipant" value="Disqualify This Participant">
    </div>
</form>
<?php if($_SESSION['userType']!='admin'){echo'<script>(document.getElementById("percentageMark")).style.display = "none";(document.getElementById("submitMark")).style.display = "none";</script>';}?>
</body>

<?php
if (isset($_POST['submitMark'])) {
    $score = (int)$_POST['percentageMark'];
	$sql="UPDATE participantlist SET score = '$score' WHERE participantId ='$_GET[participantId]' AND contestId ='$_GET[contestId]' ;";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		header("Refresh:0");
	}
	mysqli_close($con);
}
if (isset($_POST['disqualifyParticipant'])) {
	$sql="UPDATE participantlist SET qualificationStatus = 'disqualified' WHERE participantId ='$_GET[participantId]' AND contestId ='$_GET[contestId]' ;";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo '<script>alert("Contest deleted successfully");</script>';
		header("Location: iframeAContestParticipantList.php?id=".$_GET['contestId'].";");
	}
	mysqli_close($con);
}
?>

