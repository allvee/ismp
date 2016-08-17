
<h1>User Administration : Menu Insertion </h1>
<div class="breadcrumb">
    <ul>
        <li><a href="#">User Administration</a></li>
        <li><a href="#">Menu Insertion</a></li>
    </ul>
</div>
<div class="content">
   
    <div class="halfpan fl">
        <input type="hidden" value="insert" id="action" />
        <input type="hidden" value="" id="action_id" />
        
        <label>Title </label>
        <input name="title" type="text" value="" id="title" />
        <label>Page</label>
        <input name="page" type="text" value="" id="page" />
        <label>Parent </label>
        <input name="parent" type="text" value="" id="parent" />
        <label>Sub Heading</label>
        <input name="subheading" type="text" value="" id="subheading" onkeyPress="" />
    </div>
    <div class="halfpan fr">
    
        <label>Image Directory</label>
        <input name="image_path" type="text" value="" id="image_path" />
        <label>Number of Child</label>
        <select name="number_of_child" id="number_of_child">
            <option value="0" >0</option>
            <option value="1" >1</option>
            <option value="2" >2</option>
            <option value="3" >3</option>
            <option value="4" >4</option>
            <option value="5" >5</option>
        </select>
        
        <label>Menu Order Under Parent </label>
        <input name="order" type="text" value="" id="order" />
        <label>Active ?</label>
        <select size="1" name="status" id="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
       
    </div>
    <div class="btnarea">
        <input name="submit" type="button" id="submit" value="Submit" />
    </div>
</div>
<div class="tblcss" id="view_tbl_menuInsert" style="height:1048px; overflow:auto;"></div>

<script type="application/javascript">
$(document).ready(function() {
	    	
		    $("#submit").click(function(){
				save_menu();
			});
			
			pagination("tbl_menuInsert",null,"report/view_menu_insert",null,null);
});
</script>