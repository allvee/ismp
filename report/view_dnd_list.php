<?php
session_start();

include("../commonlib.php");

$cn = connectDB();
//Receive passing data	
$edit_tbl = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl']));
$page = mysql_real_escape_string(htmlspecialchars($_REQUEST['page']));
$per_page = mysql_real_escape_string(htmlspecialchars($_REQUEST['per_page']));				
	
$user_id = $_SESSION['USER_ID'];
	

if($edit_tbl == "dnd_list"){
	//$count_qry = "select count(id) from tbl_obd_dnd_list";
	$count_qry = "SELECT count(t1.server_id) FROM 
				(SELECT DATE(`time_stamp`) AS `Date`, TIME(`time_stamp`) AS `Time`, `server_id`, COUNT(DISTINCT `msisdn`) AS `cnt`
				FROM `tbl_obd_dnd_list` 
				WHERE `user_id`='".$user_id."'
				GROUP BY `server_id`, DATE(`time_stamp`), TIME(`time_stamp`)
				ORDER BY `server_id` DESC, DATE(`time_stamp`) ASC, TIME(`time_stamp`) ASC 
				 ) AS `t1`";
	$content_arr = array("Serial","Date","Time","Operator","Total");
	//$load_qry = "SELECT DATE(time_stamp), TIME(time_stamp), server_id, COUNT(DISTINCT msisdn) AS cnt FROM tbl_obd_dnd_list WHERE user_id='$user_id' GROUP BY server_id,time_stamp ORDER BY server_id DESC";
	$load_qry = "SELECT @rn:=@rn+1 AS `Serial`,`t1`.`Date`,`t1`.`Time`,`t1`.`server_id`,`t1`.`cnt` , REPLACE(REPLACE(CONCAT(`t1`.`Date`, 'T', `t1`.`Time`, 'S',  `t1`.`server_id`), '-', 'D'), ':', 'C') AS `key`" .
				"FROM " .
				"(SELECT DATE(`time_stamp`) AS `Date`, TIME(`time_stamp`) AS `Time`, `server_id`, COUNT(DISTINCT `msisdn`) AS `cnt`" .
				"FROM `tbl_obd_dnd_list` " .
				"WHERE `user_id`='".$user_id."' " .
				"GROUP BY `server_id`, DATE(`time_stamp`), TIME(`time_stamp`)" .
				"ORDER BY `server_id` DESC, DATE(`time_stamp`) ASC, TIME(`time_stamp`) ASC " .
				" ) AS `t1`,
				(SELECT @rn := 0) AS `t2`";
//				$load_qry = "SELECT @rn:=@rn+1 AS `Serial`,`t1`.`Date`,`t1`.`Time`,`t1`.`server_id`,`t1`.`cnt`, 1 " .
//							" FROM " .
//							"(SELECT DATE(`time_stamp`) AS `Date`, TIME(`time_stamp`) AS `Time`, `server_id`, COUNT(DISTINCT `msisdn`) AS `cnt` " .
//							" FROM `tbl_obd_dnd_list` " .
//							" WHERE `user_id`='$user_id' " .
//							" GROUP BY `server_id`,DATE(`time_stamp`), TIME(`time_stamp`) " .
//							" ORDER BY `server_id` DESC, DATE(`time_stamp`) ASC, TIME(`time_stamp`) ASC " .
//							") AS `t1`,".
//							"(SELECT @rn := 0) AS `t2`";
	//$key = 'server_id';
	$key = 'key';
	$extraBtn = true;
	$extraBtnText = "Download";
} else {
	$count_qry = "";
	$content_arr = NULL;
	$load_qry = "";
	$key = '';
	$extraBtn = false;
}
	
	
		
		// function Parameters
		$options = array();
		$options['cn'] = $cn;
		$options['count_qry'] = $count_qry;
		$options['page'] = $page;
		$options['per_page'] = $per_page;
		$options['content_arr'] = $content_arr;
		$options['load_qry'] = $load_qry;
		$options['key'] = $key;
		$options['isEdit'] = false;
		$options['edit_tbl'] = $edit_tbl;
		$options['isDelete'] = true;	
		$options['extraBtn'] = $extraBtn;
		$options['extraBtnText'] = $extraBtnText;
		$options['skipLastColumn'] = true;
		
					
		pagination_all_page($options);
	
	ClosedDBConnection($cn);		
?>
<script>
	$(document).ready(function() {
		
		// Pagination Javascript
		function page_load(page,per_page){
			var tbl = "<?php echo $edit_tbl; ?>";
			
			var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
			
				$.ajax({
					type: "POST",
					url: "report/view_dnd_list.php",
					data: data,
					cache: false,
					success: function(response){
						$("#view_"+tbl).html(response);
					}
				});
		}
		
		
		$("#view_<?php echo $edit_tbl; ?> ul li a").click(function() {
			var id = $(this).attr("id");
			if(id == "#"){
				return false;
			}
				
			var id_arr = id.split("-");
			var page = id_arr[0];
			var per_page = id_arr[1];
				
			page_load(page,per_page);
		});
		
		$("#view_<?php echo $edit_tbl; ?> select.per_page").bind('change keyup',function() {
			var page = 1;
			var per_page = $("#view_<?php echo $edit_tbl;?> select.per_page :selected").val();
				
			page_load(page,per_page);
		});
	
		// edit,delete operation
		$("#view_<?php echo $edit_tbl; ?> .action_post").click(function() {
			
			//$("#errorMsgSubnet,#errorMsgSubnetHost,#errorMsgSubnetRange").empty();
            var id = $(this).attr('id');
			var id_arr = id.split("|");
			var action = id_arr[0];
			var tbl = id_arr[1];
			var value = id_arr[2];
			
			var trRow = $("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr");
			
			if(action == "edit"){
				$("#action_id").val(value);
				var data = "action="+tbl+"&value="+value;
				
				if(tbl == "dnd_list"){
					get_obd_dnd([ "status" ]);
					set_value("action","update",selector_type_id);
				}
			} else if(action == "delete"){
				r=confirm("Are you sure you want to delete this?");
				
				if (r==true){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "dnd_list"){
						var data = "action=delete&action_id="+value;
						
						$.post("modules/obd/submit_obd_dnd.php",data,function(response){
							if(response == 0){
								alert("Deleted successfully");
								$("#"+action+"\\|"+tbl+"\\|"+value).parent("td").parent("tr").css("display","none");
								
							} else {
								alert("Deletion failed");
							}
						});
					}
				}
			}else if(action == "extra"){
					//var data = "action="+tbl+"&value="+value;
					if(tbl == "dnd_list"){
					var data = "action=download&action_id="+value;
					//alert("value :"+value);
					//header("Location: report/downloadDND.php?action_id="+value);
					location.href="report/downloadDND.php?action_id="+value;
				}
			}
        });
	});


</script>