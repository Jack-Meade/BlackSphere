<?php
    $current_working_dir=$_POST['currentFolder'];
    $new_file_name = $_POST['folderName'];
    $baseDir = '/bs/TopLevelDir';
    $fullPath = $baseDir.'/'.$current_working_dir;
    mkdir($fullPath); # This will make a folder in the currect directory that the script is in by default!
    
?>
