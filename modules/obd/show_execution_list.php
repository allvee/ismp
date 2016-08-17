<?php
session_start();
require_once "../.././commonlib.php";

$user_id=$_SESSION["USER_ID"];
$cn = connectDB();
$qry = "SELECT 
				a.id,
				b.name, 
				a.service_id, 
				a.display_no, 
				a.original_no, 
				a.schedule_date, 
				a.prompt_location,
				(SELECT NAME FROM tbl_obd_server_config WHERE id=a.id_operator_distribution) as distribution_list,
				a.status
 		FROM tbl_obd_instance_list a 
		INNER JOIN 
		tbl_obd_server_config b 
		ON a.server_id=b.id 
		WHERE a.user_id='$user_id'";
	
	$res = Sql_exec($cn,$qry);
	if(Sql_Num_Rows($res)>0)
	{
		 $str_val='<table style="font-size:12px;" width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcss">
            <tr>
              <td>ID</td>
              <td>Target Server</td>
              <td>Service</td>
			  <td>Display No</td>
			  <td>Original No</td>
			  <td>OutDial Time</td>
			  <td>Prompt Location</td>
			  <td>Distribution List</td>
			  <td>Status</td>
			  <td></td>
			  <td></td>
            </tr>';
       
	    	while($dt=Sql_fetch_array($res))
			{
			
				$str_val.='<tr>
					<td>'.$dt["id"].'</td>
					<td>'.$dt["name"].'</td>
					<td>'.$dt["service_id"].'</td>
					<td>'.$dt["display_no"].'</td>
					<td>'.$dt["original_no"].'</td>
					<td>'.$dt["schedule_date"].'</td>
					<td>'.$dt["prompt_location"].'</td>
					<td>'.$dt["distribution_list"].'</td>';
				
				if($dt["status"]==0)$str_val.='<td id="'.$dt["id"].'s'.'">Open</td>';
				else if($dt["status"]==1)$str_val.='<td>Cancelled</td>';
				else $str_val.='<td>Closed</td>';
				
				if($dt["status"]==0)
				{
					$str_val.='<td><a id="'.'execute_'.$dt["id"].'" href="#" class="tbtn">Execute</a></td>';
					$str_val.='<td><a id="'.'remove_'.$dt["id"].'"  href="#" class="tbtn">Remove</a></td>';
				}else{
					$str_val.='<td></td>';
					$str_val.='<td></td>';
					
				}
				
				$str_val.='</tr>';
			}
			
			$str_val.='</table>';
			echo $str_val;
			
	}else{
	     
		 echo 1;	
	}
		
		
ClosedDBConnection($cn);
	


?>
<script type="application/javascript">

	

$(".tbtn").click(function(){
	
	     var operation_id=$(this).attr('id');
		 var arr=operation_id.split('_');
		 var operation=arr[0];
		 var id=arr[1];
		 if( operation == "execute"){
			
			 var data = "id="+id+"&"+"action="+operation;
			 var res=null;
			 $.post("modules/obd/obd_execute_operation.php",data,function(response){
								
									
									if(response.substring(0)=='err')
									{
										var r=restore_fields("modules/obd/show_execution_list",null);
										if(r==1){
										}else{
											 $("#view_execution").html(r);
										}
										
									}else{
										res=parseInt(response);
										var r=restore_fields("modules/obd/show_execution_list",null);
										if(r==1){
										}else{
											 $("#view_execution").html(r);
										}
										
										alert("Number of rows inserted: "+res);
									}
										
								
					});
					
			 	
				
				
			 
		  }else if(operation == "remove"){
				
				var res="";
				
				var data = "id="+id+"&"+"action="+operation;
				$.post("modules/obd/obd_execute_operation.php",data,function(response){
									if(response == 0){
										
										
										res=response;
										
									}else{
										//alert("Operation failed");
									}
						});
						
						
				if(res==0){
					 
					 var res=restore_fields("modules/obd/show_execution_list",null);
		 			 if(res==1){
		      		 }else{
			 				$("#view_execution").html(res);
					 }
				}
		} 
			
			
		 
});



</script>