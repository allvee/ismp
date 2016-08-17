<?php
session_start();
include_once "../../commonlib.php";
$val_arr=array();
$adate=$val_arr['actdate']=$_REQUEST['actdate'];
$ddate=$val_arr['deadate']=$_REQUEST['deadate'];
$cname=$val_arr['cname']=$_REQUEST['cname'];
$id=$val_arr['id']=$_REQUEST['id'];
//echo json_encode($val_arr);
//echo json_encode($_FILES);


function outputJSON($msg, $status = 'error'){
	global $val_arr;
	
    header('Content-Type: application/json');
    die(json_encode(array(
        'data' => $msg,
        'status' => $status
    )));
}
//echo json_encode($_FILES);

//// Check for errors
if($_FILES['SelectedFile']['error'] > 0){
    outputJSON('An error ocurred when uploading.');
}

/*if(!getimagesize($_FILES['SelectedFile']['tmp_name'])){
    outputJSON('Please ensure you are uploading an image.');
}
*/
// Check filetype
if($_FILES['SelectedFile']['type'] != 'audio/wav'){
    outputJSON('Unsupported filetype uploaded.');
}

// Check filesize
if($_FILES['SelectedFile']['size'] > 5000000){
    outputJSON('File uploaded exceeds maximum upload size.');
}

// Check if the file exists
if(file_exists('upload/' . $_FILES['SelectedFile']['name'])){
    outputJSON('File with that name already exists.');
}


$cn = connectDB();

$query="SELECT *, (select category_name from tbl_cms_category where id='$id') as category_name FROM tbl_cms_requestsource WHERE request_source_id IN (SELECT requestsource_id FROM tbl_cms_category_requestsource WHERE category_id ='$id')";
if (!$cn) {
    echo("Cannot connect to server ($server) with error: " . Sql_error());
    die();
}else{
   	   
       $rs = Sql_exec($cn, $query);
       $dt = Sql_fetch_array($rs);
	   $view_list_url = $dt['view_list_url'];
	   $category_name = $dt['category_name'];
	   $service_name = $dt['service_name'];
	   $content_list_user_id = $dt['content_list_user_id'];
	   $content_list_password = $dt['content_list_password'];
	   $view_list_url = $dt['view_list_url'];
	   
	   $ContentListUrl = $view_list_url."?Reftype=CategoryID&RefValue=".$category_name."&ListFormat=Filepath&NoOfItem=1&SortColumn=LastUpdate&SortType=DESC&Channel=IVR&ServiceID=".$service_name."&UserID=".$content_list_user_id."&Password=".$content_list_password."&LogType=none&RequestSourceID=".$request_source_id;

	   
	    $path=file_get_contents($ContentListUrl);

	    //// Upload file
		if(move_uploaded_file($_FILES['SelectedFile']['tmp_name'], $path.$_FILES['SelectedFile']['name'])){
			
			  $qry="INSERT INTO tbl_cms_content (content_name,activation_date,deactivation_date)VALUES('$cname','$adate','$ddate')";
			  Sql_exec($cn,$qry);
			  outputJSON('File uploaded successfully to "' . $path . $_FILES['SelectedFile']['name'] . '".', 'success');
			  
		}else{
			outputJSON('Error uploading file - check destination is writeable.');
		}
        
		
	   
} 

ClosedDBConnection($cn);

 ?>