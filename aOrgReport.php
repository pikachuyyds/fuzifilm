<?php
require "header.php";
require "conn.php";

$id = $_GET["id"];
$userType = 'organiser';
$userData = mysqli_query($con, "SELECT * FROM $userType WHERE organiserID = '$id' ");
$userResult = mysqli_fetch_array($userData);

$name = $userResult['name'];

$profileUrl = "<a href = 'aOrgProfile.php?id=$id '> Personal Information </a>";
$contestUrl =  "<a href = 'aOrgContest.php?id=$id'> Contest History</a>";
$reportUrl = "<a href = 'aOrgReport.php?id=$id'> Report </a>";

if ($userResult['profilePic'] === null){
    $pic = 'uploads/defaultProfile.png';
}else{
    $pic = $userResult['profilePic'];
}

    if (isset ($_POST["month"], $_POST["year"]))
{
    $month = $_POST["month"];
    $year = $_POST["year"];
    $contestId = [];
    
    $contestData = mysqli_query($con, "SELECT * FROM contest WHERE organiserID = '$id' 
                                        AND MONTH(startDate) = '$month' AND YEAR(startDate) = '$year'"); 
    //only select contest created in specific month and year
    
    if (mysqli_num_rows($contestData) > 0){ //check whether has data
        while ($contestResult = mysqli_fetch_array($contestData)){
            $contestId[] = $contestResult["contestId"]; 
        }

        $countCon = count($contestId); //count total organised contest
        $contestIds = implode (";", $contestId);//take elements of array into string

    }else{
        $countCon = "No Contest";
    }

    if (count($contestId) >0){ //check whether has contest
        $parListData = mysqli_query($con, "SELECT * FROM participantlist WHERE contestId IN ('$contestIds') ");
        if (mysqli_num_rows($parListData) > 0){
            while ($parListResult = mysqli_fetch_array($parListData)){
                $joinedId[] = $parListResult["participantId"];
            }

            $countPar = count($joinedId); //count total participants joined
        }else{
            $countPar = "No Participant";
        }

    }else{
        $countPar = "No Participant";
    }

    if(count($contestId) >0){
        $payData = mysqli_query($con, "SELECT * FROM paymentRecord WHERE organiserID = '$id' 
                                    AND contestId IN ('$contestIds') ");
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

}else{ //if didnt set
    $contestData = mysqli_query($con, "SELECT * FROM contest WHERE organiserID = '$id' ");
    if (mysqli_num_rows($contestData) > 0){ //check whether has data
        while ($contestResult = mysqli_fetch_array($contestData)){
            $contestId[] = $contestResult["contestId"]; 
        }
        $countCon = count($contestId); 
        $contestIds = implode (";", $contestId);
    }else{
        $countCon = "No Contest";
        $contestId = [];
    }

    if (count($contestId) >0){ //check whether has contest
        $parListData = mysqli_query($con, "SELECT * FROM participantlist WHERE contestId IN ('$contestIds') ");
        if (mysqli_num_rows($parListData) > 0){
            while ($parListResult = mysqli_fetch_array($parListData)){
                $joinedId[] = $parListResult["participantId"];
            }

            $countPar = count($joinedId); //count total participants joined
        }else{
            $countPar = "No Participant";
        }

    }else{
        $countPar = "No Participant";
    }

    if(count($contestId) >0){
        $payData = mysqli_query($con, "SELECT * FROM paymentRecord WHERE organiserID = '$id' 
                                    AND contestId IN ('$contestIds') ");
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
}
?> 

<!DOCTYPE html>
<html lang = en>
    <head>
        <title> FUZIFILM | View Organiser Report </title>
        <link href = "css/aOrgReport.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = headerSection>
            <div class="image"><img src="<?php echo $pic?>" alt="profile picture"></div>
            <div class = "userInfo"><?php echo strtoUpper("<p>$userType</p>") ?></div>
            <div class = "userName"><?php echo "$name"?></div>
            
            <div class = "pageInfo">
                <?php
                    echo "<ul>";
                    echo "<li>$profileUrl</li>";
                    echo "<li>$contestUrl</li>";
                    echo "<li>$reportUrl</li>";
                    echo "</ul>";
                ?>
            </div>
            <form method = "post">
                <div class = "btn">
                    <button type= 'submit' name ='delete' onclick = 'deleteProfile();'>DELETE</button> 
                </div>
            </form>
        </div>

        <div class = "orgReport">
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

                <table class = "reportData">
                    <?php    
                        $row = '<tr>
                                    <th>Total Created Contest</th>
                                    <td>' .$countCon. '</td>
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
            </div>
        </div>
    </body>
</html>        
<?php require "footer.php"?>

<script>
    function deleteProfile(){
        if (confirm("Do you really want to delete this organiser?")){
            window.location.href = 'deleteOrg.php?id=<?php $id ?>';
        }
    }
</script>