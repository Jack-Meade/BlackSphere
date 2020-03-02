<?php
    require $_SERVER['DOCUMENT_ROOT']."/bs/body_builder.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BlackSphere | Search</title>
        <link rel="shortcut icon" href="/bs/images/favicon.png"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.css"> <!--Temporary -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <!-- End of bootstrap -->
        <link rel="stylesheet" href="/bs/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    </head>

    <body>
        <img src="/bs/blackspherelogo.png"/>
        <form id="dir_form" method='POST' action="/bs/download.php">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="5">
                            Here are some files we found:
                        </th>
                    </tr>
                </thead>
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Filename</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Date Modified</th>
                    </tr>
                </thead>

                <tbody id="directoryStructure">
                    <?php
                        $filename = $_POST['search_bar'];
                        exec("find TopLevelDir/ -name \"*$filename*\"", $paths, $return_var);

                        echo(gen_table_html($paths, "", ""));
                    ?>
                </tbody>
            </table>
        </form>
    </body>
</html>
