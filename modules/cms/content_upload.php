<?php
set_time_limit(0);

session_start();

include_once "../../commonlib.php";

$cn = connectDB();

$is_error = 0;
$content_status = "Active";
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
$cname = mysql_real_escape_string(htmlspecialchars($_REQUEST['cname']));
$actdate = mysql_real_escape_string(htmlspecialchars($_REQUEST['actdate']));
$deadate = mysql_real_escape_string(htmlspecialchars($_REQUEST['deadate']));
$category_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['category_id']));
$title = mysql_real_escape_string(htmlspecialchars($_REQUEST['title']));
$description = mysql_real_escape_string(htmlspecialchars($_REQUEST['description']));
$content_type = mysql_real_escape_string(htmlspecialchars($_REQUEST['content_type']));
$sms = mysql_real_escape_string(htmlspecialchars($_REQUEST['sms']));
$sms_type = mysql_real_escape_string(htmlspecialchars($_REQUEST['sms_type']));
$download_url = mysql_real_escape_string(htmlspecialchars($_REQUEST['download_url']));
$preview_url = mysql_real_escape_string(htmlspecialchars($_REQUEST['preview_url']));

if (!$cn) {
	$is_error = 1;
} else {
	
	if($sms_type == "other"){
		$sms = 'T'.bin2hex(mb_convert_encoding($sms, 'UCS-2', 'auto'));
	}
	
	if($CMS_REQUIRED_CONTENT_UPLOAD_PERMISSION){
		$content_status = "pending";
	}
	
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
	
	if($content_type == "ivr"){
		$query="CALL psGetSourceInfo('$category_id')";
		/*$query="SELECT *, (select category_name from tbl_cms_category where id='$category_id') as category_name 
		FROM  tbl_cms_requestsource WHERE request_source_id IN (SELECT requestsource_id FROM tbl_cms_category_requestsource WHERE category_id ='$category_id')";*/
				   
		/*"select *,catg.category_name FROM tbl_cms_requestsource rs INNER JOIN tbl_cms_category_requestsource crs
		  ON rs.request_source_id=crs.requestsource_id INNER JOIN tbl_cms_category catg ON catg.id=crs.category_id
		  where catg.id=''";*/
		$rs = Sql_exec($cn, $query);
		$dt = Sql_fetch_array($rs);
				   
		$view_list_url = $dt['ViewListURL'];
		// $category_name = $dt['category_name'];
		$service_name = $dt['ServiceName'];
		$content_list_user_id = $dt['ContentListUserID'];
		$content_list_password = $dt['ContentListPassword'];
		$request_source_id=$dt['RequestSourceID'];
		$ContentListUrl = $view_list_url."?Reftype=CategoryID&RefValue=".$category_id."&ListFormat=Filepath&NoOfItem=1&SortColumn=LastUpdate&SortType=DESC&Channel=IVR&ServiceID=".$service_name."&UserID=".$content_list_user_id."&Password=".$content_list_password."&LogType=none&RequestSourceID=".$request_source_id;
        $target_url=$dt['ServerCallBackURL'];
	    
		
		            
	    $path=file_get_contents($ContentListUrl);
        $name = $_FILES['file']['name'];
				
		if(copy($_FILES['file']['tmp_name'], realpath(__DIR__ . '/wavtmp') . '/'.$name))
		{
				$file_name_with_full_path = realpath(__DIR__ . '/wavtmp/'.$name); //realpath("wavtmp/".$name); 
				$post = array('path_info' => $path,'name'=>$name, 'file_contents'=>'@'.$file_name_with_full_path);
				
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$target_url);
				curl_setopt($ch, CURLOPT_POST,1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				$result=curl_exec($ch);
				curl_close($ch);
				unlink($file_name_with_full_path);
				if(intval($result) == 1){
					$is_error = 2;
				}
		}
		
	}  
	
	$qry="";
	if($action=="update"){
		$qry = "UPDATE content SET `ContentName`='$cname',`Title`='$title',";
		$qry .= "`Description`='$description',`ContentTypeID`='$content_type',`SMS Text`='$sms',`SMSType`='$sms_type',";
		$qry .= "`DownloadURL`='$download_url',`PreviewURL`='$preview_url',`ActivationDate`='$actdate',`DeactivationDate`='$deadate',`Status`='$content_status'";
		$qry .= " WHERE  `ContentID`='$action_id'";	
	} else if($action=="insert"){
		$qry = "INSERT INTO content (`ContentID`,`ContentName`,`Title`,`Description`,`ContentTypeID`,`SMS Text`,`SMSType`,";
		$qry .= "`DownloadURL`,`PreviewURL`,`ActivationDate`,`DeactivationDate`,`CategoryID`,`Status`)";
		$qry .= " VALUES ('$cname','$cname','$title','$description','$content_type','$sms','$sms_type',";
		$qry .= "'$download_url','$preview_url','$actdate','$deadate','$category_id','$content_status')";
	} else if($action=="delete"){
		$qry = "delete from content ";
		$qry .= " WHERE  ContentID='$action_id'";
// echo $qry;
	}
					
	try {
		Sql_exec($cn, $qry);
	}  catch( Exception $e) {
		$is_error = 3;
	}
	
} 

ClosedDBConnection($cn);

echo $is_error;
?>