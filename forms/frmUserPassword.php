<script type="text/javascript" src="js/ajaxupload.3.5.js" ></script>
<style>
.errorInput {
	border-color:red;
}
</style>
<script>
	$(document).ready(function() {
		$("#dial_menu").hide();
		$(".fancybox").fancybox();
		// Password CHange
        $("#update_pass").click(function() {
			var user_name = $("#user_name").val();
			var c_pass = $("#c_pass").val();
			var n_pass = $("#n_pass").val();
			var rt_pass = $("#rt_pass").val();
			
			if(c_pass == "" || n_pass == "" || rt_pass == ""){
				alert(err_msg1);
				return false;
			}
			
			if(c_pass == n_pass){
				alert("Both current & new passwords are same");
				return false;
			}
			if(n_pass != rt_pass){
				alert("New & Retype password are not same");
				return false;
			}
			
			var user_data = "user_name="+user_name+"&c_pass="+c_pass;
			$.ajax({
				type: "POST",
				url: "check_password.php",
				data: user_data,
				cache: false,
				success: function(response){
					if(response == 1){
						alert("Wrong password");
						return false;
					} else {
						if(n_pass != rt_pass){
							alert(err_msg4);
							return false;
						}
						
						var data = "user_name="+user_name+"&n_pass="+n_pass;
						$.post("update_password.php",data,function(res){
							if(res == 0){
								alert(err_msg2);
								$("#c_pass,#n_pass,#rt_pass").val("");
							} else {
								alert(err_msg3);
							}
						});
					}
				}
			});
        });
		
		$("#rt_pass").blur(function() {
			$("#n_pass,#rt_pass").removeClass("errorInput");
            var n_pass = $("#n_pass").val();
			var rt_pass = $("#rt_pass").val();
			if(n_pass != rt_pass){
				$("#n_pass,#rt_pass").addClass("errorInput");
			}
        });
		
		// RESET 
		$("#reset").click(function() {
            var response = confirm("Are you sure you want to RESET your system?");
			if(response){
				var data = "action=reset&version=1&version_name=1.0.0";
				var new_window_features = 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=600';
				window.open('upgrade/upgradeprocess.php?'+data, 'ROLLBACK', new_window_features );
				return false;
			}
        });
		
		// Auto Upgrade
		$("#auto_upgrade").click(function() {
			var auto_upgrade = "";
            if($('#auto_upgrade').is(":checked")){
				auto_upgrade = "yes";
			} else {
				auto_upgrade = "no";
			}
			var data = "auto_upgrade="+auto_upgrade;
			$.post("update_auto_upgrade_status.php",data,function(res){
				/*if(res == 0){
					alert(err_msg2);
				} else {
					alert(err_msg3);
				}*/
			});
        });
		
		// Rollback
		$(".pr_version").click(function() {
            var id_val = $(this).attr("id");
			var id = $.trim(id_val.split("_")[1]);
			var version_name = $.trim($("#"+id_val).html().split("#")[1]);
			var response = confirm("Are you sure you want to rollback to version "+version_name+"?");
			if(response){
				var data = "action=rollback&version="+id+"&version_name="+version_name;
				var new_window_features = 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=600';
				window.open('upgrade/upgradeprocess.php?'+data, 'ROLLBACK', new_window_features );
				$.fancybox.close();
				$("#"+id_val).hide();
				return false;
			}
        }); 
		
		var iphone3file = $('#restore');
						new AjaxUpload(iphone3file, {
							action: 'upgrade/upload_script.php',
							name: 'uploadfile',
							/*data: {
								resolution : $('#iphone3GImageSize').html()
							},*/
							onSubmit: function(file, ext){
								 if (! (ext && /^(sql)$/.test(ext))){ 
									// extension is not allowed 
									//$("#iphone3Image").empty().append(uniqueAlertMsg14);
									alert("Wrong File Format");
									return false;
								} else{
									$("#loading").show();
								}
								
							},
							onComplete: function(file, response){
								$("#loading").hide();
								alert(response);
							}
						});
    });
</script>
	<h1>Settings </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">Settings</a></li>
			
		</ul>
	</div>
	<div class="content">
		<div class="clear">
		</div>
            <table  width="100%" border="0" cellspacing="0" cellpadding="0"  class="tblcss" >
                <tr class="alignleft">
                    <td colspan="2"><h2>Change Password </h2></td>
                </tr>
                <input type="hidden" name="user_name" value="<?php echo $_SESSION["LoggedInUserID"]; ?>" id="user_name">
                
                <tr>
                    <td>Current Password</td><td><input type="password" name="c_pass" value="" id="c_pass"></td>
                </tr>
                <tr>
                    <td>New Password</td><td><input type="password" name="n_pass" value="" id="n_pass"></td>
                </tr>
                <tr>
                    <td>Re-type Password</td><td><input type="password" name="rt_pass" value="" id="rt_pass"></td>
                </tr>
                <tr>
                	<td colspan="2"><a href="#" class="tbtn" id="update_pass">Update</a></td>
                </tr>
            </table>
        </div>
        <?php
			//$rs=Sql_fetch_array(Sql_exec($cn,"Select auto_upgrade from ugw_version.version where is_active='active'"));
		//	$auto_upgrade = $rs['auto_upgrade'];
		?>
        <div class="tblcss">
            <table  width="100%" border="0" cellspacing="0" cellpadding="0"  class="tblcss" >
                <tr class="alignleft">
                    
                </tr>
                <tr>
                    <td>Automatic Upgrade to new version</td>
                    <td>
                    	<input type="checkbox" name="auto_upgrade" id="auto_upgrade" <?php if($auto_upgrade=="yes"){ echo 'checked="checked"'; } ?>  />
                    </td>
                </tr>
                <tr>
                    <td>System Rollback on previous version (if exists)</td><td><a href="#inline1" class="tbtn fancybox" id="rollback">ROLLBACK</a></td>
                </tr>
                <tr>
                    <td>System Reset</td><td><a href="#" class="tbtn" id="reset">RESET</a></td>
                </tr>
                <tr>
                    <td>System Backup</td><td><a href="upgrade/download_script.php" class="tbtn" id="backup">Backup</a></td>
                </tr>
                <tr>
                    <td>System Restore</td><td><input name="ufile" type="file" size="40" class="tbtn" id="restore"/></td>
                </tr>
            </table>
        </div>
      </div>
    </div>
    <div id="inline1" style="width:400px;display: none;">
    	<?php
			/*$qry = "Select distinct version_name, curr_version from ugw_version.version where is_active='inactive' and curr_version not in (select curr_version from ugw_version.version where is_active='active')";
			$rs = Sql_exec($cn,$qry);
			$count_arr = 0;
			while($dt = Sql_fetch_array($rs)){
				if($count_arr == 0) echo '<h3>Previous Available Version(s)</h3>';
				echo '<p><a href="#" class="pr_version" id="pr_'.$dt['curr_version'].'">Version #'.$dt['version_name'].'</a></p>';
				$count_arr++;
			}
			if($count_arr == 0) echo '<h3>No Version Available</h3>';*/
		?>
	</div>