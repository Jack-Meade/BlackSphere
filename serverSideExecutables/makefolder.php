<?php
    $current_working_dir=$_POST['currentFolder'];
    $new_file_name = $_POST['folderName'];
    $var = $_SERVER['DOCUMENT_ROOT'];
    chdir($var.'/bs');
    $fullPath = '.'.$current_working_dir.$new_file_name;
    mkdir($fullPath); # This will make a folder in the currect directory that the script is in by default!
    #echo "$current_working_dir";
?>
