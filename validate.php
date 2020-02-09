<?php
    $passwd = 'asd';
    $login_page = '/sshfs/login.html';
    $explorer_main_page = '/sshfs/TopLevelDir/';

    if (isset($_POST['nkey'])) {
        if ($_POST['nkey'] === $passwd) {
            header("Location: $explorer_main_page");
        } else {
            echo("Unrecognised key, redirecting you back to login...");
            header("refresh:3;url=$login_page" );
        }
    } else {
        header("Location: $login_page");
    }
?>
