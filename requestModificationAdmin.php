<?php include("conn.php"); ?>
<?php

    require "header.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Contest Modification Request</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/requestModification.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/requestModification.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php 
$sql ="SELECT * FROM contestdetailchangingrequest WHERE changingRequestID ='2'";
$result =mysqli_query($con, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_array($result);}
$contestsql ="SELECT * FROM contest WHERE contestId =$row[contestId]";
$contestId=$row['contestId'];
$contestresult =mysqli_query($con, $contestsql);
if (mysqli_num_rows($contestresult)) {
	$contestrow = mysqli_fetch_array($contestresult);}
?>
<form method="post" name="requestModification" id="requestModification" ENCTYPE="multipart/form-data" >
<div class='w-100 d-flex'>
	<div class=' w-100 requestModificationHeader'>Contest Modification Request</div>
</div>
<div class='w-100 d-flex flex-wrap requestModificationContainer'>
    <button type="button" class="requestModificationOtherPage" onclick="window.open('aContestOrgAndAdm.php?id=<?php echo $contestId; ?>')">View Contest Page</button>
    <button type="button" class="requestModificationOtherPage" onclick="window.open('editContest.php?id=<?php echo $contestId; ?>')">Edit Contest</button>
	<div class='requestModificationSection mt-2'>
        <div class='requestModificationLabel' > Contest ID : <?php echo $contestrow['contestId'];?> </div>
	</div>
	<div class='requestModificationSection'>
        <div class='requestModificationLabel' > Contest Name : <?php echo $contestrow['contestName'];?> </div>
	</div>
	<p></p><hr>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel mt-2' >What to change?</div>
            <div class='requestModificationField'>
            <select name="requestModificationType" id='requestModificationType' disabled>
            <option value=""disabled selected>-- Please Select --</option>
                <option <?php if($row['detailToChange'] == 'name') {?> selected ='selected' <?php } ?> value="name">Name</option>
				<option <?php if($row['detailToChange'] == 'description') {?> selected ='selected' <?php } ?> value="description">Description</option>
				<option <?php if($row['detailToChange'] == 'thumbnailimage') {?> selected ='selected' <?php } ?> value="thumbnailimage">Thumbnail Image</option>
				<option <?php if($row['detailToChange'] == 'contestprize') {?> selected ='selected' <?php } ?> value="contestprize">Contest Prize</option>
                <option <?php if($row['detailToChange'] == 'delete') {?> selected ='selected' <?php } ?> value="delete">Delete Contest</option>
                <option <?php if($row['detailToChange'] == 'other') {?> selected ='selected' <?php } ?> value="other">Others</option>
            </select>
			</div>
	</div>
    <?php
        $thumbnailDiv="<div class='requestModificationSection'>
                        <div class='requestModificationLabel' >New Contest Thumbnail Image</div>
                        <div class='requestModificationField'>
                            <img class='newImageSize' src='uploads/".$row['newImage']."'  alt='contest thumbnailimage'>
                        </div>
                    </div>";
        if($row['detailToChange']=='thumbnailimage'){
            echo $thumbnailDiv;
        }
    ?>

    <div class='requestModificationSection'>
			<div class='requestModificationLabel' >Description</div>
            <div class='requestModificationField'>
                <textarea maxlength ="1000" rows="4" name="requestModificationDescription" id="requestModificationDescription" placeholder="<?php echo $row['description'];?>" pattern="[^'\x22]+" title="Contest Modification Request Description. Please do not put quotes" disabled ></textarea>
			</div>
	</div>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel' >Comments</div>
            <div class='requestModificationField'>
                <textarea maxlength ="1000" rows="4" name="requestModificationComment" id="requestModificationComment" placeholder=" e.g. Sorry, the contest name is inappropriate" pattern="[^'\x22]+" title="Contest Modification Request Comment. Please do not put quotes" required></textarea>
			</div>
	</div>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel' ></div>
            <div class='requestModificationField'>
                <button type="submit" class="requestModificationReject" name="requestModificationReject" id="requestModificationReject">Reject</button>
				<button type="submit" class="requestModificationApprove" name="requestModificationApprove" id="requestModificationApprove">Approve</button>
			</div>
	</div>
</div>

<?php 
if (isset($_POST['requestModificationReject'])) {
	$sql="UPDATE contestdetailchangingrequest SET approvalStatus = 'rejected', comment='$_POST[requestModificationComment]' WHERE changingRequestID = '$_GET[id]';";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.href= 'allRequestModification.php';
		</script>";
	}
	mysqli_close($con);
}elseif(isset($_POST['requestModificationApprove'])) {
	$sql="UPDATE contestdetailchangingrequest SET approvalStatus = 'approved', comment='$_POST[requestModificationComment]' WHERE changingRequestID = '$_GET[id]';";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.href= 'allRequestModification.php';
		</script>";
	}
	mysqli_close($con);
}

?>
<?php require "footer.php"; ?>