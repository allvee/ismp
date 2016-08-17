  <?php
  require_once "../.././commonlib.php";
  session_start();
  $v_arr = array();
  $count = 0;
  $user_id = $_SESSION['USER_ID'];
  $cn = connectDB();
  $remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
  $res = Sql_exec($cn,$remoteCnQry);
  $dt = Sql_fetch_array($res);

  $dbtype=$dt['db_type'];
  $MYSERVER=$dt['db_server'];
  $MYUID=$dt['db_uid'];
  $MYPASSWORD=$dt['db_password'];
  $MYDB=$dt['db_name'];
  ClosedDBConnection($cn);
  $remoteCn=connectDB();

  $qry = "SELECT `id`,`keyword`,`SMSText`,`SrcType`,`URL`,`ShortCode`,`Status` FROM `keyword` WHERE ";
  if(isset($_POST['action_id'])){
	  $action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	  $qry .= " id='$action_id'"; 
  }
	
      $res = Sql_exec($remoteCn,$qry);
	  while($dt = Sql_fetch_array($res)){
		  $v_arr[$count]['keywordHidden'] = $dt['id'];
		  $v_arr[$count]['keyword'] = $dt['keyword'];
		  $v_arr[$count]['SMSText'] = $dt['SMSText'];
		  $v_arr[$count]['SrcType'] = $dt['SrcType'];
		  $v_arr[$count]['URL'] = $dt['URL'];
		  $v_arr[$count]['ShortCode'] = $dt['ShortCode'];
		  $v_arr[$count]['Status'] = $dt['Status'];
				
		  $count++;
	  }
	
	  if($remoteCn)ClosedDBConnection($remoteCn);
	
	  echo json_encode($v_arr);
  ?>