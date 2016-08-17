<?php
session_start();
require_once "../.././commonlib.php";

if (isset($_POST))
{
	$id = mysql_real_escape_string(htmlspecialchars($_POST['acc_name']));
	$amount_credit = mysql_real_escape_string(htmlspecialchars($_POST['amount_credit']));
	$is_error = 0;
	$check_balance_qry = "select balance from tbl_smsgw_account where acc_type='admin' and is_active='active'";
	
	$cn = connectDB();
	$check_balance_rs = Sql_fetch_array(Sql_exec($cn,$check_balance_qry));
	
	if(doubleval($check_balance_rs['balance'])>= doubleval($amount_credit)){
		$qry = "update tbl_smsgw_account set balance=balance+$amount_credit where id='$id' and is_active='active'";
		$qry_admin = "update tbl_smsgw_account set balance=balance-$amount_credit where acc_type='admin' and is_active='active'";
	
		try {
			$res = Sql_exec($cn,$qry_admin);
			$rs = Sql_exec($cn,$qry);
		} catch (Exception $e){
			$is_error = 1;
		}
	} else {
		$is_error = 2; 
	}
	
	echo $is_error;
	
	ClosedDBConnection($cn);
}

?>