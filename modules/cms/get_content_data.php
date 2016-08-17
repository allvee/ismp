<?php
session_start();
require_once "../.././commonlib.php";

if (!empty($_POST))
{
	$cn = connectDB();
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
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
	
	$quary="select `ContentName`,`Title`,`Description`,`ContentTypeID`,`SMS Text`,`SMSType`,`DownloadURL`,`PreviewURL`, `ActivationDate`,`DeactivationDate`,`CategoryID` from content where `ContentID`='$action_id'";
	$res = Sql_exec($cn,$quary);
	$dt = Sql_fetch_array($res);
	$val_arr=array(
			"cname"=>$dt['ContentName'],
	    	"title"=>$dt['Title'],
	    	"desc"=>$dt['Description'],
	    	"c_type"=>$dt['ContentTypeID'],
	    	"sms"=>$dt['SMS Text'],
	    	"sms_type"=>$dt['SMSType'],
	    	"d_url"=>$dt['DownloadURL'],
	    	"u_url"=>$dt['PreviewURL'],
	    	"actdate"=>$dt['ActivationDate'],
			"deadate"=>$dt['DeactivationDate'],
			"category_id"=>$dt['CategoryID']
		);
	
	echo json_encode($val_arr);	
	
	
	ClosedDBConnection($cn);
}

?>