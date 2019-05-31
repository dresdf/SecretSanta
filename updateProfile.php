<?php

include 'dbUtil.php';

//get user details
$nume = $_COOKIE['nume'];
$prenume = $_COOKIE['prenume'];

//get current password in DB
$oldUsername = $_COOKIE['username'];
$oldPassword = $_COOKIE['password'];

//get password from form
$newUsername = $_POST['newUsername'];
$newPassword = $_POST['newPassword'];

//wishlist
$oldWishlist = $_COOKIE['wishlist'];
$newWishlist = $_POST['newWishlist'];


if (!empty($_POST['update'])) {
//change username
    if ($oldUsername !== $newUsername) {
        $sql = "UPDATE $tableName SET Username = '$newUsername' WHERE Prenume = '$prenume' and Nume = '$nume'";
        mysqli_query($con, $sql);
        setcookie('username', $newUsername);
    }

//change password
    if ($oldPassword !== $newPassword) {
        $sql = "UPDATE $tableName SET Parola = '$newPassword' WHERE Prenume = '$prenume' and Nume = '$nume'";
        mysqli_query($con, $sql);
        setcookie('password', $newPassword, $duration);
    }
} else if (!empty($_POST['saveWishlist'])) {
    if ($oldWishlist !== $newWishlist) {
        $sql = "UPDATE $tableName SET Wishlist = '$newWishlist' WHERE Prenume = '$prenume' and Nume = '$nume'";
        mysqli_query($con, $sql);
        setcookie('wishlist', $newWishlist, $duration);
    }
}
?>