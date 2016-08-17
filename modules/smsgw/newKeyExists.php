<?php
require_once "../.././commonlib.php";
session_start();
$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];
$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);

$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);
$remoteCn=connectDB();

$keywordVal = mysql_real_escape_string(htmlspecialchars($_POST['keyword']));
$ShortCode = mysql_real_escape_string(htmlspecialchars($_POST['ShortCode']));

$qry = "SELECT `keyword` FROM `keyword` WHERE ";
	$qry .= " `keyword`='$keywordVal' and ShortCode='$ShortCode'"; 

	
    $res = Sql_exec($remoteCn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$keyword = $dt['keyword'];
		$v_arr['keyword'] = $keyword;
	}
	
	if($remoteCn)ClosedDBConnection($remoteCn);
	echo json_encode($v_arr);
?>