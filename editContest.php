<?php 
include("conn.php"); 
require "header.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Contest</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/newContest.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="js/newContest.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php 
$sql ="SELECT * FROM contest WHERE contestId ='$_GET[id]'";
$result =mysqli_query($con, $sql);
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_array($result);}
?>
<!-- reuse code from newContest.php to ensure design consistency -->
<form method="post" name="editContest" id="editContest" ENCTYPE="multipart/form-data" >
<div class='w-100 d-flex'>
	<div class=' w-100 newContestHeader'> Edit Contest</div>
</div>
<div class='w-100 d-flex flex-wrap newContestFormContainer'>
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
                <input type="text" name="contestName" id="contestName" value="<?php echo $row['contestName'];?>" placeholder="e.g FUZIFLIM" pattern="[^'\x22]+" title="Contest Name. Please do not put quotes" required="required">
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Description</div>
            <div class='newContestFormField'>
                <textarea maxlength ="1000" rows="4" name="contestDescription" id="contestDescription"  placeholder="e.g One of the most common photography styles, portrait photography, or portraiture, aims to capture the personality and mood of an individual or group" pattern="[^'\x22]+" title="Contest Description. Please do not put quotes" required="required"><?php echo $row['description'];?></textarea>
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Thumbnail Image</div>
            <div class='newContestFormField'>
				<div  id="divThumbnailPreview"><img class='newImageSize ' id="newThumbnailPreview" src="uploads/<?php echo $row['contestImage'];?>" alt='contest thumbnailimage'></div>
                <label class="thumnailUpload">Choose File<input type="file" name="contestThumbnailImage" accept="image/jpg, image/jpeg, image/png" id="contestThumbnail" onchange="showthumbnailimg()"  ></label>
                <label id="displayThumbnailLabel" style="display:inline-block;">Filename : <?php echo $row['contestImage'];?></label>
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
	<div class='newContestFormSection' id="newContestPrice" style="display:block;">
			<div class='newContestFormLabel' >Price for participants (per pax)</div>
            <div class='newContestFormField'>
				<input <?php if($row['price'] > 0) {?> type="number" value="<?php echo $row['price'];?>" <?php }?>   <?php if($row['price'] <= 0) {?> type="text" value="<?php echo 'FREE';?>" <?php }?> name="newContestPriceInput" id="newContestPriceInput" placeholder="e.g. 30 " pattern="{1,2}" title="Please enter less than 100 only" disabled>
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Prize</div>
            <div class='newContestFormField'>
				<input type="text" name="contestPrize1" id="contestPrize1" value="<?php echo $row['championPrize'];?> "placeholder="Champion" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" >
				<input type="text" name="contestPrize2" id="contestPrize2" value="<?php echo $row['firstRunnerUpPrize'];?>" placeholder="First Runner Up" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" >
				<input type="text" name="contestPrize3" id="contestPrize3" value="<?php echo $row['secondRunnerUpPrize'];?>" placeholder="Second Runner Up" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" >
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' ></div>
            <div class='newContestFormField'>
				<button type="submit" class="addNewContest" name="updateContest" id="updateContest" >Update</button>
			</div>
	</div>

</div>

<?php 

if (isset($_POST['updateContest'])) {
	$thumbnailimg = $row["contestImage"];
	if (basename($_FILES["contestThumbnailImage"]["name"]!="")){
		$target_dir = "uploads/";
		$thumbnailimg = $target_dir. basename($_FILES["contestThumbnailImage"]["name"]);
		if (move_uploaded_file($_FILES["contestThumbnailImage"]["tmp_name"], $thumbnailimg)) 
		{
			$thumbnailname = basename($_FILES["contestThumbnailImage"]["name"]);
		}}
		else {$thumbnailname = $thumbnailimg;}

	$sql="UPDATE contest SET contestName = '$_POST[contestName]', contestImage='$thumbnailname', description='$_POST[contestDescription]' , championPrize ='$_POST[contestPrize1]', firstRunnerUpPrize='$_POST[contestPrize2]' , secondRunnerUpPrize='$_POST[contestPrize3]' WHERE contestId = '$_GET[id]';";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.reload();
		</script>";
	}
	mysqli_close($con);
}
?>
<?php require "footer.php"; ?>