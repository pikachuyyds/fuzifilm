<!DOCTYPE html>
<html>
<head>
	<title>Record: Request Modification</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/contestStatusOfApproval.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style=" min-height:700px;">
<div class='w-100 d-flex'>
	<div class=' w-100 statusOfApprovalHeader'> Record: Request Modification</div>
</div>
<!-- Different iframe based on role (organiser//admin)-->
<iframe class="iframeContainer" src="<?php if ($_SESSION['userType'] =='organiser') {echo'iframeReqModiApprovalOrganiser.php';}if ($_SESSION['userType'] =='admin') {echo'iframeReqModiApprovalAdmin.php';}?>" title="Click to view more information"></iframe>

</body>