<script type="application/javascript">
	$(document).ready(function() {
		
		createDropDown('group_id','modules/smsgw/getContactGroupList',null, '--Search--',' ');
	//	createDropDown('group_id_search', '--Search--',' ');
		pagination("smsgw_contactGroupRecipient",["group_id"],"report/view_smsgw_contactGroupRecipient",null,null);
		
		show_hide(null,recipientNoLabelId);
		show_hide(null,recipientNoTableId);
		show_hide(null,browseLabelId);
		show_hide(null,file);
		show_hide(null,recipient_name);
		show_hide(null,recipient_name_input);
		
		$("#submit").click(function() {
			var fileImportFlagValue =$("#fileImportFlag").val();
			if(fileImportFlagValue =='true')
			{
				var value_arr = {};
				value_arr["group_id"] = "#group_id";
				file_upload(true,"modules/smsgw/fileImportGroupContactRecipient","file",value_arr,["csv"],null,"smsgw_contactGroupRecipient","report/view_smsgw_contactGroupRecipient");
			}
			else
			{
				save_smsgw_contactGroupRecipient();
			}
			
		});
		
		$("#search").click(function() 
		{
		//pagination("smsgw_contactGroupRecipient",null,"report/view_smsgw_contactGroupRecipient",null,null,["group_id_search","contact_no"],null);
			pagination("smsgw_contactGroupRecipient",null,"report/view_smsgw_contactGroupRecipient",null,null,["group_id","contact_no"],null);
		});
		
		$("#inputMethod").change(function() 
        {
        	var inputMethodStr = $(this).val();
        	var manualInputValue =$("#manualInputId").val();
        	var fileImportValue =$("#fileImportId").val();
			
        	if(inputMethodStr == 'Manual')
        	{
				show_hide(recipientNoLabelId,null);
				show_hide(recipientNoTableId,null);
				show_hide(recipient_name,null);
				show_hide(recipient_name_input,null);
				
				show_hide(null,browseLabelId);
				show_hide(null,file);
				$("#fileImportFlag").val('false');
        	}
        	else if(inputMethodStr == 'Import File')
        	{
				show_hide(null,recipientNoLabelId);
				show_hide(null,recipientNoTableId);
				show_hide(null,recipient_name);
				show_hide(null,recipient_name_input);
				
				show_hide(browseLabelId,null);
				show_hide(file,null);
				$("#fileImportFlag").val('true');
        	}  
        });
        
        $("#group_id").change(function() 
        {
         	pagination("smsgw_contactGroupRecipient",null,"report/view_smsgw_contactGroupRecipient",null,null,["group_id"],null);
        });
        
	});
