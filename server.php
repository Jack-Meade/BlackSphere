<?php
    session_start();
    if ($_SESSION['authenticated'] !== true) {
        header('Location: /sshfs/login.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BlackSphere | <?php
                if ($_SERVER['REQUEST_URI'] != "/sshfs/" && $_SERVER['REQUEST_URI'] != "/sshfs/?hidden")
                    { $dir_path = str_replace("/sshfs", "", $_SERVER['REQUEST_URI']); }
                else
                    { $dir_path = "/sshfs/"; }

                $dir_path = str_replace("?hidden", "", $dir_path);
                echo($dir_path);
            ?></title>
        <link rel="shortcut icon" href="/sshfs/images/favicon.png"/>
        <link rel="stylesheet" href="/sshfs/style.css">
        <script src="/sshfs/sorttable.js"></script>
        <script src="/sshfs/request.js"></script>
    </head>

    <body>
        <div id="container">
            <img src="/sshfs/blackspherelogo.png"/>
            <h1>Directory Contents of <?php echo($dir_path); ?></h1>

            <form method='POST' action="/sshfs/download.php">
                <table class="sortable">
                    <thead>
                        <tr>
                            <th>Marked for Download</th>
                            <th>Filename</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Date Modified</th>
                        </tr>
                    </thead>
                    <tbody><?php

                            // Adds pretty filesizes
                            function pretty_filesize($file) {
                                $size = filesize($file);
                                if     ($size < 1024)                              { $size = $size." bytes"; }
                                elseif (($size < 1048576)    && ($size > 1023))    { $size = round($size/1024, 1)." KiB"; }
                                elseif (($size < 1073741824) && ($size > 1048575)) { $size = round($size/1048576, 1)." MiB"; }
                                else                                               { $size = round($size/1073741824, 1)." GiB";}
                                return $size;
                            }

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
                            if (strpos($_SERVER['REQUEST_URI'], "/sshfs/") !== false) {
                                $dir_path = str_replace("/sshfs", "../sshfs", $_SERVER['REQUEST_URI']);
                            }


                            $dir_path = str_replace("?hidden", "", $dir_path);
                            $requested_dir = opendir($dir_path);

                            // Gets each entry
                            while($entryName=readdir($requested_dir)) {
                                if (is_dir($dir_path.$entryName)) { $dirs[]=$entryName; }
                                else                             { $files[]=$entryName; }
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
                                        $extn=pathinfo($dirArray[$i], PATHINFO_EXTENSION);
                                        switch ($extn){
                                            // Images
                                            case "png":         $extn="PNG Image"; break;
                                            case "jpg":
                                            case "jpeg":        $extn="JPEG Image"; break;
                                            case "svg":         $extn="SVG Image"; break;
                                            case "gif":         $extn="GIF Image"; break;
                                            case "ico":         $extn="Windows Icon"; break;

                                            # Languages
                                            case "py":          $extn="Python Source Code"; break;
                                            case "java":        $extn="Java Source Code"; break;
                                            case "class":       $extn="Java Bytecode"; break;
                                            case "c":           $extn="C Source Code"; break;
                                            case "cpp":         $extn="C++ Source Code"; break;
                                            case "h":           $extn="Header File"; break;
                                            case "ino":         $extn="Arduino Source Code"; break;
                                            case "asm":         $extn="Assembly Language"; break;
                                            case "sh":          $extn="Shell Script"; break;
                                            case "htm":
                                            case "html":
                                            case "xhtml":
                                            case "shtml":       $extn="HTML Source Code"; break;
                                            case "php":         $extn="PHP Source Code"; break;
                                            case "js":          $extn="Javascript Source Code"; break;
                                            case "css":         $extn="Stylesheet"; break;

                                            # Documents
                                            case "pdf":         $extn="PDF"; break;
                                            case "csv":
                                            case "xls":
                                            case "xlsx":        $extn="Spreadsheet"; break;
                                            case "doc":
                                            case "docx":        $extn="Microsoft Word Document"; break;
                                            case "odt":         $extn="OpenDocument Text"; break;
                                            case "ott":         $extn="OpenDocument Text Template"; break;
                                            case "odg":         $extn="OpenDocument Graphic"; break;
                                            case "md":          $extn="Markdown Document"; break;
                                            case "pcap":
                                            case "pcapng":      $extn="Wireshark Capture"; break;
                                            case "lgi":         $extn="Digital Logic Diagram"; break;

                                            # Archives
                                            case "zip":
                                            case "tar":
                                            case "tgz":
                                            case "gz":          $extn="Archive"; break;
                                            case "7z":          $extn="7z Archive"; break;
                                            case "jar":         $extn="Java Archive"; break;

                                            # Misc
                                            case "txt":         $extn="Text File"; break;
                                            case "log":         $extn="Log File"; break;
                                            case "exe":         $extn="Windows Executable"; break;

                                            default: if     ($extn != "")                       { $extn = strtoupper($extn)." File"; }
                                                     elseif (strtolower($name) == "makefile")   { $extn = "Makefile"; }
                                                     else                                       { $extn = "Unknown"; }
                                        }

                                        // Gets and cleans up file size
                                        $size = pretty_filesize($dir_path.$dirArray[$i]);
                                        $sizekey = filesize($dir_path.$dirArray[$i]);
                                    }

                                    // Output
                                    echo("
                        <tr class='$class'>
                            <td><input type='checkbox' value='$dir_path$namehref' name='file[$i]'/></td>
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
                <input type='submit' value='Download Selected Files'>
            </form>

            <h2><?php echo("<a href='$ahref'>$atext hidden files</a>"); ?></h2>

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

            <form action="https://jmpi.ddns.net/mounter.sh" method="POST" id="mountRequestForm">
            IP Address<input id='ip' type="text" placeholder="ip Address"><br />
            SSH Username<input id='username' type="text" placeholder="username"><br />
            SSH Password<input id='pass' type="text" placeholder="password"><br />
            Folder To Mount<input id='folder' type="text" placeholder="password"><br />
            <input type="submit" value="Mount Folder" class="tiny button">
            </form>

        </div>
    </body>
</html>
