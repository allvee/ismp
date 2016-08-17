<?php
require_once "../.././commonlib.php";

$cn = connectDB();
$qry="SELECT * FROM ismp.tbl_process_db_access WHERE pname=\"CGW\"";
$res = Sql_exec($cn,$qry);
$dt=Sql_fetch_array($res);
$dbtype=$dt["db_type"];
$MYSERVER=$dt["db_server"];
$MYUID=$dt["db_uid"];
$MYPASSWORD=$dt["db_password"];
$MYDB=$dt["db_name"];

ClosedDBConnection($cn);

$remote_cn = connectDB();

$qry = "SELECT `CDRWriteStatus`,COUNT(CDRWriteStatus) AS Count FROM cdr GROUP BY `CDRWriteStatus`"; 

	
    $res = Sql_exec($remote_cn,$qry);
	$v_arr = array();
    $count = 0;                        
    while($dt = Sql_fetch_array($res)){
//		$v_arr[$count]['CDRWriteStatus'] = $dt['CDRWriteStatus'];
//		$v_arr[$count]['COUNT'] = $dt['COUNT'];
//		$count++;

		$v_arr[]= Array("CDRWriteStatus"=>$dt['CDRWriteStatus'], "Count"=>$dt['Count']);
		
	}

if($remote_cn)ClosedDBConnection($remote_cn);	
if($cn)ClosedDBConnection($cn);

	echo json_encode($v_arr);
?>