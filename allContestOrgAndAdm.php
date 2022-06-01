<!DOCTYPE html>
<html lang="en">

<?php
    require "header.php";
    if ($_SESSION['userType']=='admin'){
        $title='All Contest';
    }elseif($_SESSION['userType']=='organiser'){
        $title='Your contest';
    }
?>
<!--------------------------------------------- delete row use session --------------------------------------------->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\allContest.css">
    <link href='https://fonts.googleapis.com/css?family=Playfair Display' rel='stylesheet'>
    <title>All contest</title>
</head>
<body>
    <!--------------------------------------------- upper part of the contest page --------------------------------------------->
    <div class="contest1"> 
        <div class="left">
            <div class="title"><?php echo $title ?></div>
        </div>
    </div>

    <!----------------------------------------- lower part of the contest page (contest btn) ---------------------------------------->
    <div class="allContest">
        <?php
            require "conn.php";
            if ($_SESSION['userType']=='admin'){
                $sql_allContest = "SELECT contestId, contestName, contestImage, endDate, paidOrFree, price  FROM contest WHERE approvalStatus='approved';";
            }elseif($_SESSION['userType']=='organiser'){
                $sql_allContest = "SELECT contestId, contestName, contestImage, endDate, paidOrFree, price  FROM contest WHERE organiserID = '1' AND approvalStatus='approved';";
            }
            // delete row and predefined id use session
            $sql_allContestQuery = mysqli_query($con,$sql_allContest);
            while ($contestInfo = mysqli_fetch_array($sql_allContestQuery)) {
                $id = $contestInfo['contestId'];
                $name = $contestInfo['contestName'];
                $image = $contestInfo['contestImage'];
                $paidOrFree = $contestInfo['paidOrFree'];
                $price = $contestInfo['price'];

                // to get the status that shows on every contest's image (either due join date, judging, announced)
                $now = time()-(60*60*24);
                $endDate = $contestInfo['endDate'];
                $announcement = date('Y-m-d', strtotime($endDate . ' +14 day')); 

                if ($now >= strtotime($announcement))
                {
                    $status = "announced";
                }
                 else if($now > strtotime($endDate))
                {
                    $status = "judging";  
                } 
                else 
                {
                    $status = $endDate . " due";
                }

                // free or paid status
                if ($paidOrFree == "free")
                {
                    $requiredPrice = "free";
                }
                else if ($paidOrFree == "paid") 
                {
                    $requiredPrice = "RM ".$price;
                }
        ?>
            <a href="aContestOrgAndAdm.php?id=<?php echo $id; ?>"><div class="aContest">
                <div class="contentInfo"><?php echo $status ?></div>
                <div class="contentInfo">
                    <div class="img">
                        <img src="uploads/<?php echo $image ?>" alt="contest img">
                    </div>
                </div>
                <div class="contentInfo"><?php echo $name ?></div>
                <div class="contentInfo"><?php echo $requiredPrice ?></div>
            </div></a>
        <?php } ?>
        


    </div>
</body>
</html>

<?php require "footer.php"; ?>