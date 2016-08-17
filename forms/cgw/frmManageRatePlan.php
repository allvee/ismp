<script type="application/javascript">
	$(document).ready(function() {

		show_hide(null,"#contentId");
		createDropDown('ServiceID', 'modules/cgw/getServiceID',null,'--Select--','');
		createDropDown('PackageID', 'modules/cgw/getPackageID',null,'--ALL--','All');
		createDropDown('CallTypeID', 'modules/cgw/getCallTypeID',null,'--Select--','');
		createDropDown('TimeSlotID', 'modules/cgw/getTimeSlotID',null,'--Select--','');
		createDropDown('SubscriptionGroupID', 'modules/cgw/getSubscriptionGroupIDForRatePlan',null,'NA','NA');
		createDropDown('ServiceIDSearch', 'modules/cgw/getServiceID',null,'--Select--','');
		createDropDown('cp_id', 'modules/cms/get_all_cp', null, 'NA','');
		// createDropDown('accumulatorid', 'modules/cgw/get_accumulator',null,'--Select--','');
		//createDropDown('ServiceID', '--Select--',' ');
		//createDropDown('PackageID', '--ALL--','All');
		//createDropDown('CallTypeID', '--Select--',' ');
		//createDropDown('TimeSlotID', '--Select--',' ');
		//createDropDown('SubscriptionGroupID', 'NA','NA');
		//createDropDown('ServiceIDSearch', '--Select--',' ');
	//	createDropDown('accumulatorid', '--Select--',' ');
		
		$('#PackageID').attr("disabled", true); 
		
		var search_options = {};
		search_options["ServiceIDSearch"] = "ServiceIDSearch";
		
		pagination("cgw_ratePlan",["UniqueID","ServiceID","PackageID","ChargingType","CallTypeID","TimeSlotID","RateID"],"report/view_cgw_ratePlan",null,null,search_options,null);
		
		
		$("#submit").click(function() {
			var rateIdStr = $("#RateIDhidden").val();
			//alert("rateIdStr :"+rateIdStr);
			save_cgw_ratePlan();
			// remove_existing_ratePulse(rateIdStr);
			save_cgw_ratePulse();
			show_hide(null,"#contentId");		
        });	
        
       	$('#ActivationStart').datetimepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
		});	
		
		$('#ActivationEnd').datetimepicker({
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            selectOtherMonths: true
		});		
		
		$("#search").click(function() { 
			var search_options = {};
			show_hide(null,"#contentId");
			search_options["ServiceIDSearch"] = "ServiceIDSearch";
			pagination("cgw_ratePlan",["UniqueID","ServiceID","PackageID","ChargingType","CallTypeID","TimeSlotID","RateID"],"report/view_cgw_ratePlan",null,null,search_options,null);
			//pagination("cgw_ratePulse",["UniqueID","rateid","stepno","stepduration","steppulse","steppulserate","serviceunit"],"report/view_cgw_ratePulse",null,null,null,null);
		});
		
		$("#showPanel").click(function() {
			var contentIdValue =$("#contentId").val();
			show_hide("#contentId",null);
		});	
		
		$("#hidePanel").click(function() {
			var contentIdValue =$("#contentId").val();
			show_hide(null,"#contentId");
		});		
		
		$("#SubscriptionGroupID").change(function(){
			var selectedVal;
		    if($(this).val() == 'NA')
		    {
		    	selectedVal = "NA";
		    	$("#SubscriptionStatus").val(selectedVal);
		    }
		});
		$("#SubscriptionStatus").change(function(){
			 var selectedVal;
			 //alert("SubscriptionGroupID :"+$("#SubscriptionGroupID").val());
		    if($("#SubscriptionGroupID").val() == 'NA')
		    {
		    	selectedVal = "NA";
		    	$("#SubscriptionStatus").val(selectedVal);
		    }

		});
		
	});
	

	function addNewRatePulse() {
//		alert("addNewRatePulse : Enter");
//		show_hide(null,addNewRow_1);
		var table = document.getElementById('ratePulseTbl');
		var rowCount = table.rows.length;
		newRatePulseId = -rowCount;

		//generating exam name key
		stRateID = '' + newRatePulseId + '--rateid';
		stStepNo = '' + newRatePulseId + '--stepno';
		stStepDuration = '' + newRatePulseId + '--stepduration';		
		stStepPulse = '' + newRatePulseId + '--steppulse';
		stStepPulseRate = '' + newRatePulseId + '--steppulserate';
		stServiceUnit = '' + newRatePulseId + '--serviceunit';
		stServiceUnit = '' + newRatePulseId + '--serviceunit';
		stServiceUnit = '' + newRatePulseId + '--serviceunit';
		//stSendRequestToIN = '' + newRatePulseId + '--sendRequestToIN';
		
		var v = document.getElementById("tdPlus");
		
		addRowIntoRatePulseTbl(stRateID, stStepNo, stStepDuration, stStepPulse, stStepPulseRate, stServiceUnit, v);
		hidePreviousPlusMinusButtons(rowCount);
	}

	function addRowIntoRatePulseTbl(stRateID, stStepNo, stStepDuration, stStepPulse, stStepPulseRate, stServiceUnit, tdPlus) 
	{
		var v1 = document.getElementById("ratePulseTbd").childElementCount;
		var table = document.getElementById('ratePulseTbl');
		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);
		row.id = "rowNumber_"+rowCount;
