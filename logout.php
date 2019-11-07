<?php
    ob_start();
    session_start();
    unset($_SESSION['lab']);
    header("Location: index.php");
?>