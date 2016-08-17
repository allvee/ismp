<?php
session_start();
include_once "config.php";
include_once "bafconfig.php";
include_once $LOG_LIB;
include_once $COMMONPHP;

function export_csv_file($title,$data,$filename,$delimiter=",")
{
		
	header("Content-type:text/octect-stream");
	header("Content-Disposition:attachment;filename=$filename");
                                                                
	
	$headStr="";
	foreach($title as $heading)
	{
		if($headStr !="") $headStr.= $delimiter;
	    $headStr.= $heading;
	}
	
	$headStr.= "\n";
	if(!empty($title))print $headStr;
	
	 
	foreach($data as $row)
	{
		$row_str="";
		foreach($row as $key=>$value)
		{
			if($row_str !="") $row_str.= $delimiter;
			$row_str.=$value;
		}
		$row_str.= "\n";
		print $row_str;
	}
	

}


function encrypt($cleartext)
{
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
	
	$key128 = "m!neSec&p@ss9052";
	
		
	$iv 	=  "mY1vkeyw0rd73951";
		
	
	if (mcrypt_generic_init($cipher, $key128, $iv) != -1)
	{
		$cipherText = mcrypt_generic($cipher, $cleartext );
		
		mcrypt_generic_deinit($cipher);
		
		$hexValue = bin2hex($cipherText);
		
		return $hexValue;
	}
	
	return NULL;
}

function menu_option_with_role($cn,$role_id,$c_parent='root')
{
	global $FORM;
	
//	$menu_qry = "Select a.menu_permission,b.* from tbl_user_menu a inner join tbl_menu b on a.menu_id=b.id where is_active='active' and a.user_id='".$user_id."' and a.menu_permission > '0' and b.parent='".trim($c_parent)."' order by order_by asc";
	$detector_flag = 0;
	$user_id = $_SESSION["USER_ID"];
	$menu_query="SELECT * FROM 
                 tbl_menu m INNER JOIN tbl_roles_permission rp
                 ON m.id=rp.menu_id WHERE rp.roles_id='".$role_id."' AND m.parent='".trim($c_parent)."'  AND m.is_active='active'";
	
	if(intval($user_id) != 1) $menu_query .= " AND rp.menu_permission='yes'";			 
	$menu_query .= " order by m.order_by asc";
	
	
	$rs=Sql_exec($cn, $menu_query);
	while($dt=Sql_fetch_array($rs)) {
		//$menu_permission = $dt['menu_permission'];
		$title = $dt['title'];
		$page = $dt['page'];
		$sub_title = $dt['sub_title'];
		$parent = $dt['parent'];
		$image_path = $dt['image_path'];
		$has_child = $dt['has_child'];
					
		if($has_child == 0){
			echo "<li>";
				echo "<a href='".$page."'";
					if(strpos($page,$FORM) !== false) {
						echo ' style="color: #e94f31;"';
					}
				echo ">";
				if($c_parent == "root"){
					echo "<img src='".$image_path."' />".$title."<i>".$sub_title."</i>";
				} else {
					echo '<span>'.$title.'</span>';
				}
				echo "</a>";
			echo "</li>";
			
		} else {
			echo "<li class=\"has-sub\">";
				echo "<a href='#'>";
				if($has_child == 1) echo "<img src='".$image_path."' />";
				echo $title."<i>".$sub_title."</i></a>";
				echo '<ul id="'.str_replace(" ","-",$title).'"';
				if($has_child >= 2) echo " class='innerLevel'";
				echo '>';
					$detector_flag = menu_option_with_role($cn,$role_id,$title);
					if($detector_flag == 1){
						echo '<script>$("#'.str_replace(" ","-",$title).'").css("display","block"); $("#'.str_replace(" ","-",$title).'").parents("li").addClass("active");$("#'.str_replace(" ","-",$title).'").parentsUntil("#cssmenu").css("display","block");</script>';
						/*echo '<script>$("#'.str_replace(" ","-",$title).'").css("display","block");';
						for($child_count=0;$child_count<$has_child;$child_count++){
							if($child_count>0) echo '$("#'.str_replace(" ","-",$title).'").parent("li").parent("ul").addClass("active");';
							else echo ' $("#'.str_replace(" ","-",$title).'").parent("li").addClass("active");';
						}
						
						echo '$("#'.str_replace(" ","-",$title).'").parent(li).parent("ul").css("display","block");</script>';*/
					}
					
				echo '</ul>';
			echo "</li>";
		}
		
		
					
		if($c_parent!="root" && $detector_flag == 0){
			if (strpos($page,$FORM) !== false) {
				$detector_flag = 1;	
			}
		}
	}
	
	return $detector_flag;
	
}

