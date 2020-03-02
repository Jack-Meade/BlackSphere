<?php
    $username = $_POST["sshusername"];
    $ip       = $_POST["sship"];
    $path     = $_POST["sshfolder"];
    $mount    = $_POST["sshmname"];
    $pass     = $_POST["sshpassword"];

    exec("mkdir TopLevelDir/$mount");
    chmod("TopLevelDir/$mount", 0777);
    exec("./mounter.sh $username $ip $path $mount $pass 2>&1 &", $output, $return_var);
    if ($return_var !== 0) {
        for ($i=0; $i < 20; $i++) {
            echo $output[$i]; echo "<br>";
        }
    } else {
        header('Location: '.$_SERVER['HTTP_REFERER'].'');
    }

?>
