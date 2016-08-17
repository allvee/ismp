<?php
require_once "../.././commonlib.php";

function rule_menu_list($cn,$roles_id,$c_parent='root')
{
	if($c_parent=='root') $data_string = "";
	$query="SELECT m.id AS menu_id,
				   rp.menu_permission AS menu_permission,
				   rp.roles_id AS roles_id,
				   m.title AS title, 
				   m.page AS page,
				   m.parent AS parent,
				   m.sub_title AS sub_title,
				   m.image_path AS image_path,
				   m.has_child AS has_child,
				   m.order_by AS order_by,
				   m.is_active AS is_active 
                   FROM tbl_roles_permission AS rp INNER JOIN tbl_menu AS m ON rp.menu_id=m.id WHERE rp.roles_id='".trim($roles_id).
				   "' AND m.parent='".trim($c_parent)."' AND m.is_active='active' order by m.order_by asc";
				   
	$rs=Sql_exec($cn, $query);
	while($dt=Sql_fetch_array($rs)){
		$menu_permission = $dt['menu_permission'];
		$title = $dt['title'];
		$page = $dt['page'];
		$sub_title = $dt['sub_title'];
		$parent = $dt['parent'];
		$image_path = $dt['image_path'];
		$has_child = $dt['has_child'];
		$menu_id=$dt['menu_id'];
					
		if($has_child == 0){
			$data_string .= "<li>";
			    if($menu_permission=='yes')
				{
					$data_string .= '<input type="checkbox" value="'.$menu_id.'" checked="checked" />';
				}else
				{
					$data_string .= '<input  type="checkbox" value="'.$menu_id.'" />';
				}
				
				$data_string .= "<label>".$title."</label>";
				
			$data_string .= "</li>";
		} else {
			$data_string .= "<li>";
				if($menu_permission=='yes') 
					$data_string .= '<input type="checkbox" value="'.$menu_id.'" checked="checked" />'; //
				else 
					$data_string .= '<input type="checkbox" value="'.$menu_id.'" />';
				
				$data_string .= '<label >'.$title.'</label>';
				
				$data_string .= '<ul style="  padding-left:20px;">';
				$data_string .= rule_menu_list($cn,$roles_id,$title);
				$data_string .= '</ul>';
			$data_string .= "</li>";
		}
		
	}
	
	return $data_string;	   
	 
	
}

$cn = connectDB();
$roles_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['roles_id']));
		
echo '<ul style="padding-top:10px;padding-left:25px" id="tree1">'. rule_menu_list($cn,$roles_id,'root') . '</ul>';		
ClosedDBConnection($cn);
?>