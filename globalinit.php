<?php
session_start();

//print_r($_SESSION);
$globalmsg = "";

include_once "commonlib.php";

scatterVars($_SESSION);
scatterVars($_GET);
scatterVars($_POST);


$FORM = stripslashes($FORM);
$INITFILE = stripslashes($INITFILE);



if ($FORM == "")
{
    $FORM = "defaultbody.php";
}
if ($IsLoggedIn != "YES" && $CHECK_LOGIN == "YES")
{
    //echo "not login";
    header("Location: $LOGIN_URL");
}
if ($CONNECT_DB == "YES") {
    $cn = ConnectDB();
    if (!$cn) {
        echo("Cannot connect to server (($MYSERVER) with error: " . Sql_Error());
        die();
    }
}
$MYNAME = "index.php";

if ($INITFILE != "")
    include $INITFILE;

if ($INITFILE == "" || !isset ($PRE_ACTION_NAME) || $PRE_ACTION_NAME($CMD, $MODE) == true) {
    if ($CMD != "") {
        $qryvar = $CMD . "_QRY";
        If (Sql_exec($cn, $$qryvar)) {
            $globalmsg = $CMD . " Successfully";
        } else {
            $globalmsg = $CMD . " Failed";
        }
        
    }

    if ($MODE == "LOAD") {
        $rs = Sql_exec($cn, $LOAD_QRY);
        scatterFields($rs, "");
    }
    $tmpvar = "" . $KEYFIELD;
    $tmpval = $$tmpvar;
    $LOAD_ACTION = "$MYNAME?CMD=UPDATE&MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$KEYFIELD=$tmpval";
    $_ACTION = "$MYNAME?CMD=INSERT&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD";

    $actionvar = $MODE . "_ACTION";
    $ACTION = $$actionvar;
    if ($INITFILE != "" && isset ($POST_ACTION_NAME))
        $POST_ACTION_NAME($CMD, $MODE);
}
?>
