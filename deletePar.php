<?php
    require "conn.php";

    $id = $_GET('id');
    $deletePar = "DELETE FROM participant WHERE organiserID = $id";

    if (mysqli_query($con, $deletePar)){
        echo "<script>alert('Participant deleted from database');
            window.location.href = 'adminViewParticipant.php';
            </script>";
    }else{
        echo "Error deleting record:" .$mysqli_error($con);
    }

?>