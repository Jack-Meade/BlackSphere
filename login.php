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
        <link rel="shortcut icon" href="/test/images/favicon.png"/>
        <link rel="stylesheet" href="/test/style.css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    </head>

    <body>
        <div id="blacklogo">
            <img src="/test/blackspherelogo.png"/>
        </div>
        <div id="login_form">
            <form action="" method="POST" enctype=”multipart/form-data” class="form-inline">
                <input type="text" class="form-control" name="nkey" id="nkey" placeholder="Enter key here"/>
                <button type="submit" class="btn btn-secondary" ">Login</button>
            </form>
        </div>
    </body>
</html>');
    }

    if ($_SESSION['authenticated'] === true) {
        header('Location: /test/TopLevelDir/');
    } elseif (!empty($_POST)) {
        if ($_POST['nkey'] === $passwd) {
            $_SESSION['authenticated'] = true;
            header('Location: /test/TopLevelDir/');
        } else {
            gen_html();
        }
    } else {
        gen_html();
    }
?>
