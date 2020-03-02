<?php
    $current_working_dir=$_POST['currentFolder'];
    $new_file_name = $_POST['folderName'];
    chdir($_SERVER['DOCUMENT_ROOT']);
    #chdir('/home/sshfs/webdir/');
    $fullPath = '.'.$current_working_dir.$new_file_name;
    mkdir($fullPath); # This will make a folder in the currect directory that the script is in by default!
    #echo "$current_working_dir";
    echo "$fullPath";
    #$_SERVER['HTTP_REFERER']
?>
