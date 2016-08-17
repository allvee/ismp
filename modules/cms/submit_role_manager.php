<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$rolename = mysql_real_escape_string(htmlspecialchars($_POST['rolename']));
	$user_id = $_SESSION['USER_ID'];
	
	$is_error = 0;
	
	if($action == "insert"){
		
		$insert_qry = "INSERT INTO tbl_roles (rolename,last_updated_by) VALUES ('$rolename','$user_id')";
		// $qry = "CALL store_role('$rolename','$user_id');";	
		try {
			$res = Sql_exec($cn,$insert_qry);
			$select_qry  = "SELECT id FROM tbl_roles WHERE last_updated_by='$user_id' ORDER BY id DESC LIMIT 1";
			$rs_arr = Sql_fetch_array(Sql_exec($cn,$select_qry));
			$roleid  = $rs_arr["id"];
			$i_qry = "INSERT INTO tbl_roles_permission (roles_id,menu_id) (SELECT '$roleid', id FROM tbl_menu)";
			$res = Sql_exec($cn,$i_qry);
		} catch (Exception $e){
			$is_error = 1;
		}
		
		
		
	} elseif($action == "update") { 
		$qry = "update tbl_roles set rolename='$rolename',last_updated_by='$user_id',last_updated=now() where id='$action_id'";	
		try {
			$res = Sql_exec($cn,$qry);
		} catch (Exception $e){
			$is_error = 1;
		}	
	}
	
	echo $is_error;
	
	ClosedDBConnection($cn);
}

?>