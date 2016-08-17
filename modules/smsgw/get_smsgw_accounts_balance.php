<?php
require_once "../.././commonlib.php";

$id = mysql_real_escape_string(htmlspecialchars($_POST['acc_name']));
$balance = 0;
$qry = "select balance from tbl_smsgw_account where is_active='active' and id='$id'";

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	$dt = Sql_fetch_array($res);
	$balance = $dt['balance'];
	
	ClosedDBConnection($cn);
	
	echo $balance;
?>