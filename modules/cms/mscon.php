<?php
session_start();
$myServer = "localhost";
$myUser = "sa";
$myPass = "Nopass123";
$myDB = "VSDP_CDR";

//connection to the database
$dbhandle = mssql_connect($myServer, $myUser, $myPass)
  or die("Couldn't connect to SQL Server on $myServer");

//select a database to work with
$selected = mssql_select_db($myDB, $dbhandle)
  or die("Couldn't open database $myDB");

//declare the SQL statement that will query the database
$query="select id,MSISDN,Status from dbo.subscriberservices";

//execute the SQL query and return records
$result = mssql_query($query);


$str="<table><thead></thead><tbody>";
//display the results
while($row = mssql_fetch_array($result))
{
  $str.="<tr><td>" . $row["id"] ."</td>". "<td>".$row["MSISDN"]."</td>" . "<td>".$row["Status"]."</td></tr>";
}

$str.="</tbody></table>";
//close the connection
echo $str;
mssql_close($dbhandle);
?> 