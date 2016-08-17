<?php
session_start();
require_once "../.././commonlib.php";


if ( isset($_FILES['file']) ) {
 $filename  = $_FILES['file']['tmp_name'];
 $handle    = fopen($filename, "r");
 $data      = fread($handle, filesize($filename));
 $POST_DATA = array(
   'file' => base64_encode($data),'filename'=>$_FILES['file']['name']
 );
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_URL, 'http://192.168.241.95/cms_3_0/remote_file_upload.php');
 curl_setopt($curl, CURLOPT_TIMEOUT, 30);
 curl_setopt($curl, CURLOPT_POST, 1);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $POST_DATA);
 $response = curl_exec($curl);
 curl_close ($curl);
 echo "<h2>File Uploaded</h2>";
}
//echo json_encode(array('0'=>'home','1'=>'guest'));

/*
if (!empty($_POST))
{
	$cn = connectDB();
	$user_id = mysql_real_escape_string(htmlspecialchars($_POST['user_id']));
	
	$query="SELECT UserID FROM tbl_user WHERE UserID='$user_id'";
	$rs=Sql_exec($cn,$query);
	if(Sql_Num_Rows($rs)>0) echo 0;
	else echo 1;
	ClosedDBConnection($cn);
}*/


?>