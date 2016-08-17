<script>
	//$( "#loading" ).hide();
	// upgrade version search
		$.ajax({
			type: "POST",
			url: "modules/upgrade/version_check_locally.php",
			data: null,
			cache: false,
			success: function(response){
				var version_update_arr = response.split("|");
				if(version_update_arr[0] == "0"){
					var current_version = version_update_arr[2];
					$.ajax({
						type: "GET",
						dataType : "jsonp",
						url: "<?php echo $UPGRADE_VERSION_SEARCH_URL; ?>?callback=?",
						data: null,
						cache: false,
						success: function(data){
							if(parseInt(data.curr_version) > parseInt(current_version)){
								var dataString = "available_version_name="+data.version+"&available_version="+data.curr_version;
								$.ajax({
									type: "POST",
									url: "upgrade/update_available_version.php",
									data: dataString,
									cache: false,
									success: function(rsp){
										// database available version update
									}
								});
							}
						}
					});
				} else if(version_update_arr[0] == "1"){
					
					$("#upgraded_version_check_result").html("<a href='#' title='System Update' id='upgrade_system_to_new_version' >(<span style='color:#00FFFF;'>New version " + version_update_arr[1] + " available. Update your system now</span>)</a>");
					// UPGRADE Processing
					$("#upgrade_system_to_new_version").click(function() {
						$("#upgraded_version_check_result").empty();
						var data_val = "available_version="+version_update_arr[3]+"&available_version_name="+version_update_arr[1]+"&curr_version="+version_update_arr[2];
						var new_window_features = 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=600';
						window.open('upgrade/upgradeprocess.php?'+data_val, 'Upgrading', new_window_features );
  						return false;
						
						
					});
				}
			}
		});

</script>

    <div class="logoarea">
        <img src="images/logo.png" />
        <span><strong>ISMP : </strong>Configuration & Service Management Portal<i id="upgraded_version_check_result"></i></span> 
    </div>
    <div class="userbtn">
        <ul>
            <li><!--<a href="index.php?FORM=forms/frmUserPassword.php"><img src="images/icon-setting.png"  /></a>--></li>
            <li><a href="loginsession.php"><img src="images/icon-logout.png"  /></a></li>
        </ul>
    </div>
	<div class="user">
    	<?php
			$user_img = Sql_GetField(Sql_exec($cn,"select image from tbl_user where user_id='".$_SESSION['USER_ID']."'"),"image");
			if($user_img != NULL || $user_img != ""){
				echo '<img src="'.$user_img.'" width="43" height="43" />';
			} else {
				echo '<img src="images/profile-picture.png" />';
			}
			echo $_SESSION['LoggedInUserID'];
		?>
    	
    </div>
  
  
	<!--<div class="topbar">
      <ul>
        <li><a href="index.php"><img src="images/icon-dashboard.png"/>dashboard</a></li>
        <li id="upgraded_version_check_result"><li>
        <li class="lispa"><a href="loginsession.php"><img src="images/icon-logout.png"/>logout</a></li>
        <li class="lispa"><a href="index.php?FORM=forms/frmUserPassword.php"><img src="images/icon-setting.png"/>settings</a></li>
      </ul>
    </div>-->
    