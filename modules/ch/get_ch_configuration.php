<?php
require_once "../.././commonlib.php";

$qry = "select pname,pvalue from tbl_ch_configuration where pname <> 'fixed_line' and is_active='active' order by serial_by asc"; 

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$pname = $dt['pname'];
		$pvalue = $dt['pvalue'];
		$v_arr[$pname] = $pvalue;
	}
	
	ClosedDBConnection($cn);
	
	echo json_encode($v_arr);
?>