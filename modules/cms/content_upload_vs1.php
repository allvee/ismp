<?php
ini_set('memory_limit','96M');
ini_set('upload_max_filesize', '64M');
ini_set('post_max_size', '64M');

session_start();

include_once "../../commonlib.php";

$cn = connectDB();

$is_error = 0;
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
$cname = mysql_real_escape_string(htmlspecialchars($_REQUEST['cname']));
$actdate = mysql_real_escape_string(htmlspecialchars($_REQUEST['actdate']));
$deadate = mysql_real_escape_string(htmlspecialchars($_REQUEST['deadate']));
$category_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['category_id']));
$file=$request_source=mysql_real_escape_string(htmlspecialchars($_REQUEST['request_source']));



if (!$cn) {
	$is_error = 1;
	// exit();   
} else {
	   
	   if($action=="insert"){
				   
				/*	$query="SELECT *, (select category_name from tbl_cms_category where id='$category_id') as category_name 
					FROM  tbl_cms_requestsource 
					WHERE request_source_id IN 
				    (SELECT requestsource_id FROM tbl_cms_category_requestsource WHERE category_id ='$category_id')";  */
					
					$qry="select 
								rs.request_source_id,
								rs.source_name,
								catg.category_name,
								rs.view_list_url,
								rs.service_name,
								rs.content_list_user_id,
								rs.content_list_password
								FROM tbl_cms_requestsource rs
								INNER JOIN tbl_cms_category_requestsource crs
								ON rs.request_source_id=crs.requestsource_id
								INNER JOIN tbl_cms_category catg
								ON catg.id=crs.category_id
								WHERE crs.category_id='$category_id' and rs.request_source_id='$request_source'";
				   
							
				   $rs = Sql_exec($cn, $qry);
				   $dt = Sql_fetch_array($rs);
				   
				   $view_list_url = $dt['view_list_url'];
				   $category_name = $dt['category_name'];
				   $service_name = $dt['service_name'];
				   $content_list_user_id = $dt['content_list_user_id'];
				   $content_list_password = $dt['content_list_password'];
				   $request_source_id=$dt['request_source_id'];
				   $ContentListUrl = $view_list_url."?Reftype=CategoryID&RefValue=".$category_name.		          		    
				   "&ListFormat=Filepath&NoOfItem=1&SortColumn=LastUpdate&SortType=DESC&Channel=IVR&ServiceID=".$service_name."&UserID=".$content_list_user_id."&Password=".$content_list_password."&LogType=none&RequestSourceID=".$request_source_id;
					$path=file_get_contents($ContentListUrl);
				   
             
				   
	    //// Upload file
		if(move_uploaded_file($_FILES[$file]['tmp_name'], $path.$_FILES[$file]['name'])){
			
			  $qry="INSERT INTO tbl_cms_content (content_name,activation_date,deactivation_date,category_id)VALUES('$cname','$actdate','$deadate','$category_id')";
			  try{
			  		Sql_exec($cn,$qry);
			  }catch(Exception $e){
				  $is_error=2;
			  }
		
			  
		}else{
				$is_error = 3;
		}
	  }else if($action=="update")
	  {
		 					   $qry="select 
								rs.request_source_id,
								rs.source_name,
								catg.category_name,
								rs.view_list_url,
								rs.service_name,
								rs.content_list_user_id,
								rs.content_list_password
								FROM tbl_cms_requestsource rs
								INNER JOIN tbl_cms_category_requestsource crs
								ON rs.request_source_id=crs.requestsource_id
								INNER JOIN tbl_cms_category catg
								ON catg.id=crs.category_id
								WHERE crs.category_id='$category_id' and rs.request_source_id='$request_source'";
				   
				   $rs = Sql_exec($cn, $qry);
				   $dt = Sql_fetch_array($rs);
				   
				   $view_list_url = $dt['view_list_url'];
				   $category_name = $dt['category_name'];
				   $service_name = $dt['service_name'];
				   $content_list_user_id = $dt['content_list_user_id'];
				   $content_list_password = $dt['content_list_password'];
				   $ContentListUrl = $view_list_url."?Reftype=CategoryID&RefValue=".$category_name."&ListFormat=Filepath&NoOfItem=1&SortColumn=LastUpdate&SortType=DESC&Channel=IVR&ServiceID=".$service_name."&UserID=".$content_list_user_id."&Password=".$content_list_password."&LogType=none&RequestSourceID=".$request_source_id;

	   
	               $path=file_get_contents($ContentListUrl);
					//// Upload file
					if(move_uploaded_file($_FILES[$file]['tmp_name'], $path.$_FILES[$file]['name'])){
						
					      $qry="update tbl_cms_content set content_name='$cname', activation_date='$actdate',deactivation_date='$deadate' where  content_id='$action_id'";
						  try{
						        Sql_exec($cn,$qry);
								$is_error=0;
						  }catch(Exception $e){
							    $is_error=2;  
						   }
						  
					  }else{
								$is_error = 3;
					  }
		     
	  }
        
		
	   
} 

ClosedDBConnection($cn);

echo $is_error;
?>