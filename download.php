<?php
// common vars
var_dump($_POST);

$file_path = $_SERVER['DOCUMENT_ROOT']."/users/2021/cjt3/public_html/";
if(count($_POST['file']) > 1){
    //more than one file - zip together then download
    $zipname = 'blackspehere'.date(strtotime("now")).'.zip';
    $zip = new ZipArchive();
    if ($zip->open($zipname, ZIPARCHIVE::CREATE )!==TRUE) {
        exit("cannot open <$zipname>\n");
    }
    foreach ($_POST['file'] as $key => $val)  {
        $files =  $val;
        $zip->addFile($file_path.$files,$files);
    }
    $zip->close();


    if (headers_sent()) {
        echo 'HTTP header already sent';
    } else {
        if (!is_file($zipname)) {
            header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
            echo 'File not found';
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
} elseif(count($_POST['file']) == 1)  {
    //only one file selected
    foreach ($_POST['items'] as $key => $val)  {
        $singlename =  $val;
    }

    $pdfname = $file_path. $singlename;
    //header("Content-type:application/pdf");
    header("Content-type: application/octet-stream");
    header("Content-Disposition:inline;filename='".basename($pdfname)."'");
    header('Content-Length: ' . filesize($pdfname));
    header("Cache-control: private"); //use this to open files directly
    readfile($pdfname);
    } else {

        echo 'no documents were selected. Please go back and select one or more documents';
    }
?>
