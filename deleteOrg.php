<?php
    require "conn.php";

    $id = $_GET['id'];

    $orgData = mysqli_query($con, "SELECT * FROM organiser WHERE organiserID = $id");
    $orgResult = mysqli_fetch_array($orgData);
    
    $orgLoginId = $orgResult['loginId']; 


    $deleteOrg = "DELETE FROM organiser WHERE organiserID = $id";
    $deleteLogin = "DELETE FROM login WHERE userType = 'organiser' AND loginId = $orgLoginId";

    if (mysqli_query($con, $deleteOrg)){
        if (mysqli_query($con, $deleteLogin)){
        echo "<script>alert('Organiser deleted successfully');
            window.location.href = 'adminViewOrganiser.php';
            </script>";
        }else{
            echo "Error deleting record from login database:" .$mysqli_error($con);
        }
    }else{
        echo "Error deleting record from organiser database:" .$mysqli_error($con);
    }
?>