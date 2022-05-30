<?php
require "conn.php";
require "header.php";

if (isset($_SESSION['loginId'])){
// to determine participant or organiser or admin
    $userType = $_SESSION['userType'];
    $userData = mysqli_query($con, "SELECT * FROM login WHERE loginId = '$_SESSION[loginId]' AND userType = '$userType'  ");
    $userResult = mysqli_fetch_array($userData);

    $oldPwd = $userResult["loginPassword"];
}
?>
<!DOCTYPE html>
    <html lang = en>
        <head>
            <title>Fuzifilm | Change Password</title>
            <link href = "css/changePwd.css" rel = "stylesheet" type = "text/css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        </head>
        <body>
            <div class="title">
                CHANGE PASSWORD
            </div>
            <div class="data">
                <div>
                    <form method="post">
                        <p>CURRENT PASSWORD</p>
                        <input class = "pwd" type="password" name="oldPwd" id="oldPwd" pattern=".{8,}" title="at least 8 characters" onkeyup="passwordValidation('oldPwd')" required></input>
                        <i class="far fa-eye" id="toggleOld" onclick = "showOld()"></i>
                        <br>

                        <p>NEW PASSWORD</p>
                        <input class = "pwd" type="password" placeholder="minimum 8 character" name="newPwd" id="newPwd" pattern=".{8,}" title="at least 8 characters" onkeyup="passwordValidation('newPwd')" required></input>
                        <i class="far fa-eye" id="toggleNew" onclick = "showNew()"></i>
                        <br>

                        <p>CONFIRM NEW PASSWORD</p>
                        <input class = "pwd" type="password" placeholder="Confirm password" name="confirmPwd" id="confirmPwd" pattern=".{8,}" title="at least 8 characters" onkeyup="confirmPasswordValidation('newPwd', 'confirmPwd')" required></input>
                        <i class="far fa-eye" id="toggleConfirm" onclick = "showConfirm()"></i>
                        <br><br><br><br>
                        
                        <input type="submit" name="submit" value="SUBMIT" class="btn">
                        <input type="submit" value="BACK" class="btn" onclick="window.location.href = 'userProfile.php'">
                    </form>

                    <script>
                        const oldPwd = document.getElementById("oldPwd");
                        const newPwd = document.getElementById("newPwd");
                        const confirmPwd = document.getElementById("confirmPwd");
                        
                        function showOld(){
                            // toggle the type attribute
                            const type = oldPwd.getAttribute('type') === 'password' ? 'text' : 'password';
                            oldPwd.setAttribute('type', type);
                            const togglePassword = document.querySelector('#toggleOld').classList;
                            // toggle the eye slash icon
                            togglePassword.toggle('fa-eye-slash');
                        }

                        function showNew(){
                            const type = newPwd.getAttribute('type') === 'password' ? 'text' : 'password';
                            newPwd.setAttribute('type', type);
                            const togglePassword = document.querySelector('#toggleNew').classList;
                            togglePassword.toggle('fa-eye-slash');
                        }

                        function showConfirm(){
                            const type = confirmPwd.getAttribute('type') === 'password' ? 'text' : 'password';
                            confirmPwd.setAttribute('type', type);
                            const togglePassword = document.querySelector('#toggleConfirm').classList;
                            togglePassword.toggle('fa-eye-slash');
                        }
                    </script>
                </div>
            </div>
        </body>
    </html>
 <?php require "footer.php" ?>
<?php

    if(isset($_POST['submit'])){
        $vldt = str_replace("'","",$_POST['newPwd']);

                if ($vldt === $_POST['newPwd']) {
                    $validations = true;
                } else {
                    $validations = false;
                }

        if ($validations === true) {

            //original password confirmation
            if ($oldPwd != $_POST['oldPwd']){
                echo "<script>alert('Original Password Invalid');</script>";
                $originalPwdValidation = false;
            } else {
                $originalPwdValidation = true;
            }

            //new password confirmation
            if ($_POST['newPwd'] == $_POST['oldPwd']){
                echo "<script>alert('Same with Original Password');</script>";
                $newPwdValidation = false;
            } else {
                $newPwdValidation = true;
            }

            // password confirmation
            if($_POST['newPwd'] != $_POST['confirmPwd']){
                echo "<script>alert('Wrong Confirm Password');</script>";
                $confirmPwdValidation = false;
            } else{
                $confirmPwdValidation = true;
            }

            if ($confirmPwdValidation === true && $originalPwdValidation === true && $newPwdValidation === true) {
                $sql_changePwd = "UPDATE login SET 
                                loginPassword = '$_POST[newPwd]'
                                WHERE loginId = '$_SESSION[loginId]' AND userType = '$userType'  ";

                if(!mysqli_query($con, $sql_changePwd)){
                    die('error'.mysqli_error($con));
                }else{
                    echo "<script>alert('Password amended');
                    window.location.href = 'userProfile.php';
                    </script>";
                }
            }
            mysqli_close($con);
        }
    }
?>