</script>
	<h1>SMSGW : Account : Add Contact Group Recepient</h1>
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Home</a></li>
			<li><a href="#">SMSGW</a></li>
			<li><a href="#">Account</a></li>
			<li><a href="#">Add Contact Group Recepient</a></li>
		</ul>
	</div>
	<div class="content">
		
        	<input type="hidden" name="action" value="insert" id="action" />
            <input type="hidden" name="id" value="" id="action_id" />
            <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION['USER_ID']; ?>"/>
            <input type="hidden" name="last_updated" value="" id="last_updated" />
            <input type="hidden" name="dstMN" value="" id="dstMN" />
            <input type="hidden" name="fileImportFlag" value="" id="fileImportFlag" />
            
            <label>Group </label>
				<select id="group_id" name="group_id">
				</select>
			<label>Input Method </label>
			<select id="inputMethod" name="inputMethod">
            	<option value=''>--Select--</option>
                <option value="Manual">Manual</option>
                <option value="Import File">Import File</option>
			</select>
                <label id="recipient_name">Group Recipient Name</label>
                <input id="recipient_name_input" name="recipient_name_input" type="text" value=""/>				
		    	<label id="recipientNoLabelId">Recipient No</label>
		    	<table id="recipientNoTableId"><tbody><tr><td align="left" style="vertical-align: top;" width="50%">
				<select id="country_code" name="country_code" style="width: 245px;">
					<option value="93">Afghanistan (+93)</option>
					<option value="355">Albania (+355)</option>
					<option value="213">Algeria (+213)</option>
					<option value="1">American Samoa (+1)</option>
					<option value="376">Andorra (+376)</option>
					<option value="244">Angola (+244)</option>
					<option value="1">Anguilla (+1)</option>
					<option value="672">Antarctica (+672)</option>
					<option value="1268">Antigua, Barbuda (+1268)</option>
					<option value="54">Argentina (+54)</option>
					<option value="374">Armenia (+374)</option>
					<option value="297">Aruba (+297)</option>
					<option value="247">Ascension (+247)</option>
					<option value="61">Australia (+61)</option>
					<option value="43">Austria (+43)</option>
					<option value="994">Azerbaidijan (+994)</option>
					<option value="1">Bahamas (+1)</option>
					<option value="973">Bahrain (+973)</option>
					<option value="880" selected="selected">Bangladesh (+880)</option>
					<option value="1">Barbados (+1)</option>
					<option value="375">Belarus (+375)</option>
					<option value="32">Belgium (+32)</option>
					<option value="501">Belize (+501)</option>
					<option value="229">Benin (+229)</option>
					<option value="1441">Bermuda (+1441)</option>
					<option value="975">Bhutan (+975)</option>
					<option value="591">Bolivia (+591)</option>
					<option value="387">Bosnia &amp; Herzegovina (+387)</option>
					<option value="267">Botswana (+267)</option>
					<option value="55">Brazil (+55)</option>
					<option value="1">British Virgin Islands (+1)</option>
					<option value="673">Brunei Darussalam (+673)</option>
					<option value="359">Bulgaria (+359)</option>
					<option value="226">Burkina Faso (+226)</option>
					<option value="257">Burundi (+257)</option>
					<option value="855">Cambodia (+855)</option>
					<option value="237">Cameroon (+237)</option>
					<option value="1">Canada (+1)</option>
					<option value="238">Cape Verde (+238)</option>
					<option value="1345">Cayman Islands (+1345)</option>
					<option value="236">Central African Republic (+236)</option>
					<option value="235">Chad (+235)</option>
					<option value="56">Chile (+56)</option>
					<option value="86">China (+86)</option>
					<option value="57">Colombia (+57)</option>
					<option value="269">Comoros (+269)</option>
					<option value="682">Cook Islands (+682)</option>
					<option value="506">Costa Rica (+506)</option>
					<option value="385">Croatia (+385)</option>
					<option value="357">Cyprus (+357)</option>
					<option value="420">Czech Republic (+420)</option>
					<option value="45">Denmark (+45)</option>
					<option value="246">Diego Garcia (+246)</option>
					<option value="253">Djibouti (+253)</option>
					<option value="1">Dominica (+1)</option>
					<option value="1">Dominican Republic (+1)</option>
					<option value="670">East Timor (+670)</option>
					<option value="593">Ecuador (+593)</option>
					<option value="20">Egypt (+20)</option>
					<option value="503">El Salvador (+503)</option>
					<option value="240">Equatorial Guinea (+240)</option>
					<option value="291">Eritrea (+291)</option>
					<option value="372">Estonia (+372)</option>
					<option value="251">Ethiopia (+251)</option>
					<option value="500">Falklands Islands (+500)</option>
					<option value="298">Faroe Islands (+298)</option>
					<option value="679">Fiji Islands (+679)</option>
					<option value="358">Finland (+358)</option>
					<option value="33">France (+33)</option>
					<option value="262">French Dept/Terr in Indian Ocean (+262)</option>
					<option value="594">French Guiana (+594)</option>
					<option value="689">French Polynesia (+689)</option>
					<option value="241">Gabon (+241)</option>
					<option value="220">Gambia (+220)</option>
					<option value="995">Georgia (+995)</option>
					<option value="49">Germany (+49)</option>
					<option value="233">Ghana (+233)</option>
					<option value="350">Gibraltar (+350)</option>
					<option value="30">Greece (+30)</option>
					<option value="299">Greenland (+299)</option>
					<option value="1473">Grenada (+1473)</option>
					<option value="590">Guadeloupe (+590)</option>
					<option value="1">Guam (+1)</option>
					<option value="502">Guatemala (+502)</option>
					<option value="224">Guinea (+224)</option>
					<option value="245">Guinea-Bissau (+245)</option>
					<option value="592">Guyana (+592)</option>
					<option value="509">Haiti (+509)</option>
					<option value="504">Honduras (+504)</option>
					<option value="852">Hong Kong (+852)</option>
					<option value="36">Hungary (+36)</option>
					<option value="354">Iceland (+354)</option>
					<option value="91">India (+91)</option>
					<option value="62">Indonesia (+62)</option>
					<option value="964">Iraq (+964)</option>
					<option value="353">Ireland (+353)</option>
					<option value="972">Israel (+972)</option>
					<option value="39">Italy (+39)</option>
					<option value="1876">Jamaica (+1876)</option>
					<option value="81">Japan (+81)</option>
					<option value="962">Jordan (+962)</option>
					<option value="254">Kenya (+254)</option>
					<option value="686">Kiribati (+686)</option>
					<option value="965">Kuwait (+965)</option>
					<option value="996">Kyrgyzstan (+996)</option>
					<option value="856">Lao (+856)</option>
					<option value="371">Latvia (+371)</option>
					<option value="961">Lebanon (+961)</option>
					<option value="266">Lesotho (+266)</option>
					<option value="231">Liberia (+231)</option>
					<option value="423">Liechtenstein (+423)</option>
					<option value="370">Lithuania (+370)</option>
					<option value="352">Luxembourg (+352)</option>
					<option value="853">Macao (+853)</option>
					<option value="389">Macedonia (+389)</option>
					<option value="261">Madagascar (+261)</option>
					<option value="265">Malawi (+265)</option>
					<option value="60">Malaysia (+60)</option>
					<option value="960">Maldives (+960)</option>
					<option value="223">Mali (+223)</option>
					<option value="356">Malta (+356)</option>
					<option value="692">Marshall Islands (+692)</option>
					<option value="596">Martinique (+596)</option>
					<option value="222">Mauritania (+222)</option>
					<option value="230">Mauritius (+230)</option>
					<option value="52">Mexico (+52)</option>
					<option value="691">Micronesia (+691)</option>
					<option value="373">Moldova (+373)</option>
					<option value="377">Monaco (+377)</option>
					<option value="976">Mongolia (+976)</option>
					<option value="382">Montenegro (+382)</option>
					<option value="1664">Montserrat (+1664)</option>
					<option value="212">Morocco (+212)</option>
					<option value="258">Mozambique (+258)</option>
					<option value="264">Namibia (+264)</option>
					<option value="674">Nauru (+674)</option>
					<option value="977">Nepal (+977)</option>
					<option value="31">Netherlands (+31)</option>
					<option value="599">Netherlands Antilles (+599)</option>
					<option value="687">New Caledonia (+687)</option>
					<option value="64">New Zealand (+64)</option>
					<option value="505">Nicaragua (+505)</option>
					<option value="227">Niger (+227)</option>
					<option value="234">Nigeria (+234)</option>
					<option value="683">Niue (+683)</option>
					<option value="1">Northern Mariana Islands (+1)</option>
					<option value="47">Norway (+47)</option>
					<option value="968">Oman (+968)</option>
					<option value="92">Pakistan (+92)</option>
					<option value="680">Palau (+680)</option>
					<option value="507">Panama (+507)</option>
					<option value="675">Papua New Guinea (+675)</option>
					<option value="595">Paraguay (+595)</option>
					<option value="51">Peru (+51)</option>
					<option value="63">Philippines (+63)</option>
					<option value="48">Poland (+48)</option>
					<option value="351">Portugal (+351)</option>
					<option value="1">Puerto-Rico (+1)</option>
					<option value="974">Qatar (+974)</option>
					<option value="262">Reunion (+262)</option>
					<option value="40">Romania (+40)</option>
					<option value="7">Russia (+7)</option>
					<option value="250">Rwanda (+250)</option>
					<option value="290">Saint Helena (+290)</option>
					<option value="1">Saint Kitts and Nevis (+1)</option>
					<option value="1758">Saint Lucia (+1758)</option>
					<option value="508">Saint Pierre and Miquelon (+508)</option>
					<option value="1">Saint Vincent and the Grenadines (+1)</option>
					<option value="685">Samoa (+685)</option>
					<option value="378">San Marino (+378)</option>
					<option value="239">Sao Tome and Principe (+239)</option>
					<option value="966">Saudi Arabia (+966)</option>
					<option value="221">Senegal (+221)</option>
					<option value="381">Serbia (+381)</option>
					<option value="248">Seychelles (+248)</option>
					<option value="232">Sierra Leone (+232)</option>
					<option value="65">Singapore (+65)</option>
					<option value="421">Slovakia (+421)</option>
					<option value="386">Slovenia (+386)</option>
					<option value="677">Solomon Islands (+677)</option>
					<option value="27">South Africa (+27)</option>
					<option value="82">South Korea (+82)</option>
					<option value="34">Spain (+34)</option>
					<option value="94">Sri Lanka (+94)</option>
					<option value="597">Suriname (+597)</option>
					<option value="268">Swaziland (+268)</option>
					<option value="46">Sweden (+46)</option>
					<option value="41">Switzerland (+41)</option>
					<option value="886">Taiwan (+886)</option>
					<option value="992">Tajikistan (+992)</option>
					<option value="255">Tanzania (+255)</option>
					<option value="66">Thailand (+66)</option>
					<option value="228">Togo (+228)</option>
					<option value="690">Tokelau (+690)</option>
					<option value="676">Tonga (+676)</option>
					<option value="1868">Trinidad, Tobago (+1868)</option>
					<option value="216">Tunisia (+216)</option>
					<option value="90">Turkey (+90)</option>
					<option value="993">Turkmenistan (+993)</option>
					<option value="1649">Turks and Caicos (+1649)</option>
					<option value="688">Tuvalu (+688)</option>
					<option value="256">Uganda (+256)</option>
					<option value="380">Ukraine (+380)</option>
					<option value="971">United Arab Emirates (+971)</option>
					<option value="44">United Kingdom (+44)</option>
					<option value="1">United States (+1)</option>
					<option value="598">Uruguay (+598)</option>
					<option value="1">US Virgin Islands (+1)</option>
					<option value="998">Uzbekistan (+998)</option>
					<option value="678">Vanuatu (+678)</option>
					<option value="39">Vatican City State (+39)</option>
					<option value="58">Venezuela (+58)</option>
					<option value="84">Vietnam (+84)</option>
					<option value="681">Wallis and Futuna (+681)</option>
					<option value="967">Yemen (+967)</option>
					<option value="260">Zambia (+260)</option>
					<option value="263">Zimbabwe (+263)</option>
				</select>
				</td>
				<td width="50%">
				<input name="recipient_no" type="text" value="" id="recipient_no" onKeyPress="return numeralsOnly(event)" placeholder="*Mobile No" style="width: 256px;"/>
				</td></tr></tbody></table>
		    	<label id="browseLabelId"> Browse </label>
				<input name="file" id="file" type="file" />
		<div class="clear"></div>
		<div class="btnarea">
			<input type="button" value="Submit" id="submit" />
		</div>
	</div>
	<div class="searchPanel">
	<!--
		<label>Group </label>
				<select id="group_id_search" name="group_id_search">
				</select>-->
		<label>Contact Number </label>
			<input name="contact_no" type="text" id="contact_no" onKeyPress="return numeralsOnly(event)" placeholder="Mobile No" style="width:245px;"/>
		
		<input type="button" value="Search" id="search" />
	</div>
	<div class="tblcss" id="view_smsgw_contactGroupRecipient" style="height:300px; overflow:auto;"></div>