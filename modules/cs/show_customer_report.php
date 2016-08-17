<?php
// header("Access-Control-Allow-Origin: *");
session_start();

require_once "../.././commonlib.php";
require_once "../.././service_config.php";
/*
Sql_Num_Rows($res)
Sql_fetch_array($res)
Sql_exec($remote_cn,$query_report_rev_his)
*/

$msisdn=htmlspecialchars($_REQUEST['msisdn']);
$short_code=htmlspecialchars($_REQUEST['short_code']);
$start_date=htmlspecialchars($_REQUEST['start_date']);
$end_date=htmlspecialchars($_REQUEST['end_date']);
$USER_ID=htmlspecialchars($_SESSION['USER_ID']);

$value=
'<h2>Subscription Service Status</h2>
        <table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody>
            <tr>
                <td class="jstableheader">Service Name</td>
                <td class="jstableheader">Port Registered</td>
				<td class="jstableheader">Registered</td>
                <td class="jstableheader">Registration Date</td>
                <td class="jstableheader">Deregistration Date</td>
                <td class="jstableheader">Activation Channel</td>
                <td class="jstableheader">Charging Plan</td>
				<td class="jstableheader">Remarks</td>
                <td class="jstableheader">Status</td>
				<!-- <td>Block Status</td>-->
            </tr>';

$tmp_msisdn=substr($msisdn,-10);


$services = array();
$cn = connectDB();
$qry = "select id,ServiceName,RegURL,DeregURL,BlockURL,UnblockURL from `tbl_cs_service_config` where is_active='active'";

 $res = Sql_exec($cn,$qry);
	while($row = Sql_fetch_array($res)){
		$value=$value."<tr>";
		$servicename=$row["ServiceName"];
		$regurl=$row["RegURL"].$tmp_msisdn;
		$deregurl=$row["DeregURL"].$tmp_msisdn;
		$blockurl=$row["BlockURL"].$tmp_msisdn;
		$unblockurl=$row["UnblockURL"].$tmp_msisdn;
		$statusurl=$single_service_status_url."?Param=$tmp_msisdn|$servicename";
		$result=file_get_contents($statusurl);
		
		//echo $result;
		$list=explode("|",$result);
		//var_dump( $list);
		$count= $list[0];
		
		$port="";
		$registered="";
		$regdate="";
		$deregdate="";
		$channel="";
		$chargingplan="";
		$remarks="";
		$url=$regurl;
		$blockstatusurl=$blockurl;
		$linkname="Activate";
		$blockstatus = "Block";
		$isactivate="1";
		$isblock="1";
		if($count>0)
		{
			$port=$list[4];
			if($list[10]!="1")
			{	
				$registered="Yes";
				$url=$deregurl;
				$linkname="Deactivate";
				$isactivate="0";
			}
			$regdate=date("d M Y H:i:s", strtotime($list[6]));
			$deregdate=($list[8]? date("d M Y H:i:s", strtotime($list[8])) : '');
			$channel=$list[12];
			$chargingplan=$list[16];
			$remarks=$list[14];
			
			if($list[17]!="Unblock")
			{	
				$blockstatusurl=$unblockurl;
				$isblock="0";
				$blockstatus = "Unblock";
			}			
		}
		
		$value=$value."<td>$servicename</td>";
		$value=$value."<td>$port</td>";
		$value=$value."<td>$registered</td>";
		$value=$value."<td>$regdate</td>";
		$value=$value."<td>$deregdate</td>";
		$value=$value."<td>$channel</td>";
		$value=$value."<td>$chargingplan</td>";
		$value=$value."<td>$remarks</td>";
		$value=$value."<td><a style='color:black' href='#' onclick='callurl(\"$url\");return false;'>".$linkname."</a></td>";
	//	$value=$value."<td><a style='color:black' href='#' onclick='callurl(\"$blockstatusurl\");return false;' >$blockstatus</a></td>";
		
		$value=$value."</tr>";
		
	
	}
	
ClosedDBConnection($cn);

$value=$value.'</tbody></table>';

 echo $value;

// call details \\

$cn=connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$cn=connectDB();
	$load_qry = "SELECT `UniqueID`,`Ano`,`Bno`,`ServiceID`,`StartTime`,`EndTime`, TIMEDIFF(`EndTime`,`StartTime`) as duration_time FROM `cdr_back` ";
	$load_qry.="  where `Ano` LIKE '%".$tmp_msisdn."%'";
	if($short_code != ""){
		$load_qry.="  and `Bno` = '$short_code'";
	}
	
	if($start_date != ""){
		$load_qry.="  and `StartTime` >= '$start_date'";
	}
	
	if($end_date != ""){
		$load_qry.="  and `EndTime` <= '$end_date'";
	}
	$load_qry.=" order by UniqueID desc limit 0,10";	
	
	$value = '<br/><h2>Call Details</h2>
        	<table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
        	<tbody><tr>
						<td class="jstableheader">Unique ID</td>
						<td class="jstableheader">MSISDN</td>
						<td class="jstableheader">Port</td>
						<td class="jstableheader">Service Name</td>
						<td class="jstableheader">Start Time</td>
						<td class="jstableheader">End Time</td>
						<td class="jstableheader">Duration(hh:mm:ss)</td>
					</tr> ';
	$res = Sql_exec($cn,$load_qry);
	while($dt = Sql_fetch_array($res)){
		$value .= '<tr>';
		$value .= '<td>'.$dt['UniqueID'].'</td>';
		$value .= '<td>'.$dt['Ano'].'</td>';
		$value .= '<td>'.$dt['Bno'].'</td>';
		$value .= '<td>'.$dt['ServiceID'].'</td>';
		$value .= '<td>'.$dt['StartTime'].'</td>';
		$value .= '<td>'.$dt['EndTime'].'</td>';
		$value .= '<td>'.$dt['duration_time'].'</td>';
		$value .= '</tr>';
	}
	$value .= "</tbody></table>";
//$request_url=$sms_details_url.$msisdn;
//echo $request_url;
//$result=file_get_contents($request_url);
//echo $result;

/*$call_details_request_url=$call_details_url.$msisdn;
$result=file_get_contents($call_details_request_url);
echo $result;*/

ClosedDBConnection($cn);
	
echo $value;	
?>
<script>
$(document).ready(function() {
$(".tblcss tr:odd").css('background-color','#f2f2f2');
$(".tblcss tr:even").css('background-color','#ffffff');
// $( ".tblcss tr:first td" ).css({"background-color": "#423c4e","border-color":"#61557a","border-image":"none", "border-style": "solid","border-width": "0 0 1px","color": "#ffffff","font-size": "14px","font-weight": "bold","text-align": "left","vertical-align": "middle"}); 

});
</script>