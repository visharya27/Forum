<?php
$showError = "false";
if($_SERVER['REQUEST_METHOD']=="POST")
{
    include '_dbconnect.php';

    $userEmail = $_POST['signupEmail'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    $existSql = "SELECT * FROM `users` WHERE user_email= '$userEmail'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);

    if($numRows>0)
    {
        $showError = "User with this Email already exists";
    }
    else
    {
        if($pass==$cpass)
        {
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$userEmail', '$hash', current_timestamp());";
            $result = mysqli_query($conn,$sql);
            if($result)
            {
                $showAlert = true;
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else
        {
            $showError = "Password doesn't match";
        }
    }

    
    header("Location: /forum/index.php?signupsuccess=false&error=$showError");
}
?>
