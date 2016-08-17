<?php
session_start();
require_once "../.././service_config.php";

$msisdn = htmlspecialchars($_REQUEST['msisdn_service']);
$service = htmlspecialchars($_REQUEST['service_name']);
$purpose = htmlspecialchars($_REQUEST['purpose']);
$USER_ID = htmlspecialchars($_SESSION['USER_ID']);

if($service == "all"){
	if($purpose == "register"){
		$response = file_get_contents($register_all.$msisdn);
		$response_arr = explode("|",$response);
		$response_result = '';
		foreach($response_arr as $per_service){
			if(trim($per_service)!="-1" ){
				$per_service_arr = explode(",",$per_service);
			
			 // if(trim($per_service_arr[1])!="-1"){
				// echo $per_service_arr[1];
				$response_result .= $per_service_arr[0] . " -> ";
				if(trim($per_service_arr[1])=="0"){
					$response_result .= "Success";
				} else if(trim($per_service_arr[1])=="1"){
					$response_result .= "Already Regisered";
				} else {
					$response_result .= "Failed";
				} 
				$response_result .= "\n";
			}
			
		}
	} else if($purpose == "deregister"){
		$response = file_get_contents($deregister_all.$msisdn);
		$response_arr = explode("|",$response);
		$response_result = '';
		foreach($response_arr as $per_service){
			if(trim($per_service)!="-1" ){
				$per_service_arr = explode(",",$per_service);
			// if(trim($per_service_arr[1])!="-1" ){
				$response_result .= $per_service_arr[0] . " -> ";
				if(trim($per_service_arr[1])=="0"){
					$response_result .= "Success";
				} else if(trim($per_service_arr[1])=="1"){
					$response_result .= "Failed";
				} 
				$response_result .= "\n";
			} else {
				$response_result .= "No service found\n"; 
			}
			
		}
	} else if($purpose == "block"){
		$response = file_get_contents($block_all.$msisdn);
		
		$response_result = '';
		if(intval($response) == 0 ){
			$response_result = 'Successfully blocked';
		} else if(intval($response) == 1 ){
			$response_result = 'Already in the list';
		} else if(intval($response) == 2 ){
			$response_result = 'Submit failed';
		}
		
	} else if($purpose == "unblock"){
		$response = file_get_contents($unblock_all.$msisdn);
		
		$response_result = '';
		if(intval($response) == 0 ){
			$response_result = 'Remove from block list';
		} else if(intval($response) == 1 ){
			$response_result = 'Submit failed';
		} else if(intval($response) == 2 ){
			$response_result = 'Not found in the list';
		}
	}
	
	
	echo $response_result;
} else {
	echo "Sorry, your searching service is not available now. Please try again later.";	
}
	
?>