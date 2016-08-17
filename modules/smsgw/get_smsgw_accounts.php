<?php
require_once "../.././commonlib.php";

$value = '<option value="0" disabled="disabled" selected="selected">Account Holder</option>';
$qry = "select id,acc_name from tbl_smsgw_account where is_active='active' and acc_type='user'";

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$value .= '<option value="'.$dt['id'].'">'.$dt['acc_name'].'</option>';
	}
	
	ClosedDBConnection($cn);
	
	echo $value;
?>