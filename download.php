<?php
    // common vars
    // var_dump($_POST);
    //$dir_path = $_SERVER['REQUEST_URI'];
    if(count($_POST['file']) > 1){
        //more than one file - zip together then download
        $zipname = 'blacksphere.zip';
        $zip = new ZipArchive();
        $res = $zip->open($zipname, ZipArchive::CREATE);
        if ($res !== TRUE) {
            exit('Cannot open file:'.$zipname);
        }
        foreach ($_POST['file'] as $key => $val)  {
            $zip->addFile($val, basename($val));
        }
        // echo var_dump($zip);
        echo "numfiles: " . $zip->numFiles . "\n";
        echo "status:" . $zip->status . "\n";
        $zip->close();
        echo var_dump(pathinfo($zipname));
        if (headers_sent()) {
        } else {
            if (!is_file($zipname)) {
                header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
                echo'File not found';
            } else if (!is_readable($zipname)) {
                header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
                echo 'File not readable';
            } else {
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename='.$zipname);
                header('Pragma: no-cache');
                header('Expires: 0');
                readfile($zipname);
                flush();
                if (readfile($zipname)){
                    unlink($zipname);
                }
                exit;
            }
        }
        echo count($_POST['file']);
    } elseif(count($_POST['file']) == 1)  {
        //only one file selected
        foreach ($_POST['file'] as $key => $val)  {
            $filename = $val;
        }
        //header("Content-type:application/pdf");
        header("Content-type: application/octet-stream");
        header("Content-Disposition:inline;filename=".basename($filename));
        header('Content-Length: ' . filesize($filename));
        header("Cache-control: private"); //use this to open files directly
        readfile($filename);
    } else {
        echo count($_POST['file']);
        echo 'no documents were selected. Please go back and select one or more documents';
    }
?>
