<?php
    session_start();
    if ($_SESSION['authenticated'] !== true) {
        header('Location: /bs/login.php');
	session_destroy();
    }
    require $_SERVER['DOCUMENT_ROOT']."/bs/body_builder.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BlackSphere | <?php
                if ($_SERVER['REQUEST_URI'] != "/bs/" && $_SERVER['REQUEST_URI'] != "/bs/?hidden")
                    { $dir_path = str_replace("/bs", "", $_SERVER['REQUEST_URI']); }
                else
                    { $dir_path = "/bs/"; }

                $dir_path = str_replace("?hidden", "", $dir_path);
                echo($dir_path);
            ?></title>
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

        <script src="/bs/sorttable.js" type='text/javascript'></script>
        <script src="/bs/requests.js" type='text/javascript'></script>
        <script src="/bs/validateCSRF.js" type='text/javascript'></script>
        <script src='/bs/dropzone.js' type='text/javascript'></script>
        <script src='/bs/dzOptions.js' type='text/javascript'></script>
    </head>

    <body>
        <div id="container">
            <img src="/bs/blackspherelogo.png"/>

            <div id="headerButtons">
                <div id="backForwardBtn">
                    <button type="button" class="btn btn-dark" onclick="window.location.href = './..'">&uarr;</button>
                </div>

                <form action="/bs/search.php" method="POST" id="searchForm" class="input-group">
                    <input type="text" class="form-control" name="search_bar" placeholder="Search.."/>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <div>
                    <button type="button" class="btn btn-danger" onclick="location.href='/bs/logout.php'">Log Out</button>
                </div>
            </div>

            <form id="dir_form" method='POST' action="/bs/download.php">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="5">
                                <?php echo($dir_path); ?>
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
                        <?php list($html, $atext, $ahref) = body_builder(); echo $html; ?>
                    </tbody>
                </table>

            </form>

            <div id="butt_div">
                <button form="dir_form" type="submit" class="btn btn-primary"> <i class="fas fa-download"></i> Download</button>
                <button type="button" data-target="#modalUpload" class="btn btn-primary" data-toggle="modal" ><i class="fas fa-upload"></i> Upload </button>
                <button type="button" data-target="#modalMount" class="btn btn-primary" data-toggle="modal" ><i class="fas fa-cloud-upload-alt"></i> Mount Folder </button>
                <button type="button" data-target="#modalmkdir" class="btn btn-primary" data-toggle="modal"><i class="fas fa-folder"></i> Make Folder </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="refresh()"><i class="fas fa-sync"></i> Refresh </button>
                <?php echo("<button type='button' class=\"btn btn-primary\" onclick= window.location.href='$ahref'> $atext hidden files</button>"); ?>
            </div>

            <!-- Modal for uploading a file-->
            <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUpload" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUploadTitle">Upload</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modalBody" id="dropzone">
                            <form action="https://jmpi.ddns.net/bs/uploads/" class="dropzone dz-clickable" id="myDropzone">
                                <p class="dz-message">Drop your files here, then click submit to  upload them</p>
                            </form>
                        </div>
                        <div class="modalFooter">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button form="myDropzone" type="button" id="submit-all" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of modal -->
            <!-- Modal for mounting a directory-->
            <div class="modal fade" id="modalMount" tabindex="-1" role="dialog" aria-labelledby="modalMount" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalMountTitle">Mount your folder to BlackSphere</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modalBody">
                        <form action="/bs/mounter.php" id="mountRequestForm" method="POST">
                            <div class="row">
                                <div class="col-ld-4 mb-3">
                                     <label for="sshusername">SSH Username: </label>
                                     <input id='sshusername' class="form-control" name="sshusername" type="text" placeholder="Username" >
                                </div>
                                 <div class="col-ld-4 mb-3">
                                     <label for="sship">IP Address: </label>
                                     <input id='sship' class="form-control" name="sship" type="text" placeholder="IP Address" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-ld-4 mb-3">
                                    <label for="sshpassword">SSH Password: </label>
                                    <input id='sshpassword' class="form-control" name="sshpassword" type="password" placeholder="Password" >
                                </div>
                                <div class="col-ld-4 mb-3">
                                    <label for="sshfolder">Folder To Mount: </label>
                                    <input id='sshfolder' class="form-control" name="sshfolder"   type="text"     placeholder="Folder" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="sshmname">Name of folder:</label>
                                    <input id='sshmname' class="form-control"  name="sshmname"    type="text"     placeholder="Name" >
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="modalFooter">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button form="mountRequestForm" type="submit" class="btn btn-primary">Mount Folder</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of modal -->
            <!-- Start of Modal For Making a Folder -->
            <div class="modal fade" id="modalmkdir" tabindex="-1" role="dialog" aria-labelledby="modalmkdir" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalmkdirTitle">New Folder</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modalBody">
                            <form id="modalmkdirForm" method='POST'>
                                <label for="sshmname">Folder name:</label>
                                <input id="folderName" class="form-control"name="folderName" type="text" placeholder="New Folder" default="new_folder"/>
                            </form>
                        </div>
                        <div class="modalFooter">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button form="modalmkdirForm" type="submit" class="btn btn-primary">Make Folder</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Modal for making a fodler -->



        </div>
        <script>
            mainVali();
            // setInterval(refresh, 5000); // Refresh the directory every 5 seconds

            $('#modalmkdirForm').on('submit', function (event) {
                event.preventDefault();
                var name = document.getElementById("folderName").value;
                makeFolder(name);
            });
        </script>
    </body>
</html>
