<?php
session_start();
require_once "../.././commonlib.php";
$cn = connectDB();

$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$user_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['user_id']));
$user_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['user_name']));
$email = mysql_real_escape_string(htmlspecialchars($_REQUEST['email']));
$password = mysql_real_escape_string(htmlspecialchars($_REQUEST['password']));
$role_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['role_id']));
$cp_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['cp']));

if(isset($action_id) && $action_id !="")
{
	if($action=="update")
	{
		   
		    $qry="select PASSWORD from tbl_user where user_id='$action_id'";
			$res = Sql_exec($cn,$qry);
			$dt = Sql_fetch_array($res);
			$encrypt_password=$dt['PASSWORD'];
			$inserted_password="";
			if($encrypt_password==$password)
			{
			   $inserted_password=$password; 	
			}else{
			
			   $inserted_password= encrypt($password); 	
			}
		    $quary="update tbl_user set UserID='$user_id', UserName='$user_name', Email='$email', PASSWORD='$inserted_password',role_id='$role_id',cp_id ='$cp_id'
			where user_id='$action_id'";
		    
			$res = Sql_exec($cn,$quary);
		    if($res)
			{
				$quary="select image from tbl_user where user_id='$action_id'";
				$res = Sql_exec($cn,$quary);
				$dt = Sql_fetch_array($res);
				$prev_path=$dt['image'];		
				if(isset($_FILES['file']['name']))
				{
					if(unlink("../../".$prev_path))  // unlink the existing file
					{
					
						$file_name=$_FILES['file']['name'];
						$path_info=pathinfo($file_name);
						$extension=$path_info['extension'];
						//move the selected file
						 move_uploaded_file($_FILES['file']['tmp_name'], "../../images/user/".$action_id.".".$extension); 
						 $path="images/user/".$action_id.".".$extension;
						 $quary="update tbl_user set image='$path' where user_id='$action_id'";
			             $res = Sql_exec($cn,$quary);
					
					}else{  // prev_path does not exist
						
						 $file_name=$_FILES['file']['name'];
						 $path_info=pathinfo($file_name);
						 $extension=$path_info['extension'];
						//move the selected file
						 move_uploaded_file($_FILES['file']['tmp_name'], "../../images/user/".$action_id.".".$extension); 
						 $path="images/user/".$action_id.".".$extension;
						 $quary="update tbl_user set image='$path' where user_id='$action_id'";
			             $res = Sql_exec($cn,$quary);
					}
				}else{
					
					   // keep existing image file
					   // so we dont need to change the image field of tbl_user table here
				}
				
				
				echo 0;
			}else {
				echo 1;
			}
			
     	
	}else if($action=="delete"){
		    
			$quary="select image from tbl_user where user_id='$action_id'";
			$res = Sql_exec($cn,$quary);
			$dt = Sql_fetch_array($res);
			$prev_path=$dt['image'];
			
			$quary="delete from tbl_user where user_id='$action_id'";
			$res = Sql_exec($cn,$quary);
		    if($res)
			{
			    unlink("../../".$prev_path);
				//echo "danial from delete";
				echo 0;	
			}else{
			    echo 1;	
			}
	    	
	}
	
	
}else if($action_id==""){
	   
	   
	   if($action=="insert" && isset($user_name) && isset($role_id) && $user_id!="" && $user_name!=""  && 
	$password!=""){
		
			$quary="SELECT user_id FROM tbl_user ORDER BY user_id DESC LIMIT 1";
			$res = Sql_exec($cn,$quary);
			$dt = Sql_fetch_array($res);
			$max_id=$dt['user_id'];
			$max_id++;
			$pass=encrypt($password);
			
			$file_name=trim($_FILES['file']['name']);
			$path_info=pathinfo($file_name);
			$extension=$path_info['extension'];
			$image="images/user/".$max_id.".".$extension;
			
			if(move_uploaded_file($_FILES['file']['tmp_name'], "../../".$image))
			{
				$quary="insert into tbl_user(user_id,UserID,UserName,Email,PASSWORD,image,LastUpdate,role_id,cp_id) 
				values('$max_id','$user_id','$user_name','$email','$pass','$image',NOW(),'$role_id','$cp_id')";
				$res = Sql_exec($cn,$quary);
				if($res) echo 0;
				else echo 1;
			}else{
				$quary="insert into tbl_user(user_id,UserID,UserName,Email,PASSWORD,LastUpdate,role_id,cp_id) 
				values('$max_id','$user_id','$user_name','$email','$pass',NOW(),'$role_id','$cp_id')";
				$res = Sql_exec($cn,$quary);
				if($res) echo 0;
				else echo 2;
			}
		
		
	}else{
		echo 3;
	}
	
	
     
}
ClosedDBConnection($cn);

?>