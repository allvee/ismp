<script type="application/javascript">
  $(document).ready(function() {

    pagination("ch_channelmap",["st_channel","e_channel","sip_server_ip","sip_server_port","ipbcp_enabled","iufp_enabled"],"report/view_page",null,null);
    $("#submit").click(function() {
      save_ch_channel_map();
    });
  });
</script>
<h1>Call Handler : Channel Map</h1>
<div class="breadcrumb">
  <ul>
    <li>
      <a href="#">Home</a>
    </li>
    <li>
      <a href="#">CH</a>
    </li>
  </ul>
</div>
<div class="content">
  <div class="halfpan fl">
    <input type="hidden" name="action" value="insert" id="action" />
    <input type="hidden" name="action_id" value="" id="action_id" />
    <label>Start Channel</label>
    <input type="text" name="st_channel" value="" id="st_channel" />
    <label>End Channel</label>
    <input type="text" name="e_channel" value="" id="e_channel" />
    <label>SIP Server IP</label>
    <input type="text" name="" value="" id="sip_server_ip"/>
    <label>SIP Server Port</label>
    <input type="text" name="" value="" id="sip_server_port"/>
    <label>IPBCP Enabled</label>
    <input type="text" name="" value="" id="ipbcp_enabled"/>
    <label>IUFP Enabled</label>
    <input type="text" name="" value="" id="iufp_enabled"/>
  </div>
  <div class="clear"></div>
  <div class="btnarea">
    <input type="button" value="Submit" id="submit" />
  </div>
</div>
<div class="tblcss" id="view_ch_channelmap" style="height:300px; overflow:auto;"></div>