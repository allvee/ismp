<?php
set_time_limit(5);
require_once ".././bafconfig.php";

$gateway = $_REQUEST['gateway'];
$status = $_REQUEST['status'];

if($gateway == "sgw"){
//	system("sudo ".$p_of_sgw_maintainance);
	//system("sudo ps -ef|grep signalingGW");
	$return_val = array();
	if($status == "link"){
		system("sudo sh ".$p_of_sgw_maintainance."logsgw.sh");
	} elseif($status == "running"){
		 //system("sudo sh ".$p_of_sgw_maintainance."processsgw.sh");
		
		exec("sh ".$p_of_sgw_maintainance."processsgw.sh",$output,$return);
              $pattern='/(.*)(\.\/signalingGWD)(.*)$/';
		 $array_output=array();
		 // print_r($output);
		 foreach($output as $val){
		    if(preg_match($pattern,$val))
			{
			     array_push($array_output,$val);	
			}	 
		 }
		
		
		 if(!empty($array_output))
		 {
		     $str='<table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
        			<tbody>
            			<tr>
               				<td>UID</td>
                			<td>PID</td>
							<td>PPID</td>
                			<td>C</td>
                			<td>STIME</td>
                			<td>TTY</td>
                			<td>TIME</td>
							<td>CMD</td>
                			
            			</tr>';
						
				foreach($array_output as $val){
					
				     list($uid, $pid, $ppid, $c, $stime,$tty,$ttime,$cmd) = preg_split('/\s+/', $val, 8);
					 $str.="<tr><td>".$uid."</td><td>".$pid."</td><td>".$ppid."</td><td>".$c."</td><td>".$stime."</td><td>".$tty.
					        "</td><td>".$ttime."</td><td>".$cmd."</td></tr>";   	
				}
			 	 
			    $str.="</tbody></table>";
				echo $str;
		 }else{
		        echo '<p style="margin:0;background:yellow;position: absolute;color:red;top: 50%;left: 50%;margin-right: -50%;transform: translate(-50%, -50%)">No Process Exist</p>';	 
		 }
		 
		
	} elseif($status == "start"){
		system("sudo sh ".$p_of_sgw_maintainance."runsgw.sh ");
		//exit;
	} elseif($status == "stop"){
		system("sudo sh ".$p_of_sgw_maintainance."stopsgw.sh");
	}
	//print_r($return_val);
	
} elseif($gateway == "ch"){
	//system("sudo ".$p_of_ch_maintainance);
	if($status == "link"){
		system("sudo sh ".$p_of_ch_maintainance."logch.sh");
	} elseif($status == "running"){
		exec("sh ".$p_of_ch_maintainance."processch.sh",$output,$return);
		// print_r($output);
              $pattern='/(.*)(\.\/callhandler)(.*)$/';
		 $array_output=array();
		 foreach($output as $val){
		    if(preg_match($pattern,$val))
			{
			     array_push($array_output,$val);	
			}	 
		 }

		
		 if(!empty($array_output))
		 {
		     $str='<table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
        			<tbody>
            			<tr>
               				<td>UID</td>
                			<td>PID</td>
							<td>PPID</td>
                			<td>C</td>
                			<td>STIME</td>
                			<td>TTY</td>
                			<td>TIME</td>
							<td>CMD</td>
                			
            			</tr>';
						
				foreach($array_output as $val){
					
				     list($uid, $pid, $ppid, $c, $stime,$tty,$ttime,$cmd) = preg_split('/\s+/', $val, 8);
					 $str.="<tr><td>".$uid."</td><td>".$pid."</td><td>".$ppid."</td><td>".$c."</td><td>".$stime."</td><td>".$tty.
					        "</td><td>".$ttime."</td><td>".$cmd."</td></tr>";   	
				}
			 	 
			    $str.="</tbody></table>";
				echo $str;
		 }else{
		        echo '<p style="margin:0;background:yellow;position: absolute;color:red;top: 50%;left: 50%;margin-right: -50%;transform: translate(-50%, -50%)">No Process Exist</p>';	 
		 }
		 
		// echo json_encode($array_output);
   	} 
        elseif($status == "start"){
		system("sudo sh ".$p_of_ch_maintainance."runch.sh");
	} elseif($status == "stop"){
		system("sudo sh ".$p_of_ch_maintainance."stopch.sh");
	}
} elseif($gateway == "cgw"){
	system("sudo ".$p_of_cgw_maintainance);
	if($status == "link"){
		system("sudo sh ".$p_of_cgw_maintainance."logcgw.sh");
	} elseif($status == "running"){
		// system("sudo sh ".$p_of_cgw_maintainance."processcgw.sh");
		
		exec("sh ".$p_of_cgw_maintainance."processcgw.sh",$output,$return);
              $pattern='/(.*)(\.\/cgw)(.*)$/';
		 $array_output=array();
		 foreach($output as $val){
		    if(preg_match($pattern,$val))
			{
			     array_push($array_output,$val);	
			}	 
		 }

		
		 if(!empty($array_output))
		 {
		     $str='<table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
        			<tbody>
            			<tr>
               				<td>UID</td>
                			<td>PID</td>
							<td>PPID</td>
                			<td>C</td>
                			<td>STIME</td>
                			<td>TTY</td>
                			<td>TIME</td>
							<td>CMD</td>
                			
            			</tr>';
						
				foreach($array_output as $val){
					
				     list($uid, $pid, $ppid, $c, $stime,$tty,$ttime,$cmd) = preg_split('/\s+/', $val, 8);
					 $str.="<tr><td>".$uid."</td><td>".$pid."</td><td>".$ppid."</td><td>".$c."</td><td>".$stime."</td><td>".$tty.
					        "</td><td>".$ttime."</td><td>".$cmd."</td></tr>";   	
				}
			 	 
			    $str.="</tbody></table>";
				echo $str;
		 }else{
		        echo '<p style="margin:0;background:yellow;position: absolute;color:red;top: 50%;left: 50%;margin-right: -50%;transform: translate(-50%, -50%)">No Process Exist</p>';	 
		 }
		 
	} elseif($status == "start"){
		system("sudo sh ".$p_of_cgw_maintainance."runcgw.sh");
	} elseif($status == "stop"){
		system("sudo sh ".$p_of_cgw_maintainance."stopcgw.sh");
	}
} elseif($gateway == "smsgw"){
	system("sudo ".$p_of_smsgw_maintainance);
	if($status == "link"){
		system("sudo sh ".$p_of_smsgw_maintainance."logsmsgw.sh");
	} elseif($status == "running"){
		// system("sudo sh ".$p_of_smsgw_maintainance."processsmsgw.sh");
		
		exec("sh ".$p_of_smsgw_maintainance."processsmsgw.sh",$output,$return);
              $pattern='/(.*)(\.\/sms)(.*)$/';
		 $array_output=array();
		 foreach($output as $val){
		    if(preg_match($pattern,$val))
			{
			     array_push($array_output,$val);	
			}	 
		 }

		
		 if(!empty($array_output))
		 {
		     $str='<table class="tblcss subtbl" cellspacing="0" cellpadding="0" border="0" width="100%">
        			<tbody>
            			<tr>
               				<td>UID</td>
                			<td>PID</td>
							<td>PPID</td>
                			<td>C</td>
                			<td>STIME</td>
                			<td>TTY</td>
                			<td>TIME</td>
							<td>CMD</td>
                			
            			</tr>';
						
				foreach($array_output as $val){
					
				     list($uid, $pid, $ppid, $c, $stime,$tty,$ttime,$cmd) = preg_split('/\s+/', $val, 8);
					 $str.="<tr><td>".$uid."</td><td>".$pid."</td><td>".$ppid."</td><td>".$c."</td><td>".$stime."</td><td>".$tty.
					        "</td><td>".$ttime."</td><td>".$cmd."</td></tr>";   	
				}
			 	 
			    $str.="</tbody></table>";
				echo $str;
		 }else{
		        echo '<p style="margin:0;background:yellow;position: absolute;color:red;top: 50%;left: 50%;margin-right: -50%;transform: translate(-50%, -50%)">No Process Exist</p>';	 
		 }
		 
	} elseif($status == "start"){
		system("sudo sh ".$p_of_smsgw_maintainance."runsmsgw.sh");
	} elseif($status == "stop"){
		system("sudo sh ".$p_of_smsgw_maintainance."stopsmsgw.sh");
	}
}

//echo '1';
?>