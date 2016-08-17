<?PHP
// Release note: Wraps up database connections and DB access functions - connect/query/result etc.
// Version: 1.0.1
// Date: August 19, 2011
// Author: Minaoar Hossain Tanzil

function connectDB()
{
	
	global $dbtype;
	global $MYSERVER;
	global $MYDB;
	global $MYUID;
	global $MYPASSWORD;

	if ($dbtype=="odbc")
	{ 
		$cn=odbc_connect("Driver={SQL Server};Server=$MYSERVER;Database=$MYDB","$MYUID", "$MYPASSWORD");
		if(!$cn){
			die("err+db (odbc) connection error+".odbc_errormsg());
		}
		else
			return $cn;
			
		return $cn;
	}
	else if($dbtype=="mssql")
	{
		$cn=mssql_connect("$MYSERVER","$MYUID", "$MYPASSWORD");
		$ret=mssql_select_db($MYDB);
			
		if(!$cn) 
			die("err+db (mssql) connection error");
		else
			return $cn;
			
		return $cn;
	}
	else
	{
		$cn=mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
		mysql_select_db($MYDB);
			
		if(!$cn) {
			die("err+db (mysql) connection error");
		}
		else
			return $cn;
			
		return $cn;
	}
}

function ClosedDBConnection($cn)
{
	global $dbtype;
	if($dbtype == 'odbc')
		odbc_close($cn);
	else if($dbtype == 'mssql')
		mssql_close($cn);
	else
		mysql_close();
}

function Sql_exec($cn,$qry)
{
	global $dbtype;

	if($dbtype == 'odbc')
	{
		$rs=odbc_exec($cn,$qry);
		if(!$rs)
			die("err+".$qry);
		else
			return $rs;
	}
	else if($dbtype == 'mssql')
	{
		$rs=mssql_query($qry, $cn);

		if(!$rs) {
			echo(mssql_get_last_message());
			die("err+".$qry);
		}
		else
			return $rs;
	}
	else
	{
		$rs=mysql_query($qry,$cn);
		if(!$rs)
			die("err+".$qry." ".mysql_error());
		else
			return $rs;
	}	
}

function Sql_fetch_array($rs)
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_fetch_array($rs);
	else if($dbtype == 'mssql')
		return mssql_fetch_array($rs);
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
	if($dbtype == 'odbc')
		return odbc_num_rows($result_count);
	else if($dbtype == 'mssql')
		return mssql_num_rows($result_count);
	else	
		return mysql_num_rows($result_count);
	
}

function Sql_GetField($rs,$ColumnName)
{
	 global $dbtype;
	 
	 if($dbtype == 'odbc')
	  return odbc_result($rs, $ColumnName);
	 else if($dbtype == 'mssql')
	  return mssql_result($rs, 0, $ColumnName);
	 else
	  return mysql_result($rs, 0, $ColumnName);
}

function Sql_error()
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_errormsg();
	else if($dbtype == 'mssql')
		return mssql_get_last_message();
	else
		return mysql_error();
}

function Sql_Num_Fields($result_count)
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_num_fields($result_count);
	else if($dbtype == 'mssql')
		return mssql_num_fields($result_count);
	else	
		return mysql_num_fields($result_count);
	
}

function Sql_Data_Seek($rs, $pos)
{
	global $dbtype;
	if($dbtype == 'odbc') {
		odbc_fetch_row($rs, $pos);
	}
	else if($dbtype == 'mssql')
		mssql_data_seek($rs, $pos);
	else	
		mysql_data_seek($rs, $pos);
	
}

function Sql_Fetch_Field($rs, $fld)
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_field_name($rs, $fld);
	else if($dbtype == 'mssql')
		return mssql_field_name($rs, $fld);
	else	
		return mysql_field_name($rs, $fld);
	
}

?>