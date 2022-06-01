<?php
    require "header.php";
    require "conn.php";

    $participantData = mysqli_query($con, "SELECT * FROM participant");
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title> FUZIFILM | View Participant Profile </title>
        <link href = "css/adminViewParticipant.css" rel = "stylesheet" type = "text/css">
    </head>
    <body>
        <div class = "headerSection">
            <div class = "title">Participant Profile</div>
            <div class = "search">
                <form method = "get" action = "<?php echo $_SERVER['PHP_SELF']; ?>" >
                    <label for = "searchTitle">Search: </label>
                    <input type = "search" id = "search" name = "searchText">
                </form>
            </div>
        </div>

        <div class = "data">
            <?php
                if(isset($_GET["searchText"])){
                    $searchText = $_GET["searchText"];
                    $searchText = htmlspecialchars($searchText);
                    $searchText = mysqli_real_escape_string($con, $searchText); 
                    $searchData = mysqli_query($con, "SELECT * FROM participant WHERE (name LIKE '%" .$searchText. "%')");
                    if (mysqli_num_rows($searchData) > 0){
                        while($searchResult = mysqli_fetch_array($searchData))
                        {
                            $id = $searchResult["participantId"];
                            $name = $searchResult["name"];

                            if ($searchResult['profilePic'] === null){
                                $pic = 'uploads/defaultProfile.png';
                            }else{
                                $pic = $searchResult['profilePic'];
                            }
        
            ?>
                        <a href = "aParProfile.php?id=<?php echo $id ?>"><div class = "aUserProfile">
                            <div class = "profileInfo"><?php echo $name ?></div>
                            <div class = "profileInfo">
                                <div class = "image">
                                    <img src = "<?php echo $pic ?>" alt = "profile pic">
                                </div>
                            </div>
        
                        </div></a>
        
                <?php 
                        }
                    }else{
                        echo "No Match Result.";
                    }
                }else{
                    while($participantResult = mysqli_fetch_array($participantData))
                    {
                        
                        $id = $participantResult["participantId"];
                        $name = $participantResult["name"];

                        if ($participantResult['profilePic'] === null){
                            $pic = 'uploads/defaultProfile.png';
                        }else{
                            $pic = $participantResult['profilePic'];
                        }
                ?>
                    <a href = "aParProfile.php?id=<?php echo $id ?>"><div class = "aUserProfile">
                        <div class = "profileInfo"><?php echo $name ?></div>
                        <div class = "profileInfo">
                            <div class = "image">
                                <img src = "<?php echo $pic ?>" alt = "profile pic">
                            </div>
                        </div>

                    </div></a>

                <?php } 
                    }
                ?>
        </div>
        
    </body>
</html>
<?php require "footer.php" ?>
