<?php include("conn.php"); ?>
<?php

    require "header.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Contest Modification Request Record</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/requestModification.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/requestModification.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php 
$sql ="SELECT * FROM contestdetailchangingrequest WHERE changingRequestID ='$_GET[id]'";
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
	<div class=' w-100 requestModificationHeader'> Record: Request Modification</div>
</div>
<div class='w-100 d-flex flex-wrap requestModificationContainer'>
    <button type="button" id="contestPageButton" class="requestModificationOtherPage" onclick="window.open('aContestOrgAndAdm.php?id=<?php echo $contestId; ?>')">View Contest Page</button>
    <button type="button" id="editContestButton" class="requestModificationOtherPage" onclick="window.open('editContest.php?id=<?php echo $contestId; ?>')">Edit Contest</button>
    <!-- if user is organiser button will be hidden, if user is admin button will be visible -->
    <?php if ($_SESSION['userType'] =="organiser") {echo"<script>(document.getElementById('contestPageButton')).style.display = 'none';(document.getElementById('editContestButton')).style.display = 'none';</script>";}?>
    <?php if ($_SESSION['userType'] =="admin") {echo"<script>(document.getElementById('contestPageButton')).style.display = 'inline-block';(document.getElementById('editContestButton')).style.display = 'inline-block';</script>";}?>
    <div class='requestModificationSection mt-2'>
        <div class='requestModificationLabel' > Contest ID : <?php echo $contestrow['contestId'];?> </div>
	</div>
    <div class='requestModificationSection'>
        <div class='requestModificationLabel' > Contest Name : <?php echo $contestrow['contestName'];?> </div>
	</div>
    <div class='requestModificationSection'>
		<div class='requestModificationLabel' > Status : <?php if($row['approvalStatus'] == 'rejected') {echo" <i class='bi bi-x-square'></i> Rejected";}elseif($row['approvalStatus'] == 'approved') {echo"<i class='bi bi-check-square'></i> Approved ";}elseif($row['approvalStatus'] == 'pending') {echo" Pending ";} ?></div>
    </div>
    <p></p><hr>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel ' >What to change?</div>
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
                <textarea maxlength ="1000" rows="4" name="requestModificationDescription" id="requestModificationDescription" placeholder="<?php echo $row['description'];?>" disabled ></textarea>
			</div>
	</div>
    <div class='requestModificationSection'>
			<div class='requestModificationLabel' >Comments</div>
            <div class='requestModificationField'>
                <textarea maxlength ="1000" rows="4" name="requestModificationComment" id="requestModificationComment" placeholder="<?php echo $row['comment'];?>" disabled><?php if($row['comment'] == '') {echo" This request has not been reviewed by admin yet";} ?></textarea>
			</div>
	</div>
</div>
<?php require "footer.php"; ?>