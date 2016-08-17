<?php
require_once ".././commonlib.php";
$file_name = $DEFAULT_SOURCE_FILES."UGW-".date("Y-m-d_H-i-s",time()).".sql";

$cn = connectDB();
	backup_tables($cn,$file_name);
ClosedDBConnection($cn);

$file = $file_name;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

?>