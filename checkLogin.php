<?php
include 'dbUtil.php';

// username and password sent from form 
$myusername = stripslashes($_POST['myusername']);
$mypassword = stripslashes($_POST['mypassword']);
$myusername = mysqli_real_escape_string($con, $myusername);
$mypassword = mysqli_real_escape_string($con, $mypassword);

$sql = "SELECT * FROM $tableName WHERE Username='$myusername' and Parola='$mypassword'";
$result = mysqli_query($con, $sql);


// Mysql_num_row is counting table row
$count = mysqli_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if ($count == 1) {

// Register cookie for "remember me" feature
    $year = time() + 31536000;
    if ($_POST['remember']) {
        //Register username and password for "remember me" feature
        setcookie('remember_user', $_POST['myusername'], $year);
        setcookie('remember_password', $_POST['mypassword'], $year);
    } elseif (!$_POST['remember']) {
        //clear cookies if "remember" is unchecked
        if (isset($_COOKIE['remember_user'])) {
            $past = time() - 100;
            setcookie(remember_user, gone, $past);
        }
        if (isset($_COOKIE['remember_password'])) {
            $past = time() - 100;
            setcookie(remember_password, gone, $past);
        }
    }


    //store user info in cookies for 24 hours
    $duration = time() + 86400;
    $row = mysqli_fetch_array($result, MYSQLI_NUM);
    setcookie('nume', $row[2], $duration);
    setcookie('prenume', $row[1], $duration);
    setcookie('profilepic', $row[5], $duration);
    setcookie('friend', $row[7], $duration);
    setcookie('username', $row[3], $duration);
    setcookie('password', $row[4], $duration);
    setcookie('wishlist', $row[6], $duration);

    //set a session to keep user logged in
    //set session content based on what the user's rank is
    session_start();
    if($row[1]==="Admin") {
        $_SESSION['login'] = "admin";
    } else {
        $_SESSION['login'] = "user";
    }


    //redirect user to main page
    header("location:main.php");
} else {
    //clear form and delete cookies
    if (isset($_COOKIE['remember_user'])) {
        $past = time() - 100;
        setcookie(remember_user, gone, $past);
    }
    if (isset($_COOKIE['remember_password'])) {
        $past = time() - 100;
        setcookie(remember_password, gone, $past);
    }

    header("location:index.php");
}
?>