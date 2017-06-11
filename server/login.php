<?php
session_start();
$v1 = "user";
$v2 = "pass";
$username = $_POST['name'];
$password = $_POST['pwd'];
$hostname = '{mail.ntu.edu.tw:993/imap/ssl}INBOX';

#if already logged in session is not expired, just good
include 'islogin.php';
if ( islogin() === '{"success": 1}' ){
    echo '{"success": 1}';
    exit();
} elseif ($username == $v1 && $password == $v2) {
    $_SESSION['luser'] = $v1;
    $_SESSION['start'] = time(); // Taking now logged in time.
    // Ending a session in 30 minutes from the starting time.
    $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
    echo '{"success": 1}';
    exit();
} else {
    echo '{"success": 0}';
    exit();
}
?>
