<?php
    session_start();
    $_SESSION['expire'] = 0;
    header('Location: http://172.16.217.90/static/login.html');
?>
