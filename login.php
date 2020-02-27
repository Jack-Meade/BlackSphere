<?php
    session_start();
    $passwd = file_get_contents("passwd.txt");
    $passwd = preg_replace('/\s/', '', $passwd);

    function gen_html() {
        echo('<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BlackSphere Login</title>
        <link rel="shortcut icon" href="/bs/images/favicon.png"/>
        <link rel="stylesheet" href="/bs/style.css"/>
    </head>

    <body>
        <img src="/bs/blackspherelogo.png"/>
        <form action="" method="POST" enctype=”multipart/form-data”>
            <label for="nkey">Login:</label>
            <input type="text" name="nkey" id="nkey" placeholder="Enter key here"/>
            <input type="submit" value="Login"/>
        </form>
    </body>
</html>');
    }

    if ($_SESSION['authenticated'] === true) {
        header('Location: /bs/TopLevelDir/');
    } elseif (!empty($_POST)) {
        if ($_POST['nkey'] === $passwd) {
            $_SESSION['authenticated'] = true;
            header('Location: /bs/TopLevelDir/');
        } else {
            gen_html();
            var_dump($_POST['nkey']);
            echo "<br>";
            var_dump($passwd);
        }
    } else {
        gen_html();
    }
?>
