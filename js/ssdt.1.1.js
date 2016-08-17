/**
 * SSD-TECH Javascript Library 
 * Version 1.1 (14.12.2014)
 * Author : Atanu Saha
 * Copyright (c) 2014 SSD-Tech Ltd., http://www.ssd-tech.com
 */

/***************************
 ******  Changeset  ********
 ***************************
 
 ## Version 1.1 ##
 
 1) save_files re-defined
 2) supported file type param integrated into file_upload 
 
 ## Version 1.0 ##
 Initial Stable Version.
 
 **************************************
 **** Functions Documentation *********
 **************************************
 
 >> Function get_value(selector_name)
 	Input : selector_name should be fully defined. 
	Output : value of the selected field
		
 >> Function set_value(selector_name,value,selector_type)
 	Input : 
		selector_name : id,class or html entity name.
		value : your new value.
		selector_type : id/radio
	Output : mentioned field value change. no return value.
	
 >> Function show_hide(show_id,hide_id)
 	Input : 
		show_id : id,class or html entity name (default specified value null).
		hide_id : id,class or html entity name (default specified value null).
	Output : mentioned fields will be show or hide. 

 >> Function pagination(tbl,value_arr,callback_script,show_id,hide_id,param_arr,required_arr)
 	Input : 
		tbl : table name for pagination.
		value_arr : flush field(s) value.
		callback_script : get table data script (calling script name without `.php`).
		show_id : save/update button show
  		hide_id : save/update button hide
  		param_arr : searching parameter if exists. array["Param_name"]="Param_value";
  		required_arr : required param field if we need. ["Param_name_1","Param_name_2"]
	Output : show pagination. 

 >> Function save_files(action,action_id,php_value,value_arr,required_arr,tbl,callback_script,show_id,hide_id)
 	Input : 
		action : insert/update
		action_id : null/row id
		php_value : calling php script for insertion/updating
		value_arr : data
		required_arr : required fields
		tbl : table name for pagination
		callback_script : get table data script
		show_id : save/update button show
		hide_id : save/update button hide
	Output : response message show through alert (Need to change as dynamic design for showing response message within div/alertbox/designed dialog box). 

 >> Function reload_system(callback_url)
 	Input : 
		callback_url : calling php script for reload system
	Output : show a confirmation message box. After confirmation callback_url.php load
	
 >> Function restore_fields(callback_script,condition_arr) - async false
 	Input : 
		callback_script : calling php script for reload system
		condition_arr : condition array for calling php response data
	Output : return response data syncronously
	
 >> Event string.replaceAll(str1,str2)
 	Replace All Related Fields

 >> Function reassign_value(source_host,destination_host,separator,replace_with)
 	Use same value of a field in multiple fields(if necessary) 
	with replacing some substring of field value(string)
	
 >> Function load_list(callback_script,condition_arr)
 	Input : 
		callback_script : calling php script for reload system
		condition_arr : condition array for calling php response data
	Output : return JSON Parse Data for <select> 

 >> Function delete_operation(callback_script,action_id,id)
 	Delete operation called from view page.
 
 >> Function file_upload(trigger,php_script_url,file_id,value_arr,supported_file_type,required_arr,tbl,callback_script,show_id,hide_id,progress_id)
 	Input : 
		trigger : true in case of file upload mendatory, otherwise false.
		php_script_url : where data will be posted.
  		file_id : id of the file input tag.
		value_arr : passing two-dimensional data array.
  		supported_file_type : An allowed extension Array. all value should be LOWER case.
		required_arr : required fields.
		tbl : table name for pagination.
		callback_script : get table data script.
		show_id : save/update button show.
		hide_id : save/update button hide.
  		progress_id : progress_id is the id of parent div tag of one child div tag to show the progress of file upload.
	Output : response message show through alert (Need to change as dynamic design for showing response message within div/alertbox/designed dialog box). 

 >> Function createDropDown(selectId, callback_script, condition_arr, firstText, firstValue)
 	Input : 
		selectId : html select id.
		callback_script : calling php script.
		firstText : first select option's html text.
		firstValue : first select option's value.
	Output : update select option with mentioned data. 
 
 >> Function numeralsOnly(evt)	 
 	Check the field value is numeric or not. return false if not. calling from onKeyPress event.
 
 */


