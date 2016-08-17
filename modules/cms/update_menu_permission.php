<?php
require_once "../.././commonlib.php";

$cn = connectDB();

$roles_id=mysql_real_escape_string(htmlspecialchars($_POST['roles_id']));


if(isset($_POST) && !empty($_POST) && isset($roles_id) &&!empty($roles_id)){
	
	      
			//echo "id:".$roleid;
			foreach($_POST as $key => $value)
			{
				if($key=='roles_id')
				{
					
				} else{
					$qry="update tbl_roles_permission set menu_permission='$value' where menu_id='$key' and roles_id='$roles_id'";
					$res=Sql_exec($cn,$qry);
				}
			}
			
			echo 0; //true
}else{
        echo 1;	//false:error
}


ClosedDBConnection($cn);

?>