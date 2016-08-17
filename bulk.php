<?php

$msisdn = $_REQUEST['msisdn'];
$single_service_status_url= "http://10.183.188.112/vsdp_test/16235_music_world_1_1/deRegister.php?ano=$msisdn";
$result=file_get_contents($single_service_status_url);
$list=explode("|",$result);
echo $count= $list[0];
echo $channel=$list[12];
echo $chargingplan=$list[16];


?>