<?php
    session_start();
    $key = 'asd';

    function gen_html() {
        echo('<!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>BlackSphere Login</title>
                <link rel="shortcut icon" href="/sshfs/images/favicon.png"/>
                <link rel="stylesheet" href="/sshfs/style.css"/>
            </head>

            <body>
                <img src="/sshfs/blackspherelogo.png"/>
                <form action="" method="POST" enctype=”multipart/form-data”>
                    <label for="nkey">Login:</label>
                    <input type="text" name="nkey" id="nkey" placeholder="Enter key here"/>
                    <input type="submit" value="Login"/>
                </form>
            </body>
        </html>');
    }

    if ($_SESSION['authenticated'] === true) {
        header('Location: /sshfs/TopLevelDir/');
    } elseif (!empty($_POST)) {
        if ($_POST['nkey'] === $key) {
            $_SESSION['authenticated'] = true;
            header('Location: /sshfs/TopLevelDir/');
        } else {
            gen_html();
        }
    } else {
        gen_html();
    }
?>
