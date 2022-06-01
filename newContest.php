<?php include("conn.php"); ?>
<?php
    require "header.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Contest</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/newContest.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="js/newContest.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		$(document).ready(function(){
			$("#contestFormPayment").click(function(){
			$("#newContestPrice").toggle();
			if($('input[name="contestFormPayment"]').is(':checked'))
			{
				(document.getElementById('newContestPriceInput')).setAttribute('required', '');
				(document.getElementById('addNewContest')).style.display = "none";
				(document.getElementById('paymentBoxButton')).style.display = "block";
			}else
			{
				(document.getElementById('newContestPriceInput')).removeAttribute('required');
				(document.getElementById('addNewContest')).style.display = "block";
				(document.getElementById('paymentBoxButton')).style.display = "none";
			}
			
			});
		});
	</script>
	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
		}
	</style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<form method="post" name="createcontest" id="createcontest" ENCTYPE="multipart/form-data" >
<div class='w-100 d-flex'>
	<div class=' w-100 newContestHeader'> Create Contest</div>
</div>
<div class='w-100 d-flex flex-wrap newContestFormContainer'>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Type</div>
            <div class='newContestFormField'>
            <select name="contestType" id='contestType' required="required">
				<option value=""disabled selected>-- Please Select --</option>
				<option value="Portrait">Portrait</option>
				<option value="Fashion">Fashion</option>
				<option value="Sports">Sports</option>
				<option value="Architectural">Architectural</option>
                <option value="Nature">Nature</option>
            </select>
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Name</div>
            <div class='newContestFormField'>
                <input type="text" name="contestName" id="contestName" placeholder="e.g FUZIFLIM" pattern="[^'\x22]+" title="Contest Name. Please do not put quotes" required="required">
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Description</div>
            <div class='newContestFormField'>
                <textarea maxlength ="1000" rows="4" name="contestDescription" id="contestDescription" placeholder="e.g One of the most common photography styles, portrait photography, or portraiture, aims to capture the personality and mood of an individual or group" pattern="[^'\x22]+" title="Contest Description. Please do not put quotes" required="required"></textarea>
			</div>
	</div>
    <div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Thumbnail Image</div>
            <div class='newContestFormField'>
				<div class="displayNone" id="divThumbnailPreview"><img class='newImageSize ' id="newThumbnailPreview" alt='contest thumbnailimage'></div>
                <label class="thumnailUpload">Choose File<input type="file" name="contestThumbnailImage" accept="image/jpg, image/jpeg, image/png" id="contestThumbnail" onchange="showthumbnailimg()" required="required" ></label>
				<label class="displayNone" id="displayThumbnailLabel" ></label>
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Date</div>
            <div class='newContestFormField'>
				<label class='contestDateLabel'> Start Date :</label>
				<input type="date" name="startdate" id="startdate" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" required="required">
				<label class='contestDateLabel'> End Date :</label>
				<input type="date" name="enddate" id="enddate" value="<?php echo date("Y-m-d"); ?>" min="<?php echo date("Y-m-d"); ?>" required="required">
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' >Payment</div>
            <div class='newContestFormField'>
				<input class="" type="checkbox" name="contestFormPayment" id="contestFormPayment" value="pay" >
  				<label for="contestFormPayment" id="contestFormPayment" class="contestPaymentLabel"> Pay (Fixed Price: RM100)</label>
				  <label for="contestFormPayment" id="contestFormPayment" class="contestPaymentLabel" style="font-size:2vmin;  margin-right:50px;">(if you choose to pay, you may request participant fee from the participants. Else, participants can join your contest for free)</label>
			</div>
	</div>
	<div class='newContestFormSection' id="newContestPrice">
			<div class='newContestFormLabel' >Price for participants (per pax)</div>
            <div class='newContestFormField'>
				<input type="number" name="newContestPriceInput" id="newContestPriceInput" placeholder="e.g. 30 " pattern="{1,2}" title="Please enter less than 100 only" onkeyup="priceValidation()">
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' >Contest Prize</div>
            <div class='newContestFormField'>
				<input type="text" name="contestPrize1" id="contestPrize1" placeholder="Champion" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" >
				<input type="text" name="contestPrize2" id="contestPrize2" placeholder="First Runner Up" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" >
				<input type="text" name="contestPrize3" id="contestPrize3" placeholder="Second Runner Up" pattern="[^'\x22]+" title="Contest Prize. Please do not put quotes" >
			</div>
	</div>
	<div class='newContestFormSection'>
			<div class='newContestFormLabel' ></div>
            <div class='newContestFormField'>
				<button type="submit" class="addNewContest" name="addNewContest" id="addNewContest" >Submit</button>
				<button type="button" class="addNewContest" name="paymentBoxButton" id="paymentBoxButton" onclick="showPaymentBox()">Payment</button>
			</div>
	</div>
	<div id="myModal" class="paymentModalBox">
	<div class="paymentModalBoxContent">
		<span class="paymentModalBoxClose"><span id="close">&times;</span></span>
		<p class="paymentModelBoxHeader">PAYMENT</p>
		<div class='paymentModelBoxDiv'> Credit Card Number &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
		<input name="credit-number"  id="cc-number" type="tel" maxlength="19" placeholder="Card Number" onkeypress="return onlyNumberKey(event)">
		</div>
		<div class='paymentModelBoxDiv'> Credit Card Expiry Date &nbsp;:
      	<input name="credit-expires"  id="cc-expires" type="tel" maxlength="5" placeholder="MM/YY" onkeypress="return onlyNumberKey(event)">
		&nbsp;&nbsp; <span class="cvc"> <span class="pt-1">Credit Card CVV :</span>
		<input name="credit-cvc"  id="cc-cvc" type="tel" maxlength="3" placeholder="CVC" onkeypress="return onlyNumberKey(event)"></span>
		</div>
		<div>
			<button type="submit"  class="addNewContestWithPayment" name="addNewContest2" id="addNewContest2" >Submit</button>
		</div>
	</div>
	</div>

