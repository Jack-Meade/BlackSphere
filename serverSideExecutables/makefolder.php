<?php
    $current_working_dir=$_POST['cwd'];
    $baseDir = '../TopLevelDir';
    $fullPath = $baseDir+'/'+$current_working_dir;
    mkdir($fullPath); # This will make a folder in the currect directory that the script is in by default!
?>