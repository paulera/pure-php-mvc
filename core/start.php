<?php

if (file_exists(DIR_APP . DS . "includes.php")) {
    include_once DIR_APP . DS . "includes.php";
}

include_once DIR_CORE . DS . "autoloader.php";

// ----------------------------------------------------------------------
// including the routers will make the request to be processed by
// the right controller:

if (file_exists(DIR_APP . DS . "routes.php")) {
    include_once DIR_APP . DS . "routes.php";
}
require_once DIR_CORE . DS . "autorouter.php";

// ----------------------------------------------------------------------
// Route still not found. Maybe looking for a file relative to the root?
// it is important to have on .htaccess the mime types definition set
// see: http://www.htaccess-guide.com/adding-mime-types/

// TODO: implement the logic to go get files (this will work for assets and etc but must avoid directory traversal
$pathInfo = $_SERVER['PATH_INFO'];
$pathInfo = str_replace("..", "", $pathInfo);
$file = DIR_PUBLIC . $pathInfo;
if (file_exists($file)) {
    
    // mime_content_type_2 is an internal function.ss
    $mimeType = mime_content_type_2($file);
    
    header("Content-Type: ".$mimeType);
    readfile($file);
    die();
}

function mime_content_type_2($file) {
    $extension = strtolower(end(explode(".", $file)));
    switch ($extension) {
        case 'ecma': return 'application/ecmascript';
        case 'epub': return 'application/epub+zip';
        case 'woff': return 'application/font-woff';
        case 'js': return 'application/javascript';
        case 'json': return 'application/json';
        case 'jsonml': return 'application/jsonml+json';
        case 'doc': case 'dot': return 'application/msword';
        case 'bin': case 'dms': case 'lrf': case 'mar': case 'so': case 'dist': case 'distz': case 'pkg': case 'bpk': case 'dump': case 'elc': case 'deploy': return 'application/octet-stream';
        case 'rss': return 'application/rss+xml';
        case 'rtf': return 'application/rtf';
        case 'apk': return 'application/vnd.android.package-archive';
        case 'xls': case 'xlm': case 'xla': case 'xlc': case 'xlt': case 'xlw': return 'application/vnd.ms-excel';
        case 'xlsm': return 'application/vnd.ms-excel.sheet.macroenabled.12';
        case 'ppt': case 'pps': case 'pot': return 'application/vnd.ms-powerpoint';
        case 'nbp': return 'application/vnd.wolfram.player';
        case 'wsdl': return 'application/wsdl+xml';
        case '7z': return 'application/x-7z-compressed';
        case 'gnumeric': return 'application/x-gnumeric';
        case 'exe': case 'dll': case 'com': case 'bat': case 'msi': return 'application/x-msdownload';
        case 'sql': return 'application/x-sql';
        case 'der': case 'crt': return 'application/x-x509-ca-cert';
        case 'xaml': return 'application/xaml+xml';
        case 'xhtml': case 'xht': return 'application/xhtml+xml';
        case 'xml': case 'xsl': return 'application/xml';
        case 'dtd': return 'application/xml-dtd';
        case 'zip': return 'application/zip';
        case 'mpga': case 'mp2': case 'mp2a': case 'mp3': case 'm2a': case 'm3a': return 'audio/mpeg';
        case 'oga': case 'ogg': case 'spx': return 'audio/ogg';
        case 'wma': return 'audio/x-ms-wma';
        case 'wav': return 'audio/x-wav';
        case 'bmp': return 'image/bmp';
        case 'gif': return 'image/gif';
        case 'jpeg': case 'jpg': case 'jpe': return 'image/jpeg';
        case 'png': return 'image/png';
        case 'svg': case 'svgz': return 'image/svg+xml';
        case 'tiff': case 'tif': return 'image/tiff';
        case 'psd': return 'image/vnd.adobe.photoshop';
        case 'dwg': return 'image/vnd.dwg';
        case 'ico': return 'image/x-icon';
        case 'css': case 'scss': case 'sass': return 'text/css';
        case 'csv': return 'text/csv';
        case 'html': case 'htm': return 'text/html';
        case 'txt': case 'text': case 'conf': case 'def': case 'list': case 'log': case 'in': return 'text/plain';
        case 'vcard': return 'text/vcard';
        case '3gp': return 'video/3gpp';
        case 'mp4': case 'mp4v': case 'mpg4': return 'video/mp4';
        case 'ogv': return 'video/ogg';
        case 'qt': case 'mov': return 'video/quicktime';
        case 'webm': return 'video/webm';
        case 'flv': return 'video/x-flv';
        case 'vob': return 'video/x-ms-vob';
        case 'avi': return 'video/x-msvideo';
        case 'pdf': return 'application/pdf';
    }
    return mime_content_type($file);
}

// If got this far without finding a route, it is a 404 Not Found.
View::error(404);