function menu_options($cn,$user_id,$c_parent='root'){
	global $FORM;
	
	$menu_qry = "Select a.menu_permission,b.* from tbl_user_menu a inner join tbl_menu b on a.menu_id=b.id where is_active='active' and a.user_id='".$user_id."' and a.menu_permission > '0' and b.parent='".trim($c_parent)."' order by order_by asc";
	$detector_flag = 0;
	
	$rs=Sql_exec($cn, $menu_qry);
	while($dt=Sql_fetch_array($rs)) {
		$menu_permission = $dt['menu_permission'];
		$title = $dt['title'];
		$page = $dt['page'];
		$sub_title = $dt['sub_title'];
		$parent = $dt['parent'];
		$image_path = $dt['image_path'];
		$has_child = $dt['has_child'];
					
		if($has_child == 0){
			echo "<li>";
				echo "<a href='".$page."'>";
				if($c_parent == "root"){
					echo "<img src='".$image_path."' />".$title."<i>".$sub_title."</i>";
				} else {
					echo '<span>'.$title.'</span>';
				}
				echo "</a>";
			echo "</li>";
		} else {
			echo "<li class=\"has-sub\">";
				echo "<a href='#'>";
				if($has_child == 1) echo "<img src='".$image_path."' />";
				echo $title."<i>".$sub_title."</i></a>";
				echo '<ul id="'.str_replace(" ","-",$title).'"';
				if($has_child >= 2) echo " class='innerLevel'";
				echo '>';
					$detector_flag = menu_options($cn,$user_id,$title);
					
					if($detector_flag == 1){
						echo '<script>$("#'.str_replace(" ","-",$title).'").css("display","block"); $("#'.str_replace(" ","-",$title).'").parents("li").addClass("active");$("#'.str_replace(" ","-",$title).'").parentsUntil("#cssmenu").css("display","block");</script>';
					}
				echo '</ul>';
			echo "</li>";
		}
		
		if($c_parent!="root" && $detector_flag == 0){
			if (strpos($page,$FORM) !== false) {
				$detector_flag = 1;	
			}
		}
	}
	
	return $detector_flag;
}

function showListMYSQL($cn, $qry, $pageno=0, $count=0, $url="", $rowstart="<tr>", $rowend="</tr>", $colstart="<td>", $colend="</td>") {
	$rs=mysql_query($qry, $cn);
	$n=mysql_num_fields($rs);

	$N=mysql_num_rows($rs);
	if($count==0) $count=$N;

	$start=$pageno*$count;
	$totalpage=ceil($N/$count)-1;
	mysql_data_seek($rs, $start);
	for($x=$start; $x<$start+$count && $x<$N; $x++){
		$dt=Sql_fetch_array($rs);
		echo($rowstart);
		for($i=0;$i<$n;$i++) {
			$val=$dt[$i];
			echo("$colstart$val$colend");
		}
		echo($rowend);
	}
	$prev=$pageno-1;
	if($prev<0)$prev=0;
	$next=$pageno+1;
	if($next>=$totalpage) $next=$totalpage;
	$totalpage+=1; $pageno+=1;
	$pagingstring="<a href=$url$prev>Previous</a> Page $pageno/$totalpage <a href=$url$next>Next</a>";
	return $pagingstring;
}

