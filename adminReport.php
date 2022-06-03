<?php
require ("conn.php");
require ("header.php");
if (isset($_SESSION['loginId'])){

    $userType = "admin";
    $userData = mysqli_query($con, "SELECT * FROM $userType WHERE loginId = '$_SESSION[loginId]' ");
    $userResult = mysqli_fetch_array($userData);

    $name = $userResult['name'];

    $profileUrl = "<a href = 'userProfile.php'> Personal Information </a>";
    $reportUrl = "<a href = 'adminReport.php'> Report </a>";

    if ($userResult['profilePic'] === null){
        $pic = 'uploads/defaultProfile.png';
    }else{
        $pic = $userResult['profilePic'];
    }
}

$contestData = mysqli_query($con, "SELECT * FROM contest");
if (mysqli_num_rows($contestData) > 0){ //check whether has data
    while ($contestResult = mysqli_fetch_array($contestData)){
        $contestId[] = $contestResult["contestId"]; 
    }

    $countCon = count($contestId); //count total organised contest
    $contestIds = implode (";", $contestId);

}else{
    $countCon = "No Contest";
} 

$participantData = mysqli_query($con, "SELECT * FROM participant");
if (mysqli_num_rows($participantData)>0){
    while ($participantResult = mysqli_fetch_array($participantData)){
        $points[] = $participantResult["leaderboardPoint"]; 
    }
    $totalPoint = array_sum($points); //count total earned leaderboard point
}else{
    $totalPoint = "No Points Earned";
}


