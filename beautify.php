<?php
    function pretty_filesize($file) {
        $size = filesize($file);
        if     ($size < 1024)                              { $size = $size." bytes"; }
        elseif (($size < 1048576)    && ($size > 1023))    { $size = round($size/1024, 1)." KiB"; }
        elseif (($size < 1073741824) && ($size > 1048575)) { $size = round($size/1048576, 1)." MiB"; }
        else                                               { $size = round($size/1073741824, 1)." GiB";}
        return $size;
    }
    
    function pretty_ext($extn){
        switch ($extn){
            // Images
            case "png":         return "PNG Image";
            case "jpg":
            case "jpeg":        return "JPEG Image";
            case "svg":         return "SVG Image";
            case "gif":         return "GIF Image";
            case "ico":         return "Windows Icon";

            # Languages
            case "py":          return "Python Source Code";
            case "java":        return "Java Source Code";
            case "class":       return "Java Bytecode";
            case "c":           return "C Source Code";
            case "cpp":         return "C++ Source Code";
            case "h":           return "Header File";
            case "ino":         return "Arduino Source Code";
            case "asm":         return "Assembly Language";
            case "sh":          return "Shell Script";
            case "htm":
            case "html":
            case "xhtml":
            case "shtml":       return "HTML Source Code";
            case "php":         return "PHP Source Code";
            case "js":          return "Javascript Source Code";
            case "css":         return "Stylesheet";

            # Documents
            case "pdf":         return "PDF";
            case "csv":
            case "xls":
            case "xlsx":        return "Spreadsheet";
            case "doc":
            case "docx":        return "Microsoft Word Document";
            case "odt":         return "OpenDocument Text";
            case "ott":         return "OpenDocument Text Template";
            case "odg":         return "OpenDocument Graphic";
            case "md":          return "Markdown Document";
            case "pcap":
            case "pcapng":      return "Wireshark Capture";
            case "lgi":         return "Digital Logic Diagram";

            # Archives
            case "zip":
            case "tar":
            case "tgz":
            case "gz":          return "Archive";
            case "7z":          return "7z Archive";
            case "jar":         return "Java Archive";

            # Misc
            case "txt":         return "Text File";
            case "log":         return "Log File";
            case "exe":         return "Windows Executable";

            default: if     ($extn != "")                       { return strtoupper($extn)." File"; }
                     elseif (strtolower($name) == "makefile")   { return "Makefile"; }
                     else                                       { return "Unknown"; }
        }
    }
?>
