<?php
include_once "../../commonlib.php";
$value_arr = array();

$cn = connectDB();
$category_id=mysql_real_escape_string(htmlspecialchars($_POST['category_id']));

$qry="select rs.request_source_id,rs.source_name, rs.default_format 
				    FROM tbl_cms_requestsource rs
					INNER JOIN tbl_cms_category_requestsource crs
					ON rs.request_source_id=crs.requestsource_id
					INNER JOIN tbl_cms_category catg
					ON catg.id=crs.category_id
					where crs.category_id='$category_id'
		";

$rs = Sql_exec($cn, $qry);
$html="";
//$count=0;
while($dt=Sql_fetch_array($rs))
{
	 $html.='<input name="'.$dt['request_source_id'].'" id="'.$dt['request_source_id'].'" type="file"/>'.'<span style="position:relative;left:-140px;">'.'( '.$dt['source_name'].':'.$dt['default_format'].' )'.'</span>';
	// $count++;
}

ClosedDBConnection($cn);

echo $html;
?>