if (isset ($_POST["month"], $_POST["year"]))
{
    $month = $_POST["month"];
    $year = $_POST["year"];

    $contestData1 = mysqli_query($con, "SELECT * FROM contest WHERE MONTH(startDate) = '$month' AND YEAR(startDate) = '$year'"); 
    //only select contest created in specific month and year
    
    if (mysqli_num_rows($contestData1) > 0){ //check whether has data
        while ($contestResult1 = mysqli_fetch_array($contestData1)){
            $contestId1[] = $contestResult1["contestId"]; 
        }
        $contestId1s = implode (";", $contestId1);//take elements of array into string
    }else{
        $contestId1 = [];
    }

    if (count($contestId1) >0){ //check whether has contest in that time
        $parListData1 = mysqli_query($con, "SELECT * FROM participantlist WHERE contestId IN ('$contestId1s') ");
        if (mysqli_num_rows($parListData1) > 0){
            while ($parListResult1 = mysqli_fetch_array($parListData1)){
                $joinedId1[] = $parListResult1["participantId"];
            }

            $countPar = count($joinedId1); //count total participants joined in that time

        }else{
            $countPar = "No Participant";
        }

    }else{
        $countPar = "No Participant";
    }


    if(count($contestId1) >0){
        $payData = mysqli_query($con, "SELECT * FROM paymentRecord WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'");
        if (mysqli_num_rows($payData) > 0){
            while ($payResult = mysqli_fetch_array($payData)){
                $amount[] = $payResult["amount"];
            }
            $totalPay = array_sum($amount); //count total amount earned for all contests

        }else{
            $totalPay = "No Payment";
        }

    }else{
        $totalPay = "No Payment";
    }


    $registerData1 = mysqli_query($con, "SELECT * FROM participant WHERE MONTH(joinDate) = '$month' AND YEAR(joinDate) = '$year'");
    if (mysqli_num_rows($registerData1) > 0){
        while ($registerResult1 = mysqli_fetch_array($registerData1)){
            $participantId1[] = $registerResult1["participantId"]; 
        }

        $countReg = count($participantId1); //count total registered participants in that time

    }else{
        $countReg = "No Participant";
    }



}else{ //if didnt set
        
    $contestData2 = mysqli_query($con, "SELECT * FROM contest");
    if (mysqli_num_rows($contestData2) > 0){ 
        while ($contestResult2 = mysqli_fetch_array($contestData2)){
            $contestId2[] = $contestResult2["contestId"]; 
        }
        $contestId2s = implode (";", $contestId2);
    }else{
        $contestId2 = [];
    }   

    if (count($contestId2) >0){ 
        $parListData2 = mysqli_query($con, "SELECT * FROM participantlist WHERE contestId IN ('$contestId2s') ");
        if (mysqli_num_rows($parListData2) > 0){
            while ($parListResult2 = mysqli_fetch_array($parListData2)){
                $joinedId2[] = $parListResult2["participantId"];
            }

            $countPar = count($joinedId2); //count total participants joined

        }else{
            $countPar = "No Participant";
        }

    }else{
        $countPar = "No Participant";
    }

    if(count($contestId2) >0){
        $payData2 = mysqli_query($con, "SELECT * FROM paymentRecord");
        if (mysqli_num_rows($payData2) > 0){
            while ($payResult2 = mysqli_fetch_array($payData2)){
                $amount2[] = $payResult2["amount"];
            }
            $totalPay = array_sum($amount2); //count total amount earned for all contests

        }else{
            $totalPay = "No Payment";
        }

    }else{
        $totalPay = "No Payment";
    }

    $participantData2 = mysqli_query($con, "SELECT * FROM participant");
    if (mysqli_num_rows($participantData2)>0){
        while ($participantResult2 = mysqli_fetch_array($participantData2)){
            $participantId2[] = $participantResult2["participantId"];
        }
        $countReg = count($participantId2); //count total registered participants

    }else{
        $countReg = "No Participant";
    }
}
?> 

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | Admin Report </title>
        <link href = "css/adminReport.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = headerSection>
            <div>
                <p>Admin</p>
                <div class = "userName"><?php echo "$name"?></div>
                
                <div class = "pageInfo">
                    <?php
                        echo "<ul>";
                        echo "<li>$profileUrl</li>";
                        echo "<li>$reportUrl</li>";
                        echo "</ul>";
                    ?>
                </div>
            </div>
            <div class="image"><img src="<?php echo $pic?>" alt="profile picture"></div>
        </div>

        <div class = "adminReport">
            <p>REPORT</p>
            <div class = "data">
                <form name = "selection" method = "POST" class = "selection" action = "<?php echo $_SERVER['PHP_SELF']; ?>" >
                    <select class = "selectM" name = "month" >
                        <option value = "none" selected hidden disabled>Month</option>
                        <option value = "1" <?php if (isset($month) && $month=="1") echo "selected";?>>January</option>
                        <option value = "2" <?php if (isset($month) && $month=="2") echo "selected";?>>February</option>
                        <option value = "3" <?php if (isset($month) && $month=="3") echo "selected";?>>March</option>
                        <option value = "4" <?php if (isset($month) && $month=="4") echo "selected";?>>April</option>
                        <option value = "5" <?php if (isset($month) && $month=="5") echo "selected";?>>May</option>
                        <option value = "6" <?php if (isset($month) && $month=="6") echo "selected";?>>June</option>
                        <option value = "7" <?php if (isset($month) && $month=="7") echo "selected";?>>July</option>
                        <option value = "8" <?php if (isset($month) && $month=="8") echo "selected";?>>August</option>
                        <option value = "9" <?php if (isset($month) && $month=="9") echo "selected";?>>September</option>
                        <option value = "10" <?php if (isset($month) && $month=="10") echo "selected";?>>October</option>
                        <option value = "11" <?php if (isset($month) && $month=="11") echo "selected";?>>November</option>
                        <option value = "12" <?php if (isset($month) && $month=="12") echo "selected";?>>December</option>
                    </select>

                    <span></span>

                    <select class = "selectY" name = "year" onchange = "selection.submit()">
                        <option value = "none" selected hidden disabled>Year</option>
                        <option value = "2021" <?php if (isset($year) && $year=="2021") echo "selected";?>>2021</option>
                        <option value = "2022" <?php if (isset($year) && $year=="2022") echo "selected";?>>2022</option>
                        <option value = "2023" <?php if (isset($year) && $year=="2023") echo "selected";?>>2023</option>
                    </select>
                </form>

                <table class = "reportMonth">
                    <?php    
                        $row = '<tr>
                                    <th>Total Registered Participants</th>
                                    <td> '.$countReg. '</td>
                                </tr>
                                <tr>           
                                    <th>Total Participants Joined</th>
                                    <td>' .$countPar. '</td>
                                </tr>
                                <tr>
                                    <th>Total Gained Money (RM)</th>
                                    <td>' .$totalPay. '</td>
                                </tr>';
                                
                        echo $row;
                    ?>
                </table>

                <br><br>
                <table class = "reportTotal">
                    <?php
                        $row1 = '<tr>
                                    <th>Total Created Contest</th>
                                    <td>' .$countCon. '</td>
                                </tr>
                                <tr>
                                    <th>Total Gained Points</th>
                                    <td>' .$totalPoint. '</td>
                                </tr>';

                        echo $row1;
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
<?php require "footer.php" ?>