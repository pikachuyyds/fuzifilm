<?php
    require "conn.php";

    $id = $_GET['id'];

    $parData = mysqli_query($con, "SELECT * FROM participant WHERE participantId = $id");
    $parResult = mysqli_fetch_array($parData);
    
    $parLoginId = $parResult['loginId']; 


    $deletePar = "DELETE FROM participant WHERE participantId = $id";
    $deleteLogin = "DELETE FROM login WHERE userType = 'participant' AND loginId = $parLoginId";

    if (mysqli_query($con, $deletePar)){
        if (mysqli_query($con, $deleteLogin)){
        echo "<script>alert('Participant deleted successfully');
            window.location.href = 'adminViewParticipant.php';
            </script>";
        }else{
            echo "Error deleting record from login database:" .mysqli_error($con);
        }
    }else{
        echo "Error deleting record from participant database:" .mysqli_error($con);
    }

?>