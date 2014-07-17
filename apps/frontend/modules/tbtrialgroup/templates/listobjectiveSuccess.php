<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<link href="/autocompletemultiple/autocomplete.css" rel="stylesheet" type="text/css" />
<link href="/autocompletemultiple/jquery-ui/css/reset.css" rel="stylesheet" type="text/css" />
<script src="/autocompletemultiple/jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="/autocompletemultiple/jquery-ui/js/jquery-ui-1.8.6.custom.min.js" type="text/javascript"></script>
<script src="/autocompletemultiple/autocomplete.js" type="text/javascript"></script>
<?php
$ArrWidth = array('5%', '95%');
$IdObjective = "";
?>
<style type="text/css">
    #sfWebDebug {   padding: 0;   margin: 0;   font-family: Arial, sans-serif;   font-size: 12px;   color: #333;   text-align: left;   line-height: 12px; }  #sfWebDebug a, #sfWebDebug a:hover {   text-decoration: none;   border: none;   background-color: transparent;   color: #000; }  #sfWebDebug img {   float: none;   margin: 0;   border: 0;   display: inline; }  #sfWebDebugBar {   position: absolute;   margin: 0;   padding: 1px 0;   right: 0px;   top: 0px;   opacity: 0.80;   filter: alpha(opacity:80);   z-index: 10000;   white-space: nowrap;   background-color: #ddd; }  #sfWebDebugBar[id] {   position: fixed; }  #sfWebDebugBar img {   vertical-align: middle; }  #sfWebDebugBar .sfWebDebugMenu {   padding: 5px;   padding-left: 0;   display: inline;   margin: 0; }  #sfWebDebugBar .sfWebDebugMenu li {   display: inline;   list-style: none;   margin: 0;   padding: 0 6px; }  #sfWebDebugBar .sfWebDebugMenu li.last {   margin: 0;   padding: 0;   border: 0; }  #sfWebDebugDatabaseDetails li {   margin: 0;   margin-left: 30px;   padding: 5px 0; }  #sfWebDebugShortMessages li {   margin-bottom: 10px;   padding: 5px;   background-color: #ddd; }  #sfWebDebugShortMessages li {   list-style: none; }  #sfWebDebugDetails {   margin-right: 7px; }  #sfWebDebug pre {   line-height: 1.3;   margin-bottom: 10px; }  #sfWebDebug h1 {   font-size: 16px;   font-weight: bold;   margin: 20px 0;   padding: 0;   border: 0px;   background-color: #eee; }  #sfWebDebug h2 {   font-size: 14px;   font-weight: bold;   margin: 10px 0;   padding: 0;   border: 0px;   background: none; }  #sfWebDebug h3 {   font-size: 12px;   font-weight: bold;   margin: 10px 0;   padding: 0;   border: 0px;   background: none; }  #sfWebDebug .sfWebDebugTop {   position: absolute;   left: 0px;   top: 0px;   width: 98%;   padding: 0 1%;   margin: 0;   z-index: 9999;   background-color: #efefef;   border-bottom: 1px solid #aaa; }  #sfWebDebugLog {   margin: 0;   padding: 3px;   font-size: 11px; }  #sfWebDebugLogMenu {   margin-bottom: 5px; }  #sfWebDebugLogMenu li {   display: inline;   list-style: none;   margin: 0;   padding: 0 5px;   border-right: 1px solid #aaa; }  #sfWebDebugConfigSummary {   display: inline;   padding: 5px;   background-color: #ddd;   border: 1px solid #aaa;   margin: 20px 0; }  #sfWebDebugConfigSummary li {   list-style: none;   display: inline;   margin: 0;   padding: 0 5px; }  #sfWebDebugConfigSummary li.last {   border: 0; }  .sfWebDebugInfo, .sfWebDebugInfo td {   background-color: #ddd; }  .sfWebDebugWarning, .sfWebDebugWarning td {   background-color: orange !important; }  .sfWebDebugError, .sfWebDebugError td {   background-color: #f99 !important; }  .sfWebDebugLogNumber {   width: 1%; }  .sfWebDebugLogType {   width: 1%;   white-space: nowrap; }  .sfWebDebugLogType, #sfWebDebug .sfWebDebugLogType a {   color: darkgreen; }  #sfWebDebug .sfWebDebugLogType a:hover {   text-decoration: underline; }  .sfWebDebugLogInfo {   color: blue; }  .ison {   color: #3f3;   margin-right: 5px; }  .isoff {   color: #f33;   margin-right: 5px;   text-decoration: line-through; }  .sfWebDebugLogs {   padding: 0;   margin: 0;   border: 1px solid #999;   font-family: Arial;   font-size: 11px; }  .sfWebDebugLogs tr {   padding: 0;   margin: 0;   border: 0; }  .sfWebDebugLogs td {   margin: 0;   border: 0;   padding: 1px 3px;   vertical-align: top; }  .sfWebDebugLogs th {   margin: 0;   border: 0;   padding: 3px 5px;   vertical-align: top;   background-color: #999;   color: #eee;   white-space: nowrap; }  .sfWebDebugDebugInfo {   color: #999;   font-size: 11px;   margin: 5px 0 5px 10px;   padding: 2px 0 2px 5px;   border-left: 1px solid #aaa;   line-height: 1.25em; }  .sfWebDebugDebugInfo .sfWebDebugLogInfo, .sfWebDebugDebugInfo a.sfWebDebugFileLink {   color: #333 !important; }  .sfWebDebugCache {   padding: 0;   margin: 0;   font-family: Arial;   position: absolute;   overflow: hidden;   z-index: 995;   font-size: 9px;   padding: 2px;   filter:alpha(opacity=85);   -moz-opacity:0.85;   opacity: 0.85; }  #sfWebDebugSymfonyVersion {   margin-left: 0;   padding: 1px 4px;   background-color: #666;   color: #fff; }  #sfWebDebugviewDetails ul {   padding-left: 2em;   margin: .5em 0;   list-style: none; }  #sfWebDebugviewDetails li {   margin-bottom: .5em; }  #sfWebDebug .sfWebDebugDataType, #sfWebDebug .sfWebDebugDataType a {   color: #666;   font-style: italic; }  #sfWebDebug .sfWebDebugDataType a:hover {   text-decoration: underline; }  #sfWebDebugDatabaseLogs {   margin-bottom: 10px; }  #sfWebDebugDatabaseLogs ol {   margin: 0;   padding: 0;   margin-left: 20px;   list-style: number; }  #sfWebDebugDatabaseLogs li {   padding: 6px; }  #sfWebDebugDatabaseLogs li:nth-child(odd) {   background-color: #CCC; }  .sfWebDebugDatabaseQuery {   margin-bottom: .5em;   margin-top: 0; }  .sfWebDebugDatabaseLogInfo {   color: #666;   font-size: 11px; }  .sfWebDebugDatabaseQuery .sfWebDebugLogInfo {   color: #909;   font-weight: bold; }  .sfWebDebugHighlight {   background: #FFC; }
    #sf_admin_container{
        width: 750;
        margin: 0 auto;
        font-size: 11px;
    }

    #DivPPal{
        width:750px;
        height:450px;
        overflow-x:hidden;
        overflow-y:scroll;
        font-size: 11px;
        font-weight:normal;
    }