function showEntryListMYSQL($cn, $qry, $key,$isEdit, $isDelete,$delKey) {

	global $MYNAME;
	global $FORM;
	global $INITFILE;
	global $KEYFIELD;

	$rs=mysql_query($qry, $cn);

	$n=mysql_num_fields($rs);
        $KEYFIELD = $key; //added newly
	$action="$MYNAME?MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";
	$delaction="$MYNAME?CMD=DELETE&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";
	
	while($dt=Sql_fetch_array($rs)) {
		echo '<tr>';
		
		for($i=0;$i<$n;$i++) {
			$val=$dt[$i];
			echo("<td>$val</td>");
		}
		//if($isEdit == true || $isDelete == true){
		//	echo '<td>';
			if($isEdit == true) echo("<td><a href=$action".urlencode($dt[$key])." class=\"tbtn\">Edit</a></td>");
			if($isDelete == true) echo("<td><a href=$delaction".urlencode($dt[$key]).$delKey." onClick=\"return confirm('Do you really want to Delete?');\" class=\"tbtn\">Delete</a></td>");
			echo '</td>';
		//}
		//echo "</tr>";
	}
}


function showDataEntryListMYSQL($cn, $qry, $key) {

	global $MYNAME;
	global $FORM;
	global $INITFILE;
	global $KEYFIELD;

	$rs=mysql_query($qry, $cn);

	$n=mysql_num_fields($rs);
	$action="$MYNAME?MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";
	$delaction="$MYNAME?CMD=DELETE&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";

	while($dt=Sql_fetch_array($rs)) {
		echo("<tr>");
		for($i=0;$i<$n;$i++) {
			$val=$dt[$i];
			echo("<td>$val</td>");
		}
		echo("<td><a href=$delaction".$dt[$key]." onClick=\"return confirm('Do you really want to Delete?');\">Delete</td>");
		echo("</tr>");
	}

}



function showListMSSQL($cn, $qry, $pageno=0, $count=0, $url="", $rowstart="<tr>", $rowend="</tr>", $colstart="<td>", $colend="</td>") {

	$rs=Sql_exec($cn, $qry);
	$n=Sql_Num_fields($rs);

	$N=Sql_Num_Rows($rs);
	if($count==0) $count=$N;

	$start=$pageno*$count;
	$totalpage=ceil($N/$count)-1;
	Sql_Data_Seek($rs, $start);
	for($x=$start; $x<$start+$count && $x<$N; $x++){
		$dt=Sql_fetch_array($rs);
		echo($rowstart);
		for($i=0;$i<$n;$i++) {
			$val=Sql_GetField($rs, $i+1);
			echo("$colstart$val$colend");
		}
		echo($rowend);
	}
	$prev=$pageno-1;
	if($prev<0)$prev=0;
	$next=$pageno+1;
	if($next>=$totalpage) $next=$totalpage;
	$totalpage+=1; $pageno+=1;
	$pagingstring="<a href=$url$prev>Previous</a> Page $pageno/$totalpage <a href=$url$next>Next</a>";
	return $pagingstring;
}

function showEntryListMSSQL($cn, $qry, $key) {

	global	$MYNAME;
	global $FORM;
	global $INITFILE;
	global $KEYFIELD;

	$rs=Sql_exec($cn, $qry);

	$n=Sql_Num_Fields($rs);
	
	$action="$MYNAME?MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";
	$delaction="$MYNAME?CMD=DELETE&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";

	while($dt=Sql_fetch_array($rs)) {
		echo("<tr>");
		for($i=0;$i<$n;$i++) {
			$val=Sql_GetField($rs,$i+1);
			echo("<td>$val</td>");
		}
		echo("<td><a href=$action".Sql_GetField($rs, $key).">Edit</td>");
		echo("<td><a href=$delaction".Sql_GetField($rs,$key).">Delete</td>");
		echo("</tr>");
	}

}

function showEntryList($cn, $qry, $key,$isEdit = true,$isDelete=true,$delKey="") {
	global $dbtype;

	if($dbtype=="mysql")
		showEntryListMYSQL($cn, $qry, $key,$isEdit,$isDelete,$delKey);
	else
		showEntryListMSSQL($cn, $qry, $key,$isEdit,$isDelete);
}

