<?php
require_once "../.././commonlib.php";

$roles_id=trim($_POST['roles_id']);

$cn = connectDB();
if(isset($roles_id) && $roles_id)
{
	
	$qry = "SELECT rp.menu_id,m.title,rp.menu_permission FROM tbl_roles_permission AS rp INNER JOIN tbl_menu AS m ON m.id=rp.menu_id WHERE rp.roles_id='".$roles_id."'";
	$res = Sql_exec($cn,$qry);
	//var_dump($res);
	$tbl="<table><tr><td>ID</td><td>Title</td><td>Action</td></tr>";
	while($dt = Sql_fetch_array($res)){
		      
			 $tbl.="<tr><td>".$dt['menu_id']."</td>"."<td>".$dt['title']."</td>";
			 if( $dt['menu_permission']=="yes")
			 {
			     $tbl.='<td><input value='.'"'.$dt['menu_id'].'"'.' type="checkbox" checked></td>';	 
			 } else{
				 
				  $tbl.='<td><input value='.'"'.$dt['menu_id'].'"'.'type="checkbox" ></td>';
			}
			 
			$tbl.="</tr>";
		    // $data=array($dt['menu_id'],$dt['title'],$dt['menu_permission']);
			 
			// array_push($v_arr, $data);
	}
	$tbl.="</table>";
	

}else{
     echo "Error: Post Data not found!!";	
}

ClosedDBConnection($cn);
echo $tbl;
?>