</div>

<?php 
// get organiser information from database
$sql_organiser = "SELECT organiserID FROM organiser WHERE loginId = '$_SESSION[loginId]';";
$sql_organiserQuery = mysqli_query($con,$sql_organiser);
$organiserInfo = mysqli_fetch_array($sql_organiserQuery);

// organiser information
$organiserId = $organiserInfo['organiserID'];

if (isset($_POST['addNewContest'])) {
	$target_dir = "uploads/";
	$thumbnailimg = $target_dir. basename($_FILES["contestThumbnailImage"]["name"]);
	if (move_uploaded_file($_FILES["contestThumbnailImage"]["tmp_name"], $thumbnailimg)) 
	{
		$thumbnailname = basename($_FILES["contestThumbnailImage"]["name"]);
	}
		$payment ="free";
		$price=0;

	$sql="INSERT INTO contest(contestName, contestImage, description , startDate , endDate, paidOrFree , price, approvalStatus , contestType ,championPrize,firstRunnerUpPrize,secondRunnerUpPrize,organiserID) 
	VALUES 
	('$_POST[contestName]','$thumbnailname','$_POST[contestDescription]','$_POST[startdate]','$_POST[enddate]','$payment','$price','pending','$_POST[contestType]','$_POST[contestPrize1]','$_POST[contestPrize2]','$_POST[contestPrize3]','$organiserId');";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.href= 'requestModification.php';
		</script>";
	}
	mysqli_close($con);
}elseif(isset($_POST['addNewContest2'])){
	$target_dir = "uploads/";
	$thumbnailimg = $target_dir. basename($_FILES["contestThumbnailImage"]["name"]);
	if (move_uploaded_file($_FILES["contestThumbnailImage"]["tmp_name"], $thumbnailimg)) 
	{
		$thumbnailname = basename($_FILES["contestThumbnailImage"]["name"]);
	}
		$payment="paid";
		$price=$_POST['newContestPriceInput'];

	$sql="INSERT INTO contest(contestName, contestImage, description , startDate , endDate, paidOrFree , price, approvalStatus , contestType ,championPrize,firstRunnerUpPrize,secondRunnerUpPrize,organiserID) 
	VALUES 
	('$_POST[contestName]','$thumbnailname','$_POST[contestDescription]','$_POST[startdate]','$_POST[enddate]','$payment','$price','pending','$_POST[contestType]','$_POST[contestPrize1]','$_POST[contestPrize2]','$_POST[contestPrize3]','$organiserId');";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	$contestsql ="SELECT * FROM contest WHERE organiserID ='1' ORDER BY contestId DESC LIMIT 1";
	$contestresult =mysqli_query($con, $contestsql);
	if (mysqli_num_rows($contestresult)) {
		$contestrow = mysqli_fetch_array($contestresult);}
	$date = date("Y-m-d");
	$sql="INSERT INTO paymentrecord(amount, date, purpose , payer , receiver,contestId, organiserID) 
	VALUES 
	('100','$date','Contest Creation','Organiser','Admin','$contestrow[contestId]','$organiserId');";
	if (!mysqli_query($con,$sql)){
			die('Error: ' . mysqli_error($con));
		}
	else {
		echo "<script>
		window.location.href= 'allContest.php';
		</script>";
	}
	mysqli_close($con);
}
?>
<?php require "footer.php"; ?>