<?php
    session_start();
    if ($_SESSION['authenticated'] !== true) {
        header('Location: /bs/login.php');
	session_destroy();
    }
    require $_SERVER['DOCUMENT_ROOT']."/bs/beautify.php";
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
        <link rel="stylesheet" href="/bs/style.css">
        <link rel="stylesheet" href="/bs/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="/bs/sorttable.js"></script>
        <script src="/bs/requests.js"></script>
    </head>

    <body>
        <div id="container">
            <img src="/bs/blackspherelogo.png"/>
            <img src="/bs/meme.gif"/>
            <h1>Directory Contents of <?php echo($dir_path); ?></h1>
            <button type="button" onclick="history.back();">&larr;</button>
            <button type="button" onclick="history.forward();">&rarr;</button>
            <button onclick="location.href='/bs/logout.php'" type="button">Log Out</button>

            <form id="dir_form" method='POST' action="/bs/download.php">
                <table class="sortable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Filename</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Date Modified</th>
                        </tr>

                    </thead>
                    <tbody><?php
                            // Checks to see if veiwing hidden files is enabled
                            if($_SERVER['QUERY_STRING']=="hidden") {
                                $hide="";
                                $ahref="./";
                                $atext="Hide";
                            } else {
                                $hide=".";
                                $ahref="./?hidden";
                                $atext="Show";
                            }

                            // Opens directory, trimming URL to map onto directory structure
                            if (strpos($_SERVER['REQUEST_URI'], "/bs/") !== false) {
                                $dir_path = str_replace("/bs", "../bs", $_SERVER['REQUEST_URI']);
                            }


                            $dir_path = str_replace("?hidden", "", $dir_path);
                            $requested_dir = opendir($dir_path);

                            // Gets each entry
                            while($entryName=readdir($requested_dir)) {
                                if (is_dir($dir_path.$entryName)) { $dirs[]=$entryName; }
                                else                              { $files[]=$entryName; }
                            }

                            // Sorts entries if they exist, if they don't then the other is set to be only array
                            if (!empty($dirs))  { sort($dirs, SORT_NATURAL | SORT_FLAG_CASE); }
                            else                { $dirArray = $files; }
                            if (!empty($files)) { sort($files, SORT_NATURAL | SORT_FLAG_CASE); }
                            else                { $dirArray = $dirs; }

                            // In case both have entries, merge them
                            if (!empty($dirs) && !empty($files)) { $dirArray = array_merge($dirs, $files); }

                            closedir($requested_dir);
                            $num_entries=count($dirArray);

                            for($i=0; $i < $num_entries; $i++) {

                                // Decides if hidden files should be displayed, based on query above.
                                if(substr("$dirArray[$i]", 0, 1)!=$hide) {

                                    // Resets Variables
                                    $favicon = "";
                                    $class = "file";

                                    // Gets File Names
                                    $name = $dirArray[$i];
                                    $namehref = $dirArray[$i];

                                    // Gets Date Modified
                                    $modtime = date("d-M-y | H:i", filemtime($dir_path.$dirArray[$i]));
                                    $timekey = date("YmdHis", filemtime($dir_path.$dirArray[$i]));


                                    // Separates directories, and performs operations on those directories
                                    if(is_dir($dir_path.$dirArray[$i])) {
                                        $extn="&lt;Directory&gt;";
                                        $size="&lt;Directory&gt;";
                                        $sizekey="0";
                                        $class="dir";

                                        // Cleans up . and .. directories
                                        if($name == ".") {
                                            $name=". (Current Directory)";
                                            $extn="&lt;System Dir&gt;";
                                        } elseif ($name == "..") {
                                            $name=".. (Parent Directory)";
                                            $extn="&lt;System Dir&gt;";
                                        }
                                    }

                                    // File-only operations
                                    else {
                                        $extn = pretty_ext(pathinfo($dirArray[$i], PATHINFO_EXTENSION));
                                        $size = pretty_filesize($dir_path.$dirArray[$i]);
                                        $sizekey = filesize($dir_path.$dirArray[$i]);
                                    }

                                    // Output
                                    echo("
                        <tr class='$class'>
                            <td><input type='checkbox' value='$namehref' name='file[$i]'/></td>
                            <td><a href='./$namehref'$favicon class='name'>$name</a></td>
                            <td><a href='./$namehref'>$extn</a></td>
                            <td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
                            <td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
                        </tr>");
                                }
                            }
                        ?>

                    </tbody>
                </table>

            </form>
            <div id="butt_div">
                <button form="dir_form" type="submit" class="fabutton"> <i class="fas fa-download"></i> Download</button>
                <?php echo("<button type='button' class='fabutton' onclick= window.location.href='$ahref'><i class=\"fas fa-eye\"></i> $atext hidden files</button>"); ?>
            </div>

            <?php
                if(isset($_FILES['file_to_upload'])){
                    $file_name  = $_FILES['file_to_upload']['name'];
                    $file_size  = $_FILES['file_to_upload']['size'];
                    $file_tmp   = $_FILES['file_to_upload']['tmp_name'];
                    $file_type  = $_FILES['file_to_upload']['type'];
                    $file_ext   = strtolower(end(explode('.',$_FILES['file_to_upload']['name'])));

                    echo $_FILES[$file_name]['error'];
                    move_uploaded_file($file_tmp, "/var/www/html".$_SERVER['REQUEST_URI'].$file_name);
                }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                Select file to upload:
                <input type="file" name="file_to_upload"/>
                <input type="submit" value="Upload File" name="submit"/>
            </form>

<<<<<<< Updated upstream
            <form action="/bs/mounter.php" method="POST" id="mountRequestForm">
=======
            <form  id="mountRequestForm"> <!-- action="/sshfs/mounter.php" method="POST" -->
>>>>>>> Stashed changes
                <h1>Mount your folder to BlackSphere</h1>
                IP Address:         <input id='ip'       name="ip"       type="text"     placeholder="IP Address"><br />
                SSH Username:       <input id='username' name="username" type="text"     placeholder="Username"><br />
                SSH Password:       <input id='password' name="password" type="password" placeholder="Password"><br />
                Folder To Mount:    <input id='path'     name="path"     type="text"     placeholder="Path"><br />
                Mount Name:         <input id='mname'    name="mname"    type="text"     placeholder="Name"><br />
                <input type="submit" value="Mount Folder">
            </form>
        </div>
    </body>
</html>
