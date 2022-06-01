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

<form method="post" name="requestModification" id="requestModification" ENCTYPE="multipart/form-data" >
<div class='w-100 d-flex'>
	<div class=' w-100 requestModificationHeader'> Request Modification</div>
</div>
<div class='w-100 d-flex flex-wrap requestModificationContainer'>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel' >What to change?</div>
            <div class='requestModificationField'>
            <select name="requestModificationType" id='requestModificationType' required="required" onchange="displayUploadButton()">
            <option value=""disabled selected>-- Please Select --</option>
				<option value="name">Name</option>
				<option value="description">Description</option>
				<option value="thumbnailimage">Thumbnail Image</option>
				<option value="contestprize">Contest Prize</option>
                <option value="delete">Delete Contest</option>
                <option value="other">Others</option>
            </select>
			</div>
	</div>
    <div class='requestModificationSection displayNone' id="requestModificationThumbnailSection">
			<div class='requestModificationLabel' >New Contest Thumbnail Image</div>
            <div class='requestModificationField'>
				<div class="displayNone" id="divThumbnailPreview"><img class='newImageSize ' id="modificationThumbnailPreview" alt='contest thumbnailimage'></div>
                <label class="thumnailUpload">Choose File<input type="file" name="modificationRequestThumbnailImage" accept="image/jpg, image/jpeg, image/png" id="requestModificationThumbnail" onchange="showthumbnailimg()"  ></label>
                <label class="displayNone" id="displayThumbnailLabel"></label>
			</div>
	</div>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel' >Description</div>
            <div class='requestModificationField'>
                <textarea maxlength ="1000" rows="4" name="requestModificationDescription" id="requestModificationDescription" placeholder=" e.g. 1) I want to change the contest name to FUZIFILM because..." pattern="[^'\x22]+" title="Contest Modification Request Description. Please do not put quotes" required="required"></textarea>
			</div>
	</div>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel' ></div>
            <div class='requestModificationField'>
				<button type="submit" class="requestModificationBtn" name="requestModificationSubmit" id="requestModificationSubmit">Submit</button>
			</div>
	</div>
	<div class='requestModificationSection'>
			<div class='requestModificationLabel' ></div>
            <div class='requestModificationField'>
				<button type="submit" class="requestModificationBtn" name="requestModificationSubmit2" id="requestModificationSubmit2" style="display:none;">Submit</button>
			</div>
	</div>
</div>

<?php


if (isset($_POST['requestModificationSubmit'])) {
	$currentDate = date("Y-m-d");
	$sql="INSERT INTO contestdetailchangingrequest(detailToChange, newImage, description , requestDate , approvalStatus, contestId) 
	VALUES 
	('$_POST[requestModificationType]',NULL,'$_POST[requestModificationDescription]','$currentDate','pending','$_GET[id]');";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.href= 'aContestOrgAndAdm.php?id=$_GET[id]';
		</script>";
	}
	mysqli_close($con);
}elseif(isset($_POST['requestModificationSubmit2'])){
	$target_dir = "uploads/";
	$thumbnailimg = $target_dir. basename($_FILES["modificationRequestThumbnailImage"]["name"]);
	if (move_uploaded_file($_FILES["modificationRequestThumbnailImage"]["tmp_name"], $thumbnailimg)) 
	{
		$thumbnailname = basename($_FILES["modificationRequestThumbnailImage"]["name"]);
	}
	$currentDate = date("Y-m-d");
	$sql="INSERT INTO contestdetailchangingrequest(detailToChange, newImage, description , requestDate , approvalStatus,comment, contestId) 
	VALUES 
	('$_POST[requestModificationType]','$thumbnailname','$_POST[requestModificationDescription]','$currentDate','pending',NULL,'$_GET[id]');";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo '<script>alert("Request submitted!!!")</script>';
		echo "<script>
		window.location.href= 'aContestOrgAndAdm.php?id=$_GET[id]';
		</script>";
	}
	mysqli_close($con);
}
?>
<?php require "footer.php"; ?>