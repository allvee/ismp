
<?php
session_start();
require_once "../.././commonlib.php";


/*function menu_options1($cn,$user_id,$c_parent='root'){
	global $FORM;
	
	$menu_qry = "Select a.menu_permission,b.* from tbl_user_menu a inner join tbl_menu b on a.menu_id=b.id 
	where is_active='active' and a.user_id='".$user_id."' and a.menu_permission > '0' and 
	b.parent='".trim($c_parent)."' order by order_by asc";
	$detector_flag = 0;
	
	$rs=Sql_exec($cn, $menu_qry);
	while($dt=Sql_fetch_array($rs)) {
		$menu_permission = $dt['menu_permission'];
		$title = $dt['title'];
		$page = $dt['page'];
		$sub_title = $dt['sub_title'];
		$parent = $dt['parent'];
		$image_path = $dt['image_path'];
		$has_child = $dt['has_child'];
					
		if($has_child == 0){
			echo "<li>";
				echo "<a href='".$page."'>";
				if($c_parent == "root"){
					echo "<img src='".$image_path."' />".$title."<i>".$sub_title."</i>";
				} else {
					echo '<span>'.$title.'</span>';
				}
				echo "</a>";
			echo "</li>";
		} else {
			echo "<li class=\"has-sub\">";
				echo "<a href='#'>";
				if($has_child == 1) echo "<img src='".$image_path."' />";
				echo $title."<i>".$sub_title."</i></a>";
				echo '<ul id="'.str_replace(" ","-",$title).'"';
				if($has_child >= 2) echo " class='innerLevel'";
				echo '>';
					$detector_flag = menu_options($cn,$user_id,$title);
					
					if($detector_flag == 1){
						echo '<script>$("#'.str_replace(" ","-",$title).'").css("display","block"); $("#'.str_replace(" ","-",$title).'").parent("li").addClass("active");</script>';
					}
				echo '</ul>';
			echo "</li>";
		}
		
		if($c_parent!="root" && $detector_flag == 0){
			if (strpos($page,$FORM) !== false) {
				$detector_flag = 1;	
			}
		}
	}
	
	return $detector_flag;
}
*/

function menu_option($cn,$roles_id,$c_parent='root')
{
	global $FORM;
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
				   "' AND m.parent='".trim($c_parent)."' order by m.order_by asc";
				   
		
		
	$detector_flag = 0;
	
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
			echo "<li>";
			    if($menu_permission=='yes')
				{
					echo '<input value="'.$menu_id.'" type="checkbox" checked="checked"/>';
				}else echo '<input value="'.$menu_id.'"type="checkbox"/>';
				echo "<a style='color:#fff' href='".$page."'>";
				if($c_parent == "root"){
					echo "<i>".$title."</i>";
				} else {
					echo '<span>'.$title.'</span>';
				}
				echo "</a>";
			echo "</li>";
		} else {
			echo "<li class=\"has-sub\">";
				echo "<a href='#' style='color:#fff'>";
				//if($has_child == 1) echo "<img src='".$image_path."' />";
				if($menu_permission=='yes') echo '<input value="'.$menu_id.'" type="checkbox" checked="checked"/>'. $title.'</a>';
				else echo '<input value="'.$menu_id.'" type="checkbox"/>'. $title.'</a>';
				//echo $title."<i>".$sub_title."</i></a>";
				echo '<ul style="padding-left:18px;" id="'.str_replace(" ","-",$title).'"';
				
				
				
				if($has_child >= 2) echo " class='innerLevel'";
				echo '>';
					$detector_flag = menu_option($cn,$roles_id,$title);
					
					if($detector_flag == 1){
						echo '<script>$("#'.str_replace(" ","-",$title).'").css("display","block"); $("#'.str_replace(" ","-",$title).
						'").parent("li").addClass("active");</script>'; 
						
							/*if($menu_permission=='yes')
				            {
					              echo '<script>$("#'.str_replace(" ","-",$title).'").css("display","block")';	
				            }else  echo '<script>$("#'.str_replace(" ","-",$title).'").css("display","none")';*/
						
					}
				echo '</ul>';
			echo "</li>";
		}
		
		if($c_parent!="root" && $detector_flag == 0){
			if (strpos($page,$FORM) !== false) {
				$detector_flag = 1;	
			}
		}
	}
	
	return $detector_flag;	   
	 
	
}



$cn = connectDB();

$roles_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['roles_id']));


/*$query="SELECT m.id AS menu_id,rp.menu_permission AS permission,rp.roles_id AS role_id,m.title AS title, 
m.page AS page,m.parent AS parent,m.sub_title AS sub_title,m.image_path AS image_path,
m.has_child AS child_num,m.order_by AS order_by,m.is_active AS is_active 
FROM tbl_roles_permission AS rp INNER JOIN tbl_menu AS m ON rp.menu_id=m.id WHERE rp.roles_id=$roles_id";


	
			
$res=Sql_exec($cn,$query);

if(Sql_Num_Rows($res)>0)
{
	$data=array();
	while($dt = Sql_fetch_array($res))
	{
			$one_row=array('menu_id'=>$dt['menu_id'],'permission'=>$dt['permission'],'roles_id'=>$dt['roles_id'],
			'title'=>$dt['title'],'page'=>$dt['page'],'parent'=>$dt['parent'],
			'sub_title'=>$dt['sub_title'],'image_path'=>$dt['image_path'],'child_num'=>$dt['child_num'],'order_by'=>$dt['order_by'],
			'is_active'=>$dt['is_active']
			
			);
			
			array_push($data,$one_row);
			
	}
	
	
	
}*/
	
	
	
	
		
echo '<ul class="tree">';
menu_option($cn,$roles_id,'root');		
echo '</ul>';		
ClosedDBConnection($cn);


?>
<script src="js/jquery-checktree.js"></script>
<script src="js/jquery-checktree.js">

$("ul.tree").checkboxTree({
		
		// You can add callbacks to the expand, collapse, check, uncheck, and  halfcheck
		// events of the tree. The element you use as the argument is the LI element of
		// the object that fired the event.
		onExpand: function(el) {
			console.log("expanded ", el.find("label:first").text());
		},
		onCollapse: function(el) {
			console.log("collapsed ", el.find("label:first").text());
		},
		onCheck: function(el) {
			console.log("checked ", el.find("label:first").text());
		},
		onUnCheck: function(el) {
			console.log("un checked ", el.find("label:first").text());
		},
		onHalfCheck: function(el) {
			console.log("half checked ", el.find("label:first").text());
		}  
		/*
		// You can set the labelAction variable to either "check" or "expand" 
		// to change what happens when you click on the label item.
		// The default is expand, which expands the tree. Check will toggle
		// the checked state of the items.
		labelAction: "expand"
		*/
		/*
		// You can also change what happens when you hover over a label (over and out)
		onLabelHoverOver: function(el) { alert("You hovered over " + el.text()); },
		onLabelHoverOut: function(el) { alert("You hovered out of " + el.text()); }
		*/
	});  

</script>