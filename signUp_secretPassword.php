<?php 
    require "conn.php";
    session_start();
    
    $loginId = $_SESSION['loginId'];

    if (isset($_SESSION['userType']))
    {
        $user = $_SESSION['userType'];
    }
    else
    {
        die("page unavailable");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images\favicon.ico">
    <link rel="stylesheet" href="css\login_signUp.css">
    <link rel="stylesheet" href="css\login.css">
    <script src="js\header.js"></script>
    <title>sign up</title>
</head>
<body>
    <!-------------------------------------------------------- header -------------------------------------------------------->
    <div class="naviBar_main" id="header">
        <div class="toggler_container"></div>
    </div>
    
    <!-------------------------------------------------------- sign up interface -------------------------------------------------------->            
    <div class="signUpMain">
        <div class="form">
        <div class="title">Secret Question</div><br>
        <div style="width: 80%; font-size: 12px"> * please dont leave this page <br><br> You'll thank this when you forget your password</div><br>
        <form method="post">

            <label for="question">Question</label><br>
            <select class="dropdownbox" name="question">
                <option value="What is the name of your best friend from childhood?">What is the name of your best friend from childhood?</option> 
                <option value="What is your first job?">What is your first job?</option>
                <option value="What is the favourite place that you love the most?">What is the favourite place that you love the most?</option>
            </select>

            <label for="answer">Your answer</label><br>
            <input type="text" placeholder="answer" name="answer" id="answer" pattern="[A-Za-z ]{1,50}" required></input><br>

            <input type="submit" name="submit" value="submit">
        </form>
        </div>
    </div>
    <div class="someHeight"></div>
</body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        $sqlUpdate = "UPDATE login SET 
        secretQuestion = '$_POST[question]',
        answer = '$_POST[answer]'
        WHERE loginId  = '$loginId';";
        
        if(!mysqli_query($con, $sqlUpdate))
        {
            die('error'.mysqli_error($con));
        }
        else
        {
            echo "<script>
            window.location.href = 'home.php';
            </script>";
        }
        
        mysqli_close($con);
    }
?>