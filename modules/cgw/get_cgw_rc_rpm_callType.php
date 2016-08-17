<?php
require_once "../.././commonlib.php";
session_start();
$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];

$qry = "select `CallTypeID`,`Ano`,`Bno` from `calltype` where `UserID`='".$user_id."' AND is_active='active'";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " and id='$action_id'"; 
}
	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['call_type_id'] = $dt['CallTypeID'];
		$v_arr[$count]['ano'] = $dt['Ano'];
		$v_arr[$count]['bno'] = $dt['Bno'];
		
		$count++;
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>