var selector_type_id,selector_type_radio,selector_type_select;
selector_type_id = "id";
selector_type_radio = "radio";
selector_type_select = "select";

/**
 * Get field value
 */
function get_value(selector_name){
	var ret_val;
	if ($(selector_name).length ){ 
		ret_val = $(selector_name).val();
	} else ret_val = "";
	return ret_val;
}

/**
 * Set field value
 */
function set_value(selector_name,value,selector_type){
	if(selector_type == "id"){
		$("#"+selector_name).val(value);
	} else if(selector_type == "radio") {
		$("input[name='"+selector_name+"'][value='" + value + "']").prop('checked', true);
	} else {
		$(selector_name).val(value);
	}
}
 
/**
 * Show/Hide specific boundary(ies)
 */	
function show_hide(show_id,hide_id){
	if(show_id != null) $(show_id).show();
	if(hide_id != null) $(hide_id).hide();	
} 


/**
 **** View page with pagination ****
 * tbl : table name for pagination
 * value_arr : flush field value
 * callback_script : get table data script
 * show_id : save/update button show
 * hide_id : save/update button hide
 * param_arr : searching parameter if exist. array["Param_name"]="Param_value";
 * required_arr : required param field if we need. ["Param_name_1","Param_name_2"]
 */	
function pagination(tbl,value_arr,callback_script,show_id,hide_id,param_arr,required_arr){
	show_id = typeof show_id !== 'undefined' ? show_id : null;
	hide_id = typeof hide_id !== 'undefined' ? hide_id : null;
	param_arr = typeof param_arr !== 'undefined' ? param_arr : null;
	required_arr = typeof required_arr !== 'undefined' ? required_arr : null;
	var required_flag=1;
	
	if(required_arr != null){
		$.each(required_arr,function(i,id){
			if(get_value("#"+id) == ""){ 
			//	alert(err_msg1);
				required_flag=0;
				return false;
			}
		});
	}
	
	if(required_flag){
		if(value_arr != null){
			var field = "";
			$.each(value_arr,function(i,id){
				if(field != "") field += ",";
				field += "#"+id;
			});
			$(field).val("");
		}
		show_hide(show_id,hide_id);
				
		var page = 1;
		var data = "page="+page+"&per_page="+per_page+"&tbl="+tbl;
		if(param_arr != null){
			$.each(param_arr,function(index,id){
				data += '&'+id+'='+get_value("#"+id);
			});
		}
		
		$.ajax({
			type: "POST",
			url: callback_script+".php",
			data: data,
			cache: false,
			success: function(response){
				$("#view_"+tbl).empty().html(response);					
			}
		});
	}
}

/**
 **** Get Specific Table Column List ****
 **** And Push Them ****
 **** Into Specific Field ****
 * callback_script : calling script name
 * data : Passing variables
 * push_id : flush field id
 */
/*function choose_list(callback_script,data,push_id){
	$.post(callback_script+".php",data,function(res){
		$("#"+push_id).html(res);
	});
}*/

/**
 **** Insert/Update ****
 * action : insert/update
 * action_id : null/row id
 * php_value : calling php script for insertion/updating
 * value_arr : data
 * required_arr : required fields
 * tbl : table name for pagination
 * callback_script : get table data script
 * show_id : save/update button show
 * hide_id : save/update button hide
 */
