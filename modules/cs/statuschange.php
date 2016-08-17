<?php
if(isset($_POST['call_url'])){
	$call_url = $_POST['call_url'];
	
	$response = file_get_contents($call_url);
	// echo $response;
	if($response==0){
		echo "Submit successfully";
	} else {
		echo "Submit failed";
	}
}

?>