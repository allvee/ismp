<?php
include_once "../../commonlib.php";
$value_arr = array();
$qry="SELECT cpid,cpname FROM tbl_cms_content_provider ORDER BY cpid ASC";
$cn = connectDB();
$rs = Sql_exec($cn, $qry);

while($dt = Sql_fetch_array($rs))
{
	 $value_arr[$dt['cpid']] = $dt['cpname'];
}

ClosedDBConnection($cn);

echo json_encode($value_arr);
?>