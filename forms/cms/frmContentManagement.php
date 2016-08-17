<h1>CMS : Content Management </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">CMS</a></li>
			<li><a href="#">User Panel</a></li>
            <li><a href="#">Content Management</a></li>
		</ul>
	</div>
	<div class="content">
      <div class="halfpan fl">
          <input type="hidden" name="action" value="insert" id="action" />
          <input type="hidden" name="action_id" value="" id="action_id" />
          <label>Category</label>
          <select  name="category_id" id="category_id" ></select> 
          <label>Content</label>
          <input name="cname" id="cname" type="text"  />
          <label>Title</label>
          <input name="title" id="title" type="text"  />
          <label>Description</label>
          <input name="desc" id="desc" type="text"  />
          
          <label>Content Type</label>
          <select  name="c_type" id="c_type" >
          	<!--<option value="ivr">IVR</option>
            <option value="sms">SMS</option>
            <option value="wap">WAP</option>
            <option value="crbt">CRBT</option>
            -->
          </select> 
          
          <div id="ivr_content">
          	<label>Upload file</label>
          	<input name="file" id="file" type="file"  />
          </div>
          
          <div id="sms_content">
          	<label>SMS Type</label>
            <select  name="sms_type" id="sms_type" >
            	<option value="unicode">Unicode</option>
                <option value="binary">Binary</option>
                <option value="TEXT">TEXT</option>
                <option value="other">Other</option>
                
            </select>
          	<label>SMS Text</label>
          	<textarea id="sms"></textarea>
            
          </div>
          
          <div id="wap_content"></div>
          	<label>Content URL</label>
          	<input name="d_url" id="d_url" type="text"  />
          	<label>Preview URL</label>
          	<input name="u_url" id="u_url" type="text"  />
          
 
         
          <label>Activation Date</label>
          <input name="actdate" id="actdate" type="text"  />
           <label>Deactivation Date</label>
          <input name="deadate" id="deadate" type="text"  />
          
          <input type="button" value="Submit" id="submit" />
       </div>
     </div>
    <div class="tblcss" id="view_content_list" style="overflow:auto;"></div>
<script>
	function choose_cms_content(c_type){
		var show_id, hide_id;
		if(c_type == "sms"){
			show_id = "#sms_content";
			hide_id = "#ivr_content,#wap_content";
		} else if(c_type == "wap"){
			show_id = "#wap_content";
			hide_id = "#sms_content,#ivr_content";
		} else if(c_type == "crbt") {
			show_id = null;
			hide_id = "#wap_content,#sms_content,#ivr_content";
		} else {
			show_id = "#ivr_content";
			hide_id = "#wap_content,#sms_content";
			set_value("c_type","ivr",selector_type_id);
		}
		
		show_hide(show_id,hide_id);
	}
	
	$(document).ready(function(){
		createDropDown('category_id','modules/cms/getcategory');
		createDropDown('c_type','modules/cms/getcontenttype');
		$("#category_id").html(load_list("modules/cms/getcategory",null));
		choose_cms_content(get_value("#c_type")); 
			
		$("#c_type").change(function() {
        	choose_cms_content(get_value("#c_type")); 
		});
			
		jQuery('#actdate,#deadate').datetimepicker({
			format: 'Y/m/d H:i:i',
			formatTime: 'H:i:i', // i means increment with step
			formatDate: 'Y/m/d',
			step:1,
			yearStart:1800,
			yearEnd:2250,
		}); 
			
		$("#submit").click(function(){
			save_uploaded_content();
			choose_cms_content(get_value("#c_type"));
		});  
		
		pagination("content_list",["cname","title","desc","actdate","deadate"],"report/view_page",null,null);  
		   
	});
</script>

