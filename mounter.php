<?php
    $username   = $_POST["username"];
    $ip         = $_POST["ip"];
    $path       = $_POST["folder"];
    $mount      = $_POST["mname"];
    $pass       = $_POST["pass"];

    exec("mkdir TopLevelDir/$mount");
    exec("./mounter.sh $username $ip $path $mount $pass 2>&1 &");
    header('Location: '.$_SERVER['HTTP_REFERER'].'');
?>