//		row.id = newRatePulseId;

		var cell1 = row.insertCell(0);
		cell1.innerHTML = 'Step No '+rowCount;
		cell1.value = "Step No "+rowCount;
		var element1 = document.createElement("input");
		element1.type = "hidden";
		element1.name = "stepNumber_"+rowCount;
		element1.value = rowCount;
		element1.id = "stepNumber_"+rowCount;
		cell1.appendChild(element1);

		var cell2 = row.insertCell(1);
		var element2 = document.createElement("input");
		element2.type = "text";
		element2.name = stStepDuration;
		element2.value = '';
		element2.id = 'stepduration_'+rowCount;
		cell2.appendChild(element2);
		
		var cell3 = row.insertCell(2);
		var element3 = document.createElement("input");
		element3.type = "text";
		element3.name = stStepPulse;
		element3.value = '';
		element3.id = 'steppulse_'+rowCount;
		cell3.appendChild(element3);
		
		var cell4 = row.insertCell(3);
		var element4 = document.createElement("input");
		element4.type = "text";
		element4.name = stStepPulseRate;
		element4.value = '';
		element4.id = 'steppulserate_'+rowCount;
		cell4.appendChild(element4);
		
		var cell5 = row.insertCell(4);
		var element5 = document.createElement("input");
		element5.type = "text";
		element5.name = stServiceUnit;
		element5.value = '';
		element5.id = 'serviceunit_'+rowCount;
		cell5.appendChild(element5);
		
		var cell6 = row.insertCell(5);
		var element6 = document.createElement("input");
		//cell6.innerHTML = tdPlus.innerHTML.replace("hidden", "visible").replace("removeRow_1", "removeRow_"+rowCount);
		cell6.innerHTML = tdPlus.innerHTML.replace("hidden", "visible").replace("hidden", "visible").replace("removeRow_1", "removeRow_"+rowCount).replace("addNewRow_1", "addNewRow_"+rowCount);
	}
	function removeCurrentRatePulse(v) 
	{
		var rowNumber = v.id.replace("removeRow_", "");
		var tbd = document.getElementById("ratePulseTbd");
		var row = document.getElementById("rowNumber_"+rowNumber); ; 
		var child = tbd.childNodes[rowNumber];
		showPreviousPlusMinusButtons(rowNumber);
		tbd.removeChild(row);
	}
	
	function hidePreviousPlusMinusButtons(rowCount)
	{
		for(var i =1; i< rowCount; i++)
		{
			var m = document.getElementById('removeRow_'+i);
			m.style.visibility = "hidden";
			var p = document.getElementById('addNewRow_'+i);
			p.style.visibility = "hidden";
		}
	}
	function showPreviousPlusMinusButtons(rowNo)
	{
		//alert("rowNo :"+rowNo);
		if(rowNo >= 3){
			var m = document.getElementById('removeRow_'+(rowNo-1));
			m.style.visibility = "visible";
		}

		var p = document.getElementById('addNewRow_'+(rowNo-1));
		p.style.visibility = "visible";
	}

