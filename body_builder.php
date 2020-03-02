<?php
    require $_SERVER['DOCUMENT_ROOT']."/bs/beautify.php";

    function gen_table_html($dir_array, $dir_path, $hide) {
        $num_entries=count($dir_array);

        for($i=0; $i < $num_entries; $i++) {

            // Decides if hidden files should be displayed, based on query above.
            if(substr("$dir_array[$i]", 0, 1)!=$hide) {

                // Resets Variables
                $favicon = "";
                $class = "file";

                // Gets File Names
                $name = $dir_array[$i];
                $namehref = $dir_array[$i];

                // Gets Date Modified
                $modtime = date("d-M-y | H:i", filemtime($dir_path.$dir_array[$i]));
                $timekey = date("YmdHis", filemtime($dir_path.$dir_array[$i]));


                // Separates directories, and performs operations on those directories
                if(is_dir($dir_path.$dir_array[$i])) {
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
                    $extn = pretty_ext(pathinfo($dir_array[$i], PATHINFO_EXTENSION));
                    $size = pretty_filesize($dir_path.$dir_array[$i]);
                    $sizekey = filesize($dir_path.$dir_array[$i]);
                }

                // Output
                $html = $html."
    <tr class='$class'>
        <td><input type='checkbox' class='form-check-input' value='$namehref' name='file[$i]'/></td>
        <td><a href='./$namehref'$favicon class='name'>$name</a></td>
        <td><a href='./$namehref'>$extn</a></td>
        <td sorttable_customkey='$sizekey'><a href='./$namehref'>$size</a></td>
        <td sorttable_customkey='$timekey'><a href='./$namehref'>$modtime</a></td>
    </tr>";
            }
        }
        return $html;
    }

    function body_builder() {
        if ($_POST['folder']) {
            $req_uri = $_POST['folder'];
        } else {
            $req_uri = $_SERVER['REQUEST_URI'];
        }

        // Checks to see if veiwing hidden files is enabled
        if($_SERVER['QUERY_STRING']=="hidden") {
            $hide="";
            $ahref="./";
            $atext="<i class=\"fas fa-eye-slash\"></i> Hide";
        } else {
            $hide=".";
            $ahref="./?hidden";
            $atext="<i class=\"fas fa-eye\"></i> Show";
        }

        // Opens directory, trimming URL to map onto directory structure
        if (strpos($req_uri, "/bs/") !== false) {
            $dir_path = str_replace("/bs", "../bs", $req_uri);
        }


        $dir_path = str_replace("?hidden", "", $dir_path);
        $requested_dir = opendir($dir_path);

        // Gets each entry
        while($entry_name=readdir($requested_dir)) {
            if (is_dir($dir_path.$entry_name)) { $dirs[]=$entry_name; }
            else                               { $files[]=$entry_name; }
        }

        // Sorts entries if they exist, if they don't then the other is set to be only array
        if (!empty($dirs))  { sort($dirs, SORT_NATURAL | SORT_FLAG_CASE); }
        else                { $dir_array = $files; }
        if (!empty($files)) { sort($files, SORT_NATURAL | SORT_FLAG_CASE); }
        else                { $dir_array = $dirs; }

        // In case both have entries, merge them
        if (!empty($dirs) && !empty($files)) { $dir_array = array_merge($dirs, $files); }

        closedir($requested_dir);


        $html = gen_table_html($dir_array, $dir_path, $hide);

        return array($html, $atext, $ahref);
    }
    $runFunction = $_POST['function'];
    if($runFunction === '1') {
        list($html, $atext, $ahref) = body_builder();
        echo json_encode($html);
    }
?>