</style>
<script>
    $(document).ready(function() {
        $('#txt_filter').keyup(function() {
            var txt_filter = $('#txt_filter').attr('value');
            var txt_filter = txt_filter.replace(" ", "*quot*");
            $("#DivPPal").load("/tbtrialgroup/FilterObjective/txt/" + txt_filter, function() {
                $('#Div_Filter').hide();
                if ($('#txt_filter').attr('value') != '') {
                    $('#Div_Filter_OK').show();
                } else {
                    $('#Div_Filter_OK').hide();
                }
            });
        });
    });

    function SelectObjective(Object) {
        var Valor = Object.value;
        var Name = "";
        if (Object.checked) {
            Name = $('#ObjectiveName' + Valor).attr('value');
            parent.document.getElementById("tb_trialgroup_id_objective").value = Valor;
            parent.document.getElementById("nameobjective").value = Name;
            self.parent.tb_remove();
        }
    }
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>List Objectives</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="listobjective" name="listobjective" action="<?php echo url_for('@listobjective'); ?>" enctype="multipart/form-data" method="post">
                <table width="100%" cellspacing="1" cellpadding="10" border="1">
                    <tr>
                        <td colspan="4"><b style="font-size: 13px;">Filter: </b><input type="text" id="txt_filter" name="txt_filter" size="50" autocomplete="off" placeholder="Enter first letters of the objective name..." style="background-color: #F9EBB2; border: 2px solid #FFD511; font-size: 12px;">&ensp;<span id="Div_Filter" style="display:none;"><?php echo image_tag('loading4.gif', array('size' => '15x15')); ?></span><span id="Div_Filter_OK" style="display:none;"><?php echo image_tag('success.png', array('size' => '15x15')); ?></span></td>
                    </tr>
                    <tr><td colspan="2">&ensp;</td></tr>
                    <br>
                    <tr bgcolor="#C7C7C7">
                        <td width="<?php echo $ArrWidth[0]; ?>"><label></label></td>
                        <td width="<?php echo $ArrWidth[1]; ?>"><label><b>Name</b></label></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="DivPPal">
                                <?php echo Listobjectives($ArrWidth); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
            <br>
        </div>
    </div>
</div>