function save_files(action,action_id,php_value,value_arr,required_arr,tbl,callback_script,show_id,hide_id,return_val,encode_field_arr){
	required_arr = typeof required_arr !== 'undefined' ? required_arr : null;
	tbl = typeof tbl !== 'undefined' ? tbl : null;
	callback_script = typeof callback_script !== 'undefined' ? callback_script : null;
	show_id = typeof show_id !== 'undefined' ? show_id : null;
	hide_id = typeof hide_id !== 'undefined' ? hide_id : null;
	return_val = typeof return_val !== 'undefined' ? return_val : false;
	encode_field_arr = typeof encode_field_arr !== 'undefined' ? encode_field_arr : false;
	
	var data = "action="+action+"&action_id="+action_id;
	var required_flag = 1;
		
	$.each(value_arr,function(i,id){
		if(id == "m_select"){ //  for multiple selection
			var m_select = "";
			$( "select#m_select option:selected" ).each(function() {
				 if(m_select) m_select += ",";
				 m_select += $( this ).val();
			});
			data += "&"+i+"="+m_select;
		} else {
			data += "&"+i+"=";
			// alert(i);
			// if(i.toUpperCase() == "URL"){
			if ( ( encode_field_arr != false && $.inArray( id, encode_field_arr ) > -1 )|| i.toUpperCase() == "URL" ){
				data += encodeURIComponent(get_value(id));
				// alert(data); 
			} else {
				data += get_value(id);
			}
			//alert(i);
		}
	});
	
	if(required_arr != null){
		$.each(required_arr,function(i,id){
			if(get_value("#"+id) == ""){ 
				alert(err_msg1);
				required_flag=0;
				return false;
			}
		});
	}
			
	if(required_flag){
		$.ajax({
			type: "POST",
			url: php_value+".php",
			data: data,
			async: false,
			success : function(response) {
		
				if(response == 0){
					if(!return_val) alert(err_msg2);
					if(tbl != null){
						var filter_arr = [];
						$.each(value_arr,function(index,val){
							filter_arr.push(val.replace('#',''));
						});
						pagination(tbl,filter_arr,callback_script,show_id,hide_id);		
					}
				} else {
					alert(err_msg3);
				}
			}
		});	
	}
}

/**
 * Reload Specific Sytem
 */
function reload_system(callback_url){
	var rs = confirm("Are you sure you want to reload?");
	if(rs){
		$.post(callback_url+".php",null,function(response){
			alert(err_msg6);
		});
	}
}

/**
 * Restore fields value
 */
function restore_fields(callback_script,condition_arr){
	var remote;
	var data = "";
	if(condition_arr != null){
		$.each(condition_arr,function(i,id){
			data += id+"="+get_value("#"+id)+"&";
		});
	}
	
    $.ajax({
        type: "POST",
        url: callback_script+".php",
		data: data,
        async: false,
        success : function(res) {
            remote = res;
        }
    });

    return remote;
}

/**
 * Replace All Related Fields
 */
String.prototype.replaceAll = function(str1, str2, ignore){
	return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
}

/**
 * Use same value of a field 
 * in multiple fields(if necessary) 
 * with replacing some substring of field value(string)
 */
function reassign_value(source_host,destination_host,separator,replace_with){
	var HOST = $.trim($(source_host).val());
			
	if(HOST != ""){
		$(destination_host).val(HOST.replaceAll(separator, replace_with));
	}
}

/**
 * Load JSON Data for <select> 
 * var res = load_list("modules/ch/get.php",condition_arr);
 *  $("#selector_id").html( res );
 */
function load_list(callback_script,condition_arr){
	var return_val_arr = restore_fields(callback_script,condition_arr);
    var obj = jQuery.parseJSON( return_val_arr );    
    var str_data = "";
    $.each(obj,function(key, value){
    	str_data  += "<option value='"+key+"'>"+value+"</option>";
	});
                
    return str_data;                
}

/**
 * Delete operation called from view page
 */
function delete_operation(callback_script,action_id,id){
	var data = "action=delete&action_id="+action_id;
                                                                                                
    $.post(callback_script+".php",data,function(response){
    	if(response == 0){
        	alert("Deleted successfully");
            $("#"+id).parent("td").parent("tr").css("display","none");
		} else {
        	alert("Deletion failed");
		}
	});
}

/**
 * Upload a file
 * Parameter list and meaning
 * php_script_url : where data will be posted,
 * file_id : id of the file input tag
 * supported_file_type : An allowed extension Array. all value should be LOWER case
 * progress_id : progress_id is the id of parent div tag of one child div tag to show the progress of file upload
 */
