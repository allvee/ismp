<?php
session_start();
include_once "commonlib.php";
$cn = connectDB();
$errMsg = "";
if(isset($_REQUEST["mode"])){
	$mode = mysql_real_escape_string(htmlspecialchars($_REQUEST["mode"]));
	
} else {
	$mode = "";
}


if (!$cn) {
    echo("Cannot connect to server ($server) with error: " . Sql_error());
    die();
}

if ($mode == "LOGIN") {
   $uid = str_replace(" ","",mysql_real_escape_string(htmlspecialchars($_POST["uid"])));
   $pwd = str_replace(" ","",mysql_real_escape_string(htmlspecialchars($_POST["pwd"])));
	
    $qry = "select Password, UserID, user_id, role_id, cp_id from $TBL_USER where UserID='$uid'";
    $rs = Sql_exec($cn, $qry);
    $dt = Sql_fetch_array($rs);
	//echo encrypt($pwd);
    if ($uid = $dt["UserID"] && encrypt($pwd) == $dt["Password"] && $pwd != "") {
        $dt = Sql_fetch_array($rs);
        $_SESSION["IsLoggedIn"] = "YES";
        $_SESSION["LoggedInUserID"] = Sql_GetField($rs, "UserID");
	 	$_SESSION["USER_ID"] = Sql_GetField($rs, "user_id");
	 	$_SESSION["ROLE_ID"] = Sql_GetField($rs, "role_id");
	 	$_SESSION["CP_ID"] = Sql_GetField($rs, "cp_id");
        ClosedDBConnection($cn);
        header("Location: index.php");
    }
	$errMsg = "Access Denied!";
} else if ($mode == "LOGOUT") {
    $_SESSION["IsLoggedIn"] = "NO";
    $_SESSION["LoggedInUserID"] = "";
	$_SESSION["USER_ID"] = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UNIFIED GATEWAY</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
</head>

<body>
<div class="fullwidth">
  <div class="loginpanel">
    <form name="user" method="post" action="login.php">
    <div class="flogo"><img src="images/logo.png" /></div>
    <div class="inputarea">
    <p class="errmsg"><span style="color:red;"><?php echo $errMsg; ?></span></p>
    <p>
        <label for="uid">Username</label>
          <div class="inputbox"><i class="user"></i>
        <input type="text" name="uid" placeholder="Username" >
        </div>
      </p>
      <p>
        <label for="pwd">Password</label>
        <div class="inputbox"><i class="pass"></i>
        <input type="password" name="pwd" placeholder="Password">
        </div>
      </p>
      <input type="hidden" name="mode" value="LOGIN" />
      </div>
      <div class="subtarea"><input type="submit" name="submit" value="Log in"></div>
    </form>
  </div>
</div>
</body>
</html>