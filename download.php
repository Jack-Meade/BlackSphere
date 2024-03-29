<?php
    if(count($_POST['file']) > 1){
        //more than one file - zip together then download
        $zipname = 'blacksphere.zip';
        $zip = new ZipArchive();
        if($zip->open($zipname, false ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
            echo "nozip"; return;
		}
        $referer_address = str_replace("https://jmpi.ddns.net", "..", $_SERVER['HTTP_REFERER']);
        $referer_address = str_replace("search.php", "", $referer_address);
        foreach ($_POST['file'] as $key => $val)  {
            $filename = $referer_address.$val;
            if (!is_file($filename)){
                echo "File not found ".$filename."<br>";
            } else {
                $zip->addFile($filename, $val);
            }
        }
        if ($zip->close() === false) {
            echo "no write permissions"; return;
        }
        if (!is_file($zipname)) {
            header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
            echo 'File not found';
        } else if (!is_readable($zipname)) {
            header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            echo 'File not readable';
        } else {
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="'.$zipname.'"');
            header('Content-Length: '.filesize($_SERVER['DOCUMENT_ROOT'].'/bs/'.$zipname));
            ob_end_clean();
            flush();
            if(readfile($_SERVER['DOCUMENT_ROOT'].'/bs/'.$zipname)){
                unlink($_SERVER['DOCUMENT_ROOT'].'/bs/'.$zipname);
            }
            exit;
        }
    } elseif(count($_POST['file']) == 1)  {
        //only one file selected
        $referer_address = str_replace("https://jmpi.ddns.net", "..", $_SERVER['HTTP_REFERER']);
        $referer_address = str_replace("search.php", "", $referer_address);
        foreach ($_POST['file'] as $key => $val)  {
            $filename = $referer_address.$val;
        }
        //header("Content-type:application/pdf");
        header("Content-type: application/octet-stream");
        header("Content-Disposition:inline;filename=".basename($filename));
        header('Content-Length: '.filesize($filename));
        header("Cache-control: private"); //use this to open files directly
        readfile($filename);
    } else {
        header('Location: '.$_SERVER['HTTP_REFERER'].'');
    }
?>
