<?php
require_once "../.././commonlib.php";
session_start();
$v_arr = array();
$count = 0;
$user_id = $_SESSION['USER_ID'];
$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);
//remote connection parameter set up
$dbtype=$dt['db_type'];
$MYSERVER=$dt['db_server'];
$MYUID=$dt['db_uid'];
$MYPASSWORD=$dt['db_password'];
$MYDB=$dt['db_name'];
ClosedDBConnection($cn);// close current connection

$remoteCn=connectDB();

$qry = "select `TimeSlotID`,`StartDay`,`EndDay`,`StartTime`,`EndTime` from `timeslot`"; // where `UserID`='".$user_id."'  ";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " where `TimeSlotID`='$action_id'"; 
}
	
    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['timeSlotIdHidden'] = $dt['TimeSlotID'];
		$v_arr[$count]['TimeSlotID'] = $dt['TimeSlotID'];
		$v_arr[$count]['StartDay'] = $dt['StartDay'];
		$v_arr[$count]['EndDay'] = $dt['EndDay'];
		
		$h1 = 0;
		$m1 = 0;
		$h2 = 0;
		$m2 = 0;
		$ap1= '';
		$ap2= '';
		
		$m1 = $dt['StartTime'] % 60;
		$m2 = $dt['EndTime'] % 60;
		
		$h1 = ($dt['StartTime'] - $m1) / 60;
		$h2 = ($dt['EndTime'] - $m2) / 60;
		
		if($h1 > 11)$ap1='PM';
		else $ap1='AM';

		if($h2 > 11)$ap2='PM';
		else $ap2='AM';
		
		if($h1 == 0)$h1 = 12;
		else if ($h1 > 12) $h1 = $h1 - 12;

		if($h2 == 0)$h2 = 12;
		else if ($h2 > 12) $h2 = $h2 - 12;
		
		if($h1 < 10) $h1 = '0'.$h1;
		if($h2 < 10) $h2 = '0'.$h2;
		
		if($m1 < 10) $m1 = '0'.$m1;
		if($m2 < 10) $m2 = '0'.$m2;	
		
//		$v_arr[$count]['StartTime'] = $dt['StartTime'];
//		$v_arr[$count]['EndTime'] = $dt['EndTime'];
		$v_arr[$count]['StartTime'] = $h1.':'.$m1.' '.$ap1;
		$v_arr[$count]['EndTime'] = $h2.':'.$m2.' '.$ap2;
		
		$count++;
	}
	
if($cn)ClosedDBConnection($cn);
if($remoteCn)ClosedDBConnection($remoteCn);	
	echo json_encode($v_arr);
?>