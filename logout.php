<?php
    session_start();
    session_destroy();
    header("Location:/bs/login.php");
?>
