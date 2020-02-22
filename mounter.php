<?php
    $ip         = $_POST["ip"];
    $username   = $_POST["username"];
    $pass       = $_POST["pass"];
    $path       = $_POST["folder"];
    $mount      = $_POST["mname"];

    // $data = $ip." ".$username." ".$pass." ".$folder." ".$mname." ";
    // sshfs -o idmap=user $remote_user@$url:$ssh_path $local_mount -p 22
    exec("mkdir TopLevelDir/$mount");
    exec('echo '.$pass.' | sshfs -o idmap=user,password_stdin '.$username.'@'.$ip.':'.$path.' TopLevelDir/'.$mount.' -p 22 ', $output, $return_var);
    var_dump($output);
    echo "<br>";
    echo $return_var;
    // header('Location: '.$_SERVER['HTTP_REFERER'].'');
?>
