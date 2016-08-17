
<h1>CMS : Category and Services</h1>
<div class="breadcrumb">
    <ul>
        <li><a href="#">CMS</a></li>
        <li><a href="#">Admin Panel</a></li>
        <li><a href="#">Category and Services</a></li>
    </ul>
</div>
<div class="content">
    <input type="hidden" name="cph" value="" id="cph" />
    <input type="hidden" name="sourceh" value="" id="sourceh" />
   
    <div class="halfpan fl">
        <input type="hidden" value="insert" id="action" />
        <input type="hidden" value="" id="action_id" />
        <label>Category Name </label>
        <input name="category_name" type="text" value="" id="category_name" />
       <!-- <label>Prompt</label>-->
        <input name="prompt" type="hidden" value="NA" id="prompt" />
        <!--<label>Post Prompt </label>-->
        <input name="post_prompt" type="hidden" value="" id="post_prompt" />
        <label>Display Order </label>
        <input name="display_order" type="text" value="" id="display_order" onkeyPress="return numeralsOnly(event)" />
        <label>Activation Date</label>
        <input name="active" type="text" value="" id="active" />
        <label>Source</label>
        <select multiple size="4" name="source" id="source"></select>
        <label>Time Slot</label>
        <select name="timeslot_id" id="timeslot_id"></select>
    </div>
    <div class="halfpan fr">
        <label>Parent ID </label>
        <input name="parent" type="text" value="" id="parent" />
        <!--<label>Pre-Prompt</label>-->
        <input name="pre_prompt" type="hidden" value="" id="pre_prompt" />
        <!--<label>IVR-string </label>-->
        <input name="ivr_string" type="hidden" value="" id="ivr_string" />
        <label>Status </label>
        <select size="1" name="status" id="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
        <label>Deactivation Date </label>
        <input name="deactive" type="text" value="" id="deactive" />
        <label>CP Name</label>
        <select multiple size="4" name="cp" id="cp"></select>
    </div>
    <div class="btnarea">
        <input name="submit" type="button" id="submit" value="Submit" />
    </div>
</div>
<div class="tblcss" id="view_tbl_cms_category" style="height:1048px; overflow:auto;"></div>

<script type="application/javascript">
$(document).ready(function() {
	 createDropDown('timeslot_id','modules/cms/getTimeslotList',null, '--Search--',' ');
			var list=load_list("modules/cms/get_content_provider",null);
	        $("#cp").empty().html(list);
			var list=load_list("modules/cms/get_request_source",null);
	        $("#source").empty().html(list);
			
			$("#submit").click(function(){
				saveCategoryAndServices();
			});
			
			jQuery('#deactive,#active').datetimepicker({
				format: 'Y-m-d H:i:i',
				formatTime: 'H:i:i', // means increment with step
				formatDate: 'Y-m-d',
				step:1,
				yearStart:1800,
				yearEnd:2250
			}); 
			
			pagination("tbl_cms_category",null,"report/view_page",null,null);
});
</script>