function file_upload(trigger,php_script_url,file_id,value_arr,supported_file_type,required_arr,tbl,callback_script,show_id,hide_id,progress_id){ 
	supported_file_type = typeof supported_file_type !== 'undefined' ? supported_file_type : null;
    tbl = typeof tbl !== 'undefined' ? tbl : null;
    callback_script = typeof callback_script !== 'undefined' ? callback_script : null;
    show_id = typeof show_id !== 'undefined' ? show_id : null;
    hide_id = typeof hide_id !== 'undefined' ? hide_id : null;
	required_arr = typeof required_arr !== 'undefined' ? required_arr : null;
    progress_id = typeof progress_id !== 'undefined' ? progress_id : null;
    
    var progressHandlerFunction=function(e){
        $("#"+progress_id).css({"width":Math.ceil(e.loaded/e.total) * 100 + '%'});
	};  
                                                                 
    var formData = new FormData(); 
    var fileIn = $("#"+file_id)[0];
    //Has any file been selected yet?
    if (trigger == true && (fileIn.files === undefined || fileIn.files.length == 0)) {
    	alert("Please select a file"); 
        return;
	}
	
	if(required_arr != null){
		var r_flag = true;
		$.each(required_arr,function(i,id){
			if(get_value("#"+id) == ""){ 
				r_flag = false;
			}
		});
		if(r_flag == false){
			alert(err_msg1);
			return;
		}
	}

    //We will upload only one file in this demo
    var file = fileIn.files[0];
	if(file){	
		// Check Extension
		var filename=file.name;
		var arr=filename.split(".");
		var extension=arr[arr.length-1].toLowerCase();
		if($.inArray(extension,supported_file_type)==-1){
			alert("Unsupported file");
			return;
		}

    
    	formData.append("file_name",file.name);
        //formData.append("file_length",file.length);
        formData.append(file_id, file);
	}
                                                                
    if(value_arr!=null){
    	$.each(value_arr,function(key,val){
        	formData.append(key,get_value(val));  
		});                                           
	}
                                                                
    msg="";
    if(progress_id != null) $("#"+progress_id).show();
	
    $.ajax({
    	type: "POST",
        url: php_script_url+".php",
        data: formData, //data to be send to server side script(ie php) in the given above url script
        xhr: function(){
        	var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){
            	myXhr.upload.addEventListener('progress',progressHandlerFunction, true);
			} else {
            	console.log("Upload progress is not supported.");
			}
            return myXhr;
		},  
        async : false,
        success:function(response){
			if(progress_id != null){
        		$("#"+progress_id).text("uploaded successfully...");
            	$("#"+progress_id).fadeOut(1500);
			}
                                                                                                                
            if(response == 0){
            	alert(err_msg2);
                                                                                                                
                if(tbl != null){
                	var filter_arr = [];
                    $.each(value_arr,function(index,val){
                    	filter_arr.push(val.replace('#',''));
					});
                    pagination(tbl,filter_arr,callback_script,show_id,hide_id);                           
				}
			} else {
            	alert(err_msg3);
			}
                                                                                                                
            msg=response;
		},
        cache: false,
        contentType: false,
        processData: false,
        error: function(jqXHR, textStatus, errorMessage) {
        	console.log(textStatus); // Optional
            alert("Upload Failed due to:"+errorMessage);
            if(progress_id != null) $("#"+progress_id).hide();
		}
    }); 
    
	return msg;                                                                  
}

/**
 * Load Select Option
 */
function createDropDown(selectId, callback_script, condition_arr, firstText, firstValue){
	condition_arr = typeof condition_arr !== 'undefined' ? condition_arr : null;
	firstText = typeof firstText !== 'undefined' ? firstText : null;
	firstValue = typeof firstValue !== 'undefined' ? firstValue : null;
		
	var $select = $("#"+selectId);
		$select.empty();
	  	
	if(firstText != null && firstValue != null){
		var $sel = $("<option/>");
			$sel.val(firstValue);
			$sel.text(firstText);
			$select.append($sel);
	}
	var return_val_arr = restore_fields(callback_script,condition_arr);
	var obj = jQuery.parseJSON( return_val_arr );	
	$.each(obj,function(key, value){
		var $o = $("<option/>");
	    $o.val(key);
	    $o.text(value);
	    $select.append($o);
	});
}

/**
 * Numeral Check
 */
function numeralsOnly(evt) {
	evt = (evt) ? evt : event;
	var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
		((evt.which) ? evt.which : 0));
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	   alert(err_msg7);
	   return false;
	}
	return true;
}
