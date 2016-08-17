<script type="application/javascript">
	// calling load_cgw_cdr() function after every 10 sec
	setInterval(load_cgw_cdr,10000);
	
	$(document).ready(function(){
		createDropDown('short_code','modules/cgw/getShortCode',null,'All',' ');
		createDropDown('service','modules/cgw/getService',null,'All',' ');
		var condition_arr = {};
		condition_arr["MSISDN"] = "MSISDN";
		condition_arr["short_code"] = "short_code";
		condition_arr["service"] = "service";
		
		pagination("cgw_cdr",null,"report/view_cgw_cdr",null,null,condition_arr);
		load_cgw_cdr();
		
		$("#search").click(function(){
			pagination("cgw_cdr",null,"report/view_cgw_cdr",null,null,condition_arr);
		});
	
	});
</script>
	<h1>CGW : CDR</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">CDR</a></li>

		</ul>
	</div>
	
	<div class="content" id="contentId">
		<div class="halfpan fl">	
			<input type="hidden" name="action" value="insert" id="action" />
			<input type="hidden" name="id" value="" id="action_id" />
			<div class="searchPanel">
				<label>MSISDN </label>
					<input name="MSISDN" type="text" id="MSISDN" style="width:245px;"/>
				<label>Short Code </label>
					<select id="short_code" name="short_code">
					</select>
				<label>Service </label>
					<select id="service" name="service">
					</select>
				<input type="button" value="Search" id="search" />
			</div>
		</div>
		<div class="halfpan fr">
			<div class="cdrStatusDiv" id ="cdrStatusDiv">
				<table id="cdrStatusTable" style="border: 1px solid black;">
					<tr style="border: 1px solid black;">
						<td style="border: 1px solid black;"> CDR Write Status </td>
						<td style="border: 1px solid black;"> Count </td>
					</tr>
					<tr style="border: 1px solid black;">
						<td id="showCDRWriteStatus" style="border: 1px solid black;">
						<td id="showCount" style="border: 1px solid black;">
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="tblcss" id="view_cgw_cdr" style="height:300px; overflow:auto;"></div>