function showList($cn, $qry, $pageno=0, $count=0, $url="", $rowstart="<tr>", $rowend="</tr>", $colstart="<td>", $colend="</td>") {
	global $dbtype;

	if($dbtype=="mysql")
		showListMYSQL($cn, $qry, $pageno, $count, $url, $rowstart, $rowend, $colstart, $colend) ;
	else
		showListMSSQL($cn, $qry, $pageno, $count, $url, $rowstart, $rowend, $colstart, $colend) ;
}


function scatterVars($inp, $prefix=""){
	$keys=array_keys($inp);
	$n=count($keys);
	for($i=0;$i<$n;$i++) {
		$varname=$prefix.$keys[$i];
		global $$varname;
		$$varname=addslashes($inp[$varname]);
	}
}

function clearVars($inp, $prefix=""){
	$keys=array_keys($inp);
	$n=count($keys);
	for($i=0;$i<$n;$i++) {
		$varname=$prefix.$keys[$i];
		global $$varname;
		$$varname="";
	}
}

function scatterFields($rs, $prefix) {
	$n=Sql_Num_Fields($rs);
	$dt=Sql_fetch_array($rs);
	for($i=0; $i<$n; $i++) {
		$name=Sql_Fetch_Field($rs,$i);
		print_r($fld);
		$varname=$prefix.$name;
		global $$varname;
		$$varname=Sql_GetField($rs, $name);
	}
}

function initializeInterface($intr_nam_e){
	$rs = Sql_fetch_array(Sql_exec($cn, "select count(id) as count_intr from tbl_interface where interface_name='$intr_nam_e' and is_active='active'"));
	$count_rs = intval($rs['count_intr']);
				
	if($count_rs){
		$qry_in = "update tbl_interface set ip='', netmask='', gateway='', vlan='none' where interface_name='$intr_nam_e' and is_active='active'";
	} else {
		$qry_in = "insert into tbl_interface (interface_name,ip,netmask,gateway,status,vlan,is_active) ";
		$qry_in .= " values ('$intr_nam_e','','','','none','none','active')";
	}
	Sql_exec($cn, $qry_in);
}

