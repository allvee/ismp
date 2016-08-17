<?php
require_once "../.././commonlib.php";

$cn          = connectDB();
$remoteCnQry = "SELECT * FROM tbl_process_db_access WHERE pname='CH'";
$res         = Sql_exec($cn, $remoteCnQry);
$dt          = Sql_fetch_array($res);

$dbtype     = $dt['db_type'];
$MYSERVER   = $dt['db_server'];
$MYUID      = $dt['db_uid'];
$MYPASSWORD = $dt['db_password'];
$MYDB       = $dt['db_name'];
ClosedDBConnection($cn);

$remoteCn = connectDB();
$qry = "SELECT DISTINCT Service FROM ivrmenu_copy";
$res = Sql_exec($cn,$qry);

$services = array();                            
while($dt = Sql_fetch_array($res)){
		$service = $dt['Service'];
	    array_push($services,$service);
}

$qry = "SELECT DISTINCT PageName FROM ivrmenu_copy";
$res = Sql_exec($cn,$qry);
$pages = array();  
while($dt = Sql_fetch_array($res)){
		$page = $dt['PageName'];
	    array_push($pages,$page);
}

$servie_page = array("service"=>$services,"page"=>$pages);
	

ClosedDBConnection($remoteCn);
echo json_encode($servie_page);
?>