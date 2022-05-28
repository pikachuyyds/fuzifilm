<?php
include("conn.php");

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
            <?php //require("header.php") ?>
            <div class="title">
                CHANGE PASSWORD
            </div>
            <div class="data">
                <div>
                    <form method="post">
                        <p>CURRENT PASSWORD</p>
                        <input class = "pwd" type="password" name="oldPwd" id="oldPwd" pattern=".{8,}" title="at least 8 characters" onkeyup="passwordValidation('oldPwd')" readonly></input>
                        <script>document.getElementById("oldPwd").value = <?php echo $oldPwd ?>;</script>
                        <i class="far fa-eye" id="togglePassword" onclick = "showOld()"></i>
                        <br>

                        <p>NEW PASSWORD</p>
                        <input class = "pwd" type="password" placeholder="minimum 8 character" name="newPwd" id="newPwd" pattern=".{8,}" title="at least 8 characters" onkeyup="passwordValidation('newPwd')" required></input>
                        <i class="far fa-eye" id="togglePassword" onclick = "showNew()"></i>
                        <br>

                        <p>CONFIRM NEW PASSWORD</p>
                        <input class = "pwd" type="password" placeholder="Confirm password" name="confirmPwd" id="confirmPwd" pattern=".{8,}" title="at least 8 characters" onkeyup="confirmPasswordValidation('newPwd', 'confirmPwd')" required></input>
                        <i class="far fa-eye" id="togglePassword" onclick = "showConfirm()"></i>
                        <br><br><br><br>
                        
                        <input type="submit" name="submit" value="SUBMIT" class="btn">
                        <input type="submit" value="BACK" class="btn" onclick="window.location.href = 'userProfile.php'">
                    </form>

                    <script>
                        const togglePassword = document.querySelector('#togglePassword');
                        const oldPwd = document.getElementById("oldPwd");
                        const newPwd = document.getElementById("newPwd");
                        const confirmPwd = document.getElementById("confirmPwd");
                        
                        function showOld(){
                            // toggle the type attribute
                            const type = oldPwd.getAttribute('type') === 'password' ? 'text' : 'password';
                            oldPwd.setAttribute('type', type);
                            // toggle the eye slash icon
                            togglePassword.classList.toggle('fa-eye-slash');
                        }

                        function showNew(){
                            const type = newPwd.getAttribute('type') === 'password' ? 'text' : 'password';
                            newPwd.setAttribute('type', type);
                            togglePassword.classList.toggle('fa-eye-slash');
                        }

                        function showConfirm(){
                            const type = confirmPwd.getAttribute('type') === 'password' ? 'text' : 'password';
                            confirmPwd.setAttribute('type', type);
                            togglePassword.classList.toggle('fa-eye-slash');
                        }
                    </script>
                </div>
            </div>
            <?php //require("footer.php") ?>
        </body>
    </html>

<?php

    if(isset($_POST['submit'])){
        $vldt = str_replace("'","",$_POST['newPwd']);

                if ($vldt === $_POST['newPwd']) {
                    $validations = true;
                } else {
                    echo "<script>document.getElementById('pwdvalidation').style.display = 'inline-block';</script>";
                    $validations = false;
                }
        if ($validations === true) {
            // original password confirmation
            if ($_POST['newPwd'] == $_POST['oldPwd']){
                echo "<script>alert('Original Password invalid');</script>";
                $originalPwdValidation = false;
            } else {
                $originalPwdValidation = true;
            }

            // password confirmation
            if($_POST['newPwd'] != $_POST['confirmPwd']){
                echo "<script>alert('Wrong confirm password');</script>";
                $confirmPwdValidation = false;
            } else if ($_POST['newPwd'] == $_POST['confirmPwd']){
                $confirmPwdValidation = true;
            }

            if ($confirmPwdValidation === true && $originalPwdValidation === true) {
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