/* backup the db OR just a table */
function backup_tables($cn,$output_file,$tables = '*')
{
	global $MYSERVER;
	global $MYUID;
	global $MYPASSWORD;
	global $MYDB;
	global $LATEST_FILES_BACKUP_PATH;
	
	$mysqlHostName = $MYSERVER;
	$mysqlUserName = $MYUID;
	$mysqlPassword = $MYPASSWORD;
	$mysqlDatabaseName = $MYDB;
	
	$DB_export_cmd="mysqldump --opt -h" .$mysqlHostName ." -u" .$mysqlUserName ." -p" .$mysqlPassword ." " .$mysqlDatabaseName ." --routines > " .$output_file;
	exec($DB_export_cmd,$output1=array(),$worked);
	if($worked == 0){
		log_generator("MySQL DUMP Successfully Done",__FILE__,__FUNCTION__,__LINE__,NULL);
	} else {
		log_generator("MySQL DUMP Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}
}

function shell_file_run(){
	global $SHELL_FILE_URL;
	//global $RESTART_SHELL_FILE_URL;
	
	$command = "sudo sh ".$SHELL_FILE_URL;
	
	try {
		log_generator("SHELL FILE Execution START",__FILE__,__FUNCTION__,__LINE__,NULL);
		//chmod($SHELL_FILE_URL,777);
		system($command);
		log_generator("SHELL FILE Execution END",__FILE__,__FUNCTION__,__LINE__,NULL);
	//	log_generator("System RESTART START",__FILE__,__FUNCTION__,__LINE__,NULL);
		//chmod($RESTART_SHELL_FILE_URL,777);
		//system("sudo sh ".$RESTART_SHELL_FILE_URL);
		//log_generator("System RESTART END");
	} catch (Exception $e){
		log_generator("SHELL FILE Execution Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}	
}

    //Pagination
	function pagination_all_page($options = array()){
		global $DELETE_OPTION;
		
		// set defaults
		$defaultOptions = array();
		$content_arr = array();
		
		$defaultOptions['cn'] = '';
		$defaultOptions['count_qry'] = '';
		$defaultOptions['page'] = '1';
		$defaultOptions['per_page'] = '5';
		$defaultOptions['content_arr'] = NULL;
		$defaultOptions['load_qry'] = NULL;
		$defaultOptions['key'] = NULL;
		$defaultOptions['isEdit'] = NULL;
		$defaultOptions['edit_tbl'] = 'edittblname';
		$defaultOptions['isDelete'] = NULL;
		$defaultOptions['extraBtn'] = false;
		$defaultOptions['extraBtnText'] = NULL;
		$defaultOptions['skipLastColumn'] = false;
		$defaultOptions['extraBtnCondition'] = array();
              $defaultOptions['editBtnTxt'] = 'Edit';
		$defaultOptions['deleteBtnText'] = "Delete";
		
		// merge the arrays and have the $options overwrite any $defaultOptions
		$options = array_merge($defaultOptions, $options);
		extract($options);
	   //    print_r($extraBtnCondition);
		$result = Sql_fetch_array(Sql_exec($cn,$count_qry));
       
	   	$count = intval($result[0]);
		$pages = ceil($count/$per_page);
		$start = ($page-1)*$per_page;
		
		if($count == 0){
			echo '<h5 style="color:salmon;">No Data Available</h5>';
		} else {
			echo '<ul class="tsc_pagination tsc_paginationA tsc_paginationA09" style="float:left;">';
        	
				$j=1;
                            $previous=$page-1;
                            $next=$page+1;
                                                     
                            if($page==1){
                                echo '<li><a href="#" id="#" class="first">First</a></li>';                                       
                            } else{
                                echo '<li><a href="#" id="'.$j.'-'.$per_page.'" class="first">First</a></li>';
                            }
                                                    
                            if($previous>0)
                            {
                                echo '<li><a href="#" id="'.$previous.'-'.$per_page.'" class="previous">Previous</a></li>';
                            } else {
                                echo '<li><a href="#" id="#" class="previous">Previous</a></li>';	
                            }
                                                    
                            /* Main page details start*/
                            if($pages > 20){
                                $pageShow = 10;//starting show
                                $pageLimit = $page+$pageShow;
                                                        
                                if($page>6){                // > page 5 or not
                                    echo '<li>...</li>'; 
                                }
                                                        
                                if($pageLimit<$pages){
                                    if($page > 5){
                                        for($i=($page-5); $i<($page+5); $i++)
                                        {
                                            if($i == $page){
                                                $current_class = 'class="current"';
                                            } else {
                                                $current_class = '';
                                            }
                                            echo '<li><a href="#" id="'.$i.'-'.$per_page.'" '.$current_class.'>'.$i.'</a></li>';
                                                                    
                                        }
                                    } else {
                                        for($i=1; $i<=$pageShow; $i++)
                                        {
                                            if($i == $page){
                                                $current_class = 'class="current"';
                                            } else {
                                                $current_class = '';
                                            }
                                                                    
                                            echo '<li><a href="#" id="'.$i.'-'.$per_page.'" '.$current_class.'>'.$i.'</a></li>';	
                                                                    
                                        }
                                    }
                                } else {
                                    for($i=($page-5); $i<=$pages; $i++)
                                    {
                                        if($i == $page){
                                            $current_class = 'class="current"';
                                        } else {
                                            $current_class = '';
                                        }
                                                                
                                        echo '<li><a href="#" id="'.$i.'-'.$per_page.'" '.$current_class.'>'.$i.'</a></li>';	
                                                                
                                    }
                                }
                                                            
                                //for last part after ....
                                if(($pageLimit+1)<=$pages){
                                    echo '<li>...</li>';
                                                            
                                    for($i=($pages-2); $i<=$pages; $i++)
                                    {
                                        echo '<li><a href="#" id="'.$i.'-'.$per_page.'">'.$i.'</a></li>';
                                    }
                                }
                                                            
                            } else {
                                for($i=1; $i<=$pages; $i++)
                                {
                                    if($i == $page){
                                        $current_class = 'class="current"';
                                    } else {
                                        $current_class = '';
                                    }
                                                            
                                    echo '<li><a href="#" id="'.$i.'-'.$per_page.'" '.$current_class.'>'.$i.'</a></li>';	
                                                            
                                }	
                            }
                                                    
                            /* Main page details end*/
                            if($next > $pages)
                            {
                                echo '<li><a href="#" id="#">Next</a></li>';
                            } else {
                                echo '<li><a href="#" id="'.$next.'-'.$per_page.'">Next</a></li>';	
                            }
                                                    
                            if($page == $pages || $pages == 0)
                            {
                                echo '<li><a href="#" id="#" class="last">Last</a></li>';
                            } else {
                                echo '<li><a href="#" id="'.$pages.'-'.$per_page.'" class="last">Last</a></li>';
                            }
		
			echo '</ul>';
			echo '<div style="padding: 6px 2px;">
					<label>Per Page </label>
					<select name="per_page" class="per_page" >
						<option value="5" ';
						if($per_page == 5) echo 'selected="selected"'; 
						echo '>5</option>
						<option value="10" ';
						if($per_page == 10) echo 'selected="selected"'; 
						echo '>10</option>
						<option value="15" ';
						if($per_page == 15) echo 'selected="selected"'; 
						echo '>15</option>
						<option value="30" ';
						if($per_page == 30) echo 'selected="selected"'; 
						echo '>30</option>
						<option value="1000" ';
						if($per_page == 1000) echo 'selected="selected"'; 
						echo '>30+</option>
					</select>';
			echo '</div>';
		
            if($content_arr != NULL && $load_qry != NULL){
				echo '<table cellspacing="0" style="height:auto;">';
                	echo '<tr>';
						for($c_arr=0;$c_arr<sizeof($content_arr);$c_arr++){
							echo '<td>'.$content_arr[$c_arr].'</td>';
						}
						if($isEdit == true) echo '<td></td>';
						if($isDelete == true) echo '<td></td>';
						if($extraBtn == true) echo '<td></td>';
                    echo '</tr>';
                $Select_qry = $load_qry." limit $start,$per_page";
                $rs=Sql_exec($cn,$Select_qry);
				$n=Sql_Num_Fields($rs);
				if ($skipLastColumn == true)
					$n = $n - 1;
				$KEYFIELD = $key; //added newly
				$router_count = 0;
				while($dt=Sql_fetch_array($rs)) {
					$router_count++;
					echo '<tr>';
						
					for($i=0;$i<$n;$i++) {
						$val=$dt[$i];
						echo("<td title='$content_arr[$i]'>$val</td>");
					}
					
					if($isEdit == true || $isDelete == true || $extraBtn==true){
						//echo '<td>';
						if($isEdit == true) echo("<td><a class='tbtn action_post' href='#' id='edit|".$edit_tbl."|".$dt[$key]."'>".$editBtnTxt."</a></td>");
						if($isDelete == true) echo("<td><a class='tbtn action_post' href='#' id='delete|".$edit_tbl."|".$dt[$key]."' >".$deleteBtnText."</a></td>");
						if($extraBtn == true) 
						{
							       $and_condition = 1;
								foreach($extraBtnCondition as $k=>$val)
								{
								    //if(strcmp($dt[$k],$val)==0){
									if(trim($dt[$k]) != trim($val)){
										   $and_condition=0;
										   break;	
									}
								} 
							
						        if( intval($and_condition) == 1 )
							 {
									echo("<td><a class='tbtn action_post' href='#' id='extra|".$edit_tbl."|".$dt[$key]."' >".$extraBtnText."</a></td>");
							 }else{
									echo ("<td></td>");
								}
						}
						//echo '</td>';
					}
					echo "</tr>";
				}
				echo '</table>';
			}
		}
	
	}
?>
