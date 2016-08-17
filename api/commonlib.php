<?PHP
include_once("config.php");
function update($table,$set,$where,$cn)
{
    $qry="update $table set $set where $where";
    $rs=Sql_exec($cn,$qry);
	if(substr($rs,0,3)<>"ERR")
		return 1;
	else 
		return $rs;
}
function delete($table,$where,$cn)
{
    if($where=="")
		$qry="delete from $table";
	else
		$qry="delete from $table where $where"; //echo "<br>$qry";
    $rs=Sql_exec($cn,$qry);
	if(substr($rs,0,3)<>"ERR")
		return 1;
	else 
		return $rs;
}
function insert($table,$fields,$values,$cn)
{
    if($fields=="")
		$qry="insert into $table values ($values)";
	else
		$qry="insert into $table ($fields) values ($values)"; //echo "<br>$qry";

    $rs=Sql_exec($cn,$qry);
	if(substr($rs,0,3)<>"ERR")
		return 1;
	else 
		return $rs;
}
function select($table,$field,$where,$cn)
{
	 if($table=="")
		$qry="select $field as data";
	 else if($where=="")
		$qry="select $field as data from $table";
	 else
		$qry="select $field as data from $table where $where";	 //echo "<br>$qry";
    $rs=Sql_exec($cn,$qry);												
	if(substr($rs,0,3)<>"ERR")
	{
		$arr=Sql_fetch_array($rs);
		$data=Sql_Result($arr,"data"); 									
		return trim($data);
	}
	else
	    return $rs;
}
function GetProperty($pname)
{
	global $cn;
	$qry="select pValue as data from ApplicationSetting where PropertyName='$pname'";
    $rs=Sql_exec($cn,$qry);
	if(substr($rs,0,3)<>"ERR")
	{
		$arr=Sql_fetch_array($rs);
		$data=Sql_Result($arr,"data");
		return trim($data);
	}
	else
	    return $rs;
}
function exec_query($qry,$cn)
{
	$rs=Sql_exec($cn,$qry);												//echo "$qry   ";
	if(substr($rs,0,3)<>"ERR")
	{									//echo "$data<br>";
		return 1;
	}
	else
	    return $rs;
}
function selectlist($table,$field,$where,$cn)
{
	 if($where=="")
		$qry="select $field as data from $table";
	 else
		$qry="select $field as data from $table where $where";
    $rs=Sql_exec($cn,$qry);
	if(substr($rs,0,3)<>"ERR")
	{	$data="";
		while($arr=Sql_fetch_array($rs))
		{	
			$val=Sql_Result($arr,"data");
			$data=$data."|".$val;
		}
		$data=substr($data,1);
		return trim($data);
	}
	else
	    return $rs;
}
function exec_function($fn_name,$param,$cn)
{
	$qry="select dbo.$fn_name($param) data";
	$rs=Sql_exec($cn,$qry);												//echo "$qry   ";
	if(substr($rs,0,3)<>"ERR")
	{
		$arr=Sql_fetch_array($rs);
		$data=Sql_Result($arr,"data"); 									//echo "$data<br>";
		return trim($data);
	}
	else
	    return $rs;
}
function exec_procedure($pr_name,$param,$cn)
{
	$qry="exec dbo.$fn_name $param ";
	$rs=Sql_exec($cn,$qry);												//echo "$qry   ";
	if(substr($rs,0,3)<>"ERR")
	{
		$arr=Sql_fetch_array($rs);
		$data=Sql_Result($arr,"data"); 									//echo "$data<br>";
		return trim($data);
	}
	else
	    return $rs;
}
?>