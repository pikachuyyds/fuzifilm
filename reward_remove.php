<?php 
    include("conn.php");

    if (!mysqli_query($con,"DELETE FROM rewardpointhistory WHERE rewardId = '$_GET[rewardId]';")){
        die("delete reward point history error" . mysqli_error($con));
    } else {
        if (!mysqli_query($con,"DELETE FROM reward WHERE rewardId = '$_GET[rewardId]';")){
            die("delete reward error" . mysqli_error($con));
        } else {
            echo "<script>alert('Successfully deleted');
            window.location.href = 'reward_all.php';
            </script>";
        }
    }

?>