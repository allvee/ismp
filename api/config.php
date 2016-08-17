<?PHP
$dbtype="mysql";
$Server="localhost";
$UserID="root";
$Password="nopass";
$Database="ismp";
$ShortCode="9144";
$TONDefault="5";
$NPIDefault="0";
$typeDefault="TEXT";
$codingDefault="0";

error_reporting(0);

function ConnectDB()
{
	
	global $dbtype;
	global $sqlconst;
	global $Server;
	global $Database;
	global $UserID;
	global $Password;
	if($dbtype=="mssql")
	{
		
		$cn=odbc_connect("Driver={SQL Server};Server=$Server;Database=$Database","$UserID", "$Password");
		if(!$cn)
			return ("ERR|db connection error");
		else
			return $cn;

		return $cn;
	}
	else
	{
			
		$cn=mysql_connect($Server,$UserID,$Password);
		mysql_select_db($Database);
		if(!$cn)
			return ("ERR|db connection error1 mysql");
		else
			return $cn;

		return $cn;	
	}

}

function getShortCode()
{
	global $ShortCode;
	return $ShortCode;
}

function ClosedDBConnection($cn)
{
	global $dbtype;
	if($dbtype == 'mssql')
		odbc_close($cn);
	else
		mysql_close();
}

function Sql_exec($cn,$qry)
{
	global $dbtype;

	if($dbtype == 'mssql')
	{
		$rs=odbc_exec($cn,$qry);
		if(!$rs)
			return ("ERR|".$qry);
		else
			return $rs;
	}
	else
	{
		
		$rs=mysql_query($qry,$cn);
		if(!$rs)
			return ("ERR|".$qry);
		else
			return $rs;
	}	
}

function Sql_fetch_array($rs)
{
	global $dbtype;
	if($dbtype == 'mssql')
		return odbc_fetch_array($rs);
	else
		return mysql_fetch_array($rs);
}

function Sql_Result($rs,$ColumnName)
{
	global $dbtype;

	return $rs[$ColumnName];
}

function Sql_Num_Rows($result_count)
{
	global $dbtype;
	if($dbtype == 'mssql')
	{
		$cnt=0;
		while(odbc_fetch_row($result_count))
		{
			$cnt++;
		}
		return $cnt;
	}
	else
	{
		
		return mysql_num_rows($result_count);
	}
}
?>
