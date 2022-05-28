<?php
    require "header.php";
    require "conn.php";

    // user validation
    if ($user != "participant")
    {
        if ($user != "guest") 
        {
            die("youre not allow to access to this page");
            echo "<script>
            alert('Please sign in');
            window.location.href = 'home_pg.php';</script>";
        }
    }
    // get all contests information
    $sql_allContest = "SELECT * FROM contest WHERE approvalStatus = 'approved';";
    $sql_allContestQuery = mysqli_query($con,$sql_allContest);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\allContest.css">
    <link href='https://fonts.googleapis.com/css?family=Playfair Display' rel='stylesheet'>
    <title>Contest</title>
</head>
<body>
    <!--------------------------------------------- upper part of the contest page --------------------------------------------->
    <div class="contest1"> 
        <div class="left">
            <div class="title">Contest</div>
            <div class="allFilter">
                <div class="selectedFilter">
                    on-going
                    <img src="images\x.png" alt="close" onclick=""> <!-- use conclick to delete the selected filter-->
                </div>
            </div>
        </div>
        <div class="right">
            <div class="filterBtn">
                <img src="images\filterBtn.png" alt="filter button" onclick="">
            </div>
        </div>
    </div>

    <!----------------------------------------- lower part of the contest page (contest btn) ---------------------------------------->
    <div class="allContest">


        <?php      
            while ($contestInfo = mysqli_fetch_array($sql_allContestQuery)) {
                $id = $contestInfo['contestId'];
                $id = "1";
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
            <a href="aContest.php?id=<?php echo $id; ?>"><div class="aContest">
                <div class="contentInfo"><?php echo $status ?></div>
                <div class="contentInfo">
                    <div class="img">
                        <img src="<?php echo $image ?>" alt="contest img">
                    </div>
                </div>
                <div class="contentInfo"><?php echo $name ?></div>
                <div class="contentInfo"><?php echo $requiredPrice ?></div>
            </div></a>
        <?php } ?>
        


    </div>
</body>
</html>

<?php
    require "footer.php";
?>