</script>
	<h1>CGW : Manage Rate Plan </h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">CGW</a></li>
			<li><a href="#">Rate Configuration</a></li>
			<li><a href="#">Rate Plan Management</a></li>
			<li><a href="#">Manage Rate Plan</a></li>
		</ul>
	</div>
	<div class="searchPanel">
		<label>Service </label>
			<select id="ServiceIDSearch" name="ServiceIDSearch">
			</select>
		<input type="button" value="Search" id="search" />
		
		<!--<input type="button" value="Show" id="showPanel"/>
		<input type="button" value="Hide" id="hidePanel"/>-->
	</div>
	<div class="content" id="contentId">	
		<input type="hidden" name="action" value="insert" id="action" />
        <input type="hidden" name="id" value="" id="action_id" />
        <input type="hidden" name="userId" id="userId" value="<?php  echo $_SESSION['USER_ID']; ?>"/>
	    <!--<input name="RateID" type="hidden"  id="RateIDhidden" value=""/>-->
		<!--<input name="rateid" type="hidden"  id="RateIDhidden" value=""/> -->
		 
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblcss">
			<tr>
			<td colspan="4">
				Rate Plan Management
			</td>
			</tr>
			
			<tr>
				<td>
					Service
				</td>
				<td colspan="3">
					<select name="ServiceID" id="ServiceID">
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Package
				</td>
				<td colspan="3">
					<select name="PackageID" id="PackageID">
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Charging Type
				</td>
				<td colspan="3">
					<select name="ChargingType" id="ChargingType">
						<option value="Session%">Session</option>
		       			<option value="Specific%">Specific</option>
				  	</select>
				</td>
			</tr>
			<tr>
				<td colspan="4" id="ratePulseContent">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="subtbl" id="ratePulseTbl">
						<tbody id="ratePulseTbd">
							<tr id = "headerRow">
								<td>
									Rate
								</td>
								<td>
									Duration
								</td>
								<td>
									Pulse Size
								</td>
								<td>
									Pulse Rate
								</td>
								<td>
									Service Unit
								</td>
								<td>
									Action
								</td>
							</tr>
							<tr id="rowNumber_1">
								<td id="stepNumber_1">
									Step 1
									<input type="hidden" name="stepNumber_1" id = "stepNumber_1" value="1"/>
								</td>
								<td>
									<input type="text" name="stepduration_1" value="" id="stepduration_1" />
								</td>
								<td>
									<input type="text" name="steppulse_1" value="" id="steppulse_1" />
								</td>
								<td>
									<input type="text" name="steppulserate_1" value="" id="steppulserate_1" />
								</td>
								<td>
									<input type="text" name="serviceunit_1" value="" id="serviceunit_1" />
								</td>
								<td id="tdPlus">
									<table>
										<tbody>
											<tr>
												<td>
													<input type="button" name="" id="removeRow_1" value="-" style="min-width:32px;visibility:hidden;"  onclick="removeCurrentRatePulse(this);"/>
												</td>
												<td>
													<input type="button" name="" id="addNewRow_1" value="+" style="min-width:32px;visibility:visible;" onclick="addNewRatePulse();"/>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					Activation Start
				</td>
				<td colspan="3">
					<input name="ActivationStart" type="text"  id="ActivationStart"/>
				</td>
			</tr>
			<tr>
				<td>
					Activation End
				</td>
				<td colspan="3">
					<input name="ActivationEnd" type="text"  id="ActivationEnd"/>
				</td>
			</tr>
			<tr>
				<td>
					Rate ID
				</td>
				<td colspan="3">
					<input type="text" name="RateID" value="" id="RateIDhidden" />
				</td>
				
			</tr>
			<tr>
				<td>
					Priority
				</td>
				<td colspan="3">
					<input type="text" name="Priority" value="" id="Priority" />
				</td>
			</tr>
			<tr>
				<td>
					Call Type
				</td>
				<td colspan="3">
					<select name="CallTypeID" id="CallTypeID">
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Time Slot
				</td>
				<td colspan="3">
					<select name="TimeSlotID" id="TimeSlotID">
					</select>
				</td>
			</tr>
            <tr>
				<td>CP</td>
				<td colspan="3">
					<select name="cp_id" id="cp_id">
					</select>
				</td>
			</tr>
            <!--<tr>
				<td>
					Accumulator ID
				</td>
				<td colspan="3">
					<select name="accumulatorid" id="accumulatorid">
					</select>
				</td>
			</tr>-->
            <tr>
				<td>
					Region
				</td>
				<td>
					<input type="text" name="region" value="NA" id="region" />
				</td>
				<td>
					Channel
				</td>
				<td>
					<input type="text" name="channel" value="NA" id="channel" />
				</td>
			</tr>
			<tr>
				<td>
					Subscription Group ID
				</td>
				<td>
					<select name="SubscriptionGroupID" id="SubscriptionGroupID">
					</select>
				</td>
				<td>
					Status
				</td>
				<td>
					<select name="SubscriptionStatus" id="SubscriptionStatus">
						<option value=NA>NA</option>
						<option value="Deregistered">Deregistered</option>
						<option value="Registered">Registered</option>
						<option value="RegisteredNoBalance">RegisteredNoBalance</option>
					</select>
				</td>
			</tr>
		</table>
		
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
	<div class="tblcss" id="view_cgw_ratePlan" style="height:300px; overflow:auto;"></div>