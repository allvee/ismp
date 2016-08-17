<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$remoteCnQry="select * from tbl_process_db_access where pname='CMS'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//remote connection parameter set up
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_uid'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);// close current connection
	
	$cn=connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
	$category_name = mysql_real_escape_string(htmlspecialchars($_POST['category_name']));
	$prompt = mysql_real_escape_string(htmlspecialchars($_POST['prompt']));
	$post_prompt = mysql_real_escape_string(htmlspecialchars($_POST['post_prompt']));
	$display_order = mysql_real_escape_string(htmlspecialchars($_POST['display_order']));
	$active = mysql_real_escape_string(htmlspecialchars($_POST['active']));
	$sourceh = mysql_real_escape_string(htmlspecialchars($_POST['sourceh']));
	$parent = mysql_real_escape_string(htmlspecialchars($_POST['parent']));
	$pre_prompt = mysql_real_escape_string(htmlspecialchars($_POST['pre_prompt']));
	$ivr_string = mysql_real_escape_string(htmlspecialchars($_POST['ivr_string']));
	$status = mysql_real_escape_string(htmlspecialchars($_POST['status']));
	$deactive = mysql_real_escape_string(htmlspecialchars($_POST['deactive']));
	$cph = mysql_real_escape_string(htmlspecialchars($_POST['cph']));
	$TimeSlotID = mysql_real_escape_string(htmlspecialchars($_POST['TimeSlotID']));
	$userID=$_SESSION['USER_ID'];
	//$filename = mysql_real_escape_string(htmlspecialchars($_POST['filename']));
	
    $arr=split(",",$sourceh);
	//echo json_encode($arr);
	//exit;
	$val_arr="";
	foreach($arr as $key=>$val)
	{
		if($val_arr !="")$val_arr.=",";
		$val_arr.="'".$val."'";
	}
	
	$sourceh=$val_arr;
	
	$arr=split(",",$cph);
	$val_arr="";
	foreach($arr as $key=>$val)
	{
		if($val_arr !="")$val_arr.=",";
		$val_arr.="'".$val."'";
	}
	
	$cph=$val_arr;
	
	if($action=="update"){
			
			$quary="update category set `CategoryName`='$category_name', `ParentID`='$parent', `Prompt`='$prompt',`Pre-Prompt`='$pre_prompt',`Post-Prompt`='$post_prompt',`IVR-String`='$ivr_string',`DisplayOrder`='$display_order', `ActivationDate`='$active',`DeactivationDate`='$deactive',`UserID`='$userID',`Status`='$status' where `CategoryID`='$action_id'";
			$res = Sql_exec($cn,$quary);
			
			$quary="update service set `Status`='$status', `ActivationDate`='$active', `DeactivationDate`='$deactive',`TimeSlotID`='$TimeSlotID',`LastUpdate`=NOW(),`UserID`='$userID' where `ServiceID`='$action_id'";
			$res = Sql_exec($cn,$quary);
			if($res){
				if(isset($sourceh) && $sourceh!="")
				{   
					$quary="delete from categoryrequestsource where  `CategoryID`='$action_id'";
					Sql_exec($cn,$quary);
					
					$r_S = $category_name.'_'.date("YmdHis",strtotime("NOW"));
					$quary="INSERT INTO categoryrequestsource (`CategoryRequestSourceID`,`CategoryID`,`RequestSourceID`,`UserID`,`LastUpdate`) 
					(SELECT concat('$r_S',RequestSourceID) as CategoryRequestSourceID,'$action_id' as CategoryID,`RequestSourceID`,'$userID' as UserID, NOW() as LastUpdate 
					FROM requestsource WHERE `RequestSourceID` IN (".$sourceh."))";
					Sql_exec($cn,$quary);
					
				}
				
				if(isset($cph) && $cph!=""){
							
							 $quary="delete from categorypermission  where `CategoryID`='$action_id'";
							 Sql_exec($cn,$quary);
							 
							$quary="INSERT INTO categorypermission (`CategoryPermissionID`,`CategoryID`,`CPID`,`HasPermission`,`UserID`,`LastUpdate`) 
							(SELECT concat('$r_S',CPID) as CategoryPermissionID,'$action_id' as CategoryID,`CPID`,'Yes' as HasPermission,'$userID' as UserID,NOW() as LastUpdate 
							FROM contentprovider WHERE CPID IN (".$cph."))";
							Sql_exec($cn,$quary);
				  }
				  
				  echo 0;
			  
			}else{
				echo 1;
			}
     }else if($action=="insert"){
		 	  
		$quary="insert into category (`CategoryID`,`CategoryName`,`ParentID`,`Prompt`,`Pre-Prompt`,`Post-Prompt`,`IVR-String`,`DisplayOrder`,`ActivationDate`, `DeactivationDate`,`UserID`, `Status`) 
values('$category_name','$category_name','$parent','$prompt','$pre_prompt','$post_prompt','$ivr_string','$display_order','$active','$deactive','$userID','$status')";
		$res = Sql_exec($cn,$quary);
			  
		$quary="insert into service (`ServiceID`,`Password`,`Status`,`ActivationDate`,`DeactivationDate`,`UserID`,`LastUpdate`,`CategoryID`,`TimeSlotID`, `ChannelID`) 
values('$category_name','1234', '$status','$active','$deactive','$userID',NOW(),'$category_name','$TimeSlotID','1')";
		$res = Sql_exec($cn,$quary);
				
			 
			  if(isset($res) && $res)
			  {
				    // $id=mysql_insert_id($cn); 
				$r_S = $category_name.'_'.date("YmdHis",strtotime("NOW"));
				   if(isset($sourceh) && $sourceh!="")
				   {
					    // $id=$id."";
						
					    $quary="INSERT INTO categoryrequestsource( `CategoryRequestSourceID`,`CategoryID`,`RequestSourceID`,`UserID`,`LastUpdate`) 
					    (SELECT concat('$r_S',RequestSourceID) as CategoryRequestSourceID, '$category_name' as CategoryID, `RequestSourceID`, '$userID' as UserID, NOW() as LastUpdate 
						FROM requestsource WHERE `RequestSourceID` IN (".$sourceh."))";
				        Sql_exec($cn,$quary);
					   
				   }
				   
				   if(isset($cph) && $cph !=""){
					    $yes="yes";
				  		$quary="INSERT INTO categorypermission  (`CategoryPermissionID`,`CategoryID`,`CPID`,`HasPermission`,`UserID`,`LastUpdate`) 
						(SELECT concat('$r_S',CPID) as CategoryPermissionID,'$category_name' as CategoryID,`CPID`,'Yes' as HasPermission,'$userID' as UserID,NOW() as LastUpdate 
						FROM contentprovider WHERE CPID IN (".$cph."))";
						Sql_exec($cn,$quary);
				   }
				  
				  echo 0;
			  }else{
				    echo 1;
			  }
		 
     }else if($action=="delete"){
		 
		      
		      $quary="delete from category  where `CategoryID`='$action_id'";
			  $res1 = Sql_exec($cn,$quary);
			  $quary="delete from categorypermission  where `CategoryID`='$action_id'";
			  $res2 = Sql_exec($cn,$quary);
			  
			  $quary="delete from categoryrequestsource  where `CategoryID`='$action_id'";
			  $res3 = Sql_exec($cn,$quary);
			  
		      if( $res1 && $res2 && $res3 ) echo 0;
			  else {
				     echo 1;
			  }
		 
    	}else{
			 echo 1;
		}
	
	
	
	
	
	ClosedDBConnection($cn);
}

?>