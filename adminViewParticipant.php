<?php
    require "header.php";
    require "conn.php";

    $participantData = mysqli_query($con, "SELECT * FROM participant");
    $participantresult = mysqli_fetch_array($participantData);
?>