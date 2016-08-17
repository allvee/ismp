<?php
session_start();
require_once "../.././commonlib.php";
$cn = connectDB();
$action=mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$instance_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['id']));

if(isset($action) && isset($instance_id) && !empty($action) && !empty($instance_id))
{
       
	   if($action=="execute"){
		    
			$qry="SELECT * FROM tbl_obd_instance_list WHERE id='$instance_id'";
			$res = Sql_exec($cn,$qry);
			$dt=Sql_fetch_array($res);
			
			$user_id=$dt["user_id"];
			$server_id=$dt["server_id"];
			$display_no=$dt["display_no"];
			$original_no=$dt["original_no"];
			$outdialtime=$dt["schedule_date"];
			$service_id=$dt["service_id"];
			$prompt_location=$dt["prompt_location"];
			$status=$dt["status"];
			//$time_stamp=$dt["time_stamp"];
			$id_operator_distribution=$dt["id_operator_distribution"];
			
			
			$qry="SELECT DISTINCT msisdn FROM tbl_obd_dnd_list WHERE user_id='$user_id'";
			$res = Sql_exec($cn,$qry);
			$dnd_list="";
			while($dt=Sql_fetch_array($res))
			{
			   if($dnd_list != "" )
			   		$dnd_list.=","."\"".$dt["msisdn"]."\"";
			   else
				    $dnd_list.="\"".$dt["msisdn"]."\"";
				
			}
			
			$dnd_list='( '.$dnd_list.' )';
			
		
			$qry="SELECT DISTINCT msisdn 
				  FROM tbl_obd_white_list 
				  WHERE user_id='$user_id' 
				  		AND server_id = '$id_operator_distribution'  
						AND ( msisdn NOT IN $dnd_list )";
			
			$distribution_list=array();
			$res = Sql_exec($cn,$qry);
			while($dt=Sql_fetch_array($res))
			{
			  array_push($distribution_list,$dt["msisdn"]);
			}
			
			
			$qry="UPDATE tbl_obd_instance_list SET status=2 WHERE id='$instance_id'";
			$res = Sql_exec($cn,$qry);
			
			// remote connection
			$qry="SELECT * FROM tbl_obd_server_config WHERE id='$server_id'";
			$res = Sql_exec($cn,$qry);
			$dt=Sql_fetch_array($res);
			
			$dbtype=$dt["db_type"];
			$MYSERVER=$dt["db_server"];
			$MYUID=$dt["db_user"];
			$MYPASSWORD=$dt["db_password"];
			$MYDB=$dt["db_name"];
			ClosedDBConnection($cn);
			
			$remote_cn = connectDB();
			$count=0;
			$err=null;
			if(!empty($distribution_list))
			{
				try{
					foreach($distribution_list as $msisdn)
					{
						$qry="INSERT INTO outdialque (MSISDN, DisplayAno, OriginalAno, ServiceId, OutDialStatus, RetTryCount, OutDialTime, UserId)
									VALUES 
										('0$msisdn', '$display_no', '$original_no','$service_id', 'QUE', 3, '$outdialtime','$instance_id')";
						Sql_exec($remote_cn,$qry);
						$count++;
					}
				}catch(Exception $e)
				{
					 $err="err";
				}
			}
			
			if($err !=null && $err=="err")echo $err;
			else{ 
				echo $count;
			}
			if($remote_cn)ClosedDBConnection($remote_cn);
			
		}elseif($action=="remove"){
			$err="";
			$qry="UPDATE tbl_obd_instance_list SET status=1 WHERE id='$instance_id'";
			$res=Sql_exec($cn,$qry);
			if($res){
				$err=0;
			}else{
				$err=1;
			}
			
			echo $err;
		}	
	
	
}
	
if($cn)ClosedDBConnection($cn);
?>