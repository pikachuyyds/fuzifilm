<?php
    require "conn.php";

    $id = $_GET('id');
    $deleteOrg = "DELETE FROM organiser WHERE organiserID = $id";

    if (mysqli_query($con, $deleteOrg)){
        echo "<script>alert('Organiser deleted from database');
            window.location.href = 'adminViewOrganiser.php';
            </script>";
    }else{
        echo "Error deleting record:" .$mysqli_error($con);
    }

?>