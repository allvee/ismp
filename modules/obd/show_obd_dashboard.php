<?php
session_start();
require_once "../.././commonlib.php";

	
if(isset($_POST['server_id']) && $_POST['server_id'] && isset($_POST['service_id']) && $_POST['service_id']){
	
	
	$cn = connectDB();
	
	$server_id = mysql_real_escape_string(htmlspecialchars($_POST['server_id']));
	$service_id = mysql_real_escape_string(htmlspecialchars($_POST['service_id']));

	$qry = "SELECT * FROM tbl_obd_server_config WHERE id='$server_id'";
	$res = Sql_exec($cn,$qry);
	$dt=Sql_fetch_array($res);
	$dbtype=$dt['db_type'];
	$MYSERVER=$dt['db_server'];
	$MYUID=$dt['db_user'];
	$MYPASSWORD=$dt['db_password'];
	$MYDB=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$remoteConnection = connectDB();
	$qry="SELECT OutDialStatus, COUNT(*) as num FROM outdialque WHERE UserId='$service_id' GROUP BY OutDialStatus ORDER BY OutDialStatus ASC";
	$res = Sql_exec($remoteConnection,$qry);
	if(Sql_Num_Rows($res)>0)
	{
		 $str_val='<h2>Status Report</h2>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcss">
            <tr>
              <td>Status</td>
              <td>Count</td>
              <td>Operation</td>
            </tr>';
       
	    	while($dt=Sql_fetch_array($res))
			{
			
				$str_val.='<tr><td>'.$dt["OutDialStatus"].'</td><td>'.$dt["num"].'</td>';
				if($dt["OutDialStatus"]=="QUE")
					$str_val.='<td><a id="'.$dt["OutDialStatus"].'" href="#" class="tbtn">STOP</a></td>';
				else 
					$str_val.='<td><a id="'.$dt["OutDialStatus"].'" href="#" class="tbtn">DOWNLOAD</a></td>';
				
				$str_val.='</tr>';	
				
			}
			
			$str_val.='</table>';
			echo $str_val;
			
	}else{
	     
		 echo 0;	
	}
		
		
	if($remoteConnection)ClosedDBConnection($remoteConnection);	 
	

}
?>
<script type="application/javascript">
$(".tbtn").click(function(){
	
		 if($(this).html()=="DOWNLOAD")
		 {
			 var server_id=get_value("#server_id");
			 var service_id=get_value("#service_id");
			 var status=$(this).attr('id');
			 
			 var data = "action=download&server_id="+server_id+"&"+"service_id="+service_id+"&status="+status;
					//alert("value :"+value);
					//header("Location: report/downloadDND.php?action_id="+value);
					location.href="modules/obd/obd_dashboard_operation.php?"+data;
			 
		 }else if($(this).html()=="STOP")
		 {
			 var server_id=get_value("#server_id");
			 var service_id=get_value("#service_id");
			 var status=$(this).attr('id');
			 
			 var data = "action=stop&server_id="+server_id+"&"+"service_id="+service_id+"&status="+status;
			// location.href="modules/obd/obd_dashboard_operation.php?"+data;
			 
			 var res="";
			 var r=confirm("Are you sure you want to Stop?");
			 if(r==true){
				 $.post("modules/obd/obd_dashboard_operation.php",data,function(response){
								if(response == 0){
									 //alert("Operation Completed Successfully");
									//$("#"+id).parent("td").parent("tr").css("display","none");
									
									res=response;
									
								} else {
									//alert("Operation failed");
								}
							});
			 }						
						
			if(res==0){
				var resPonse=show_obd_dashboard();
				if(resPonse==0){
				
					  $(".subsection").html("No Data Available");
				}else{
					$(".subsection").html(resPonse);
				}
			}
		 }
});

</script>