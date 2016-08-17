<?php
$services = array(
array(
'ServiceName'=>'MRadio',     
'RegURL'=>'#', 
'DeregURL'=>'#',
'BlockURL'=>'#',
'UnblockURL'=>'#'
),
array(
'ServiceName'=>'News',     
'RegURL'=>'http://10.183.188.120/vsdp/News_2_0/Register.php?sregikey=1&ano=', 
'DeregURL'=>'http://10.183.188.120/vsdp/News_2_0/deRegister.php?ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#'
),
array(
'ServiceName'=>'Religious',     
'RegURL'=>'http://10.183.188.120/vsdp/Religious_Roja/Register.php?ano=', 
'DeregURL'=>'http://10.183.188.120/vsdp/Religious_Roja/deRegister.php?ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#'),
array(
'ServiceName'=>'TvLine',     
'RegURL'=>'http://10.183.188.120/vsdp/Tvline_2_0/Register.php?ano=', 
'DeregURL'=>'http://10.183.188.120/vsdp/Tvline_2_0/deRegister.php?ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#'),

array(
'ServiceName'=>'VoiceChat',  
'RegURL'=>'http://10.183.188.120/vsdp_test/VoiceChat_4_0/CCVoiceChatRegistration.php?ano=', 
'DeregURL'=>'http://10.183.188.120/vsdp_test/VoiceChat_4_0/CCVoiceChatDereg.php?ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#'),
array(
'ServiceName'=>'RadioG',  
'RegURL'=>'http://10.183.188.112/vsdp_test/4878_RadioG_2_1/cms_gui.php?do_ops=1&ano=', 
'DeregURL'=>'http://10.183.188.112/vsdp_test/4878_RadioG_2_1/cms_gui.php?do_ops=2&ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#'),
array(
'ServiceName'=>'Ssdtivr',  
'RegURL'=>'http://10.183.188.112/vsdp_test/2580_Banowat_Short_Circuit_ramadan_1/doReg.php?ano=', 
'DeregURL'=>'http://10.183.188.112/vsdp_test/2580_Banowat_Short_Circuit_ramadan_1/deReg.php?ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#'),
array(
'ServiceName'=>'Popivr',  
'RegURL'=>'http://10.183.188.112/vsdp_test/2008_MobileDrama_4/doReg.php?ano=', 
'DeregURL'=>'http://10.183.188.112/vsdp_test/2008_MobileDrama_4/deReg.php?ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#'),
array(
'ServiceName'=>'Adbox',  
'RegURL'=>'http://10.183.188.112/vsdp_test/16265_Adbox/cms_gui.php?do_ops=1&ano=', 
'DeregURL'=>'http://10.183.188.112/vsdp_test/16265_Adbox/cms_gui.php?do_ops=2&ano=',
'BlockURL'=>'#',
'UnblockURL'=>'#') 	
);

$register_all = "http://localhost/subscriptionservices/RegisterAll.php?operator=BL&channel=CS&cp=&cgwenable=1&msisdn=";
$deregister_all = "http://localhost/subscriptionservices/DeregisterAll.php?operator=BL&channel=CS&cp=&msisdn=";
$block_all = "http://localhost/subscriptionservices/AddBar.php?service=%&msisdn=";
$unblock_all = "http://localhost/subscriptionservices/RemoveBar.php?service=%&msisdn=";

?>