<script src="/sfAdminThemejRollerPlugin/js/jquery.min.js" type="text/javascript"></script>
<script src="/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js" type="text/javascript"></script>
<script src="/js/jquery.alerts.js" type="text/javascript"></script>
<link href="/sfAdminThemejRollerPlugin/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<?php
$width1 = '5%';
$width2 = '35%';
$width3 = '20%';
$width4 = '40%';

$user = sfContext::getInstance()->getUser();
?>
<style type="text/css">
    #sfWebDebug {   padding: 0;   margin: 0;   font-family: Arial, sans-serif;   font-size: 12px;   color: #333;   text-align: left;   line-height: 12px; }  #sfWebDebug a, #sfWebDebug a:hover {   text-decoration: none;   border: none;   background-color: transparent;   color: #000; }  #sfWebDebug img {   float: none;   margin: 0;   border: 0;   display: inline; }  #sfWebDebugBar {   position: absolute;   margin: 0;   padding: 1px 0;   right: 0px;   top: 0px;   opacity: 0.80;   filter: alpha(opacity:80);   z-index: 10000;   white-space: nowrap;   background-color: #ddd; }  #sfWebDebugBar[id] {   position: fixed; }  #sfWebDebugBar img {   vertical-align: middle; }  #sfWebDebugBar .sfWebDebugMenu {   padding: 5px;   padding-left: 0;   display: inline;   margin: 0; }  #sfWebDebugBar .sfWebDebugMenu li {   display: inline;   list-style: none;   margin: 0;   padding: 0 6px; }  #sfWebDebugBar .sfWebDebugMenu li.last {   margin: 0;   padding: 0;   border: 0; }  #sfWebDebugDatabaseDetails li {   margin: 0;   margin-left: 30px;   padding: 5px 0; }  #sfWebDebugShortMessages li {   margin-bottom: 10px;   padding: 5px;   background-color: #ddd; }  #sfWebDebugShortMessages li {   list-style: none; }  #sfWebDebugDetails {   margin-right: 7px; }  #sfWebDebug pre {   line-height: 1.3;   margin-bottom: 10px; }  #sfWebDebug h1 {   font-size: 16px;   font-weight: bold;   margin: 20px 0;   padding: 0;   border: 0px;   background-color: #eee; }  #sfWebDebug h2 {   font-size: 14px;   font-weight: bold;   margin: 10px 0;   padding: 0;   border: 0px;   background: none; }  #sfWebDebug h3 {   font-size: 12px;   font-weight: bold;   margin: 10px 0;   padding: 0;   border: 0px;   background: none; }  #sfWebDebug .sfWebDebugTop {   position: absolute;   left: 0px;   top: 0px;   width: 98%;   padding: 0 1%;   margin: 0;   z-index: 9999;   background-color: #efefef;   border-bottom: 1px solid #aaa; }  #sfWebDebugLog {   margin: 0;   padding: 3px;   font-size: 11px; }  #sfWebDebugLogMenu {   margin-bottom: 5px; }  #sfWebDebugLogMenu li {   display: inline;   list-style: none;   margin: 0;   padding: 0 5px;   border-right: 1px solid #aaa; }  #sfWebDebugConfigSummary {   display: inline;   padding: 5px;   background-color: #ddd;   border: 1px solid #aaa;   margin: 20px 0; }  #sfWebDebugConfigSummary li {   list-style: none;   display: inline;   margin: 0;   padding: 0 5px; }  #sfWebDebugConfigSummary li.last {   border: 0; }  .sfWebDebugInfo, .sfWebDebugInfo td {   background-color: #ddd; }  .sfWebDebugWarning, .sfWebDebugWarning td {   background-color: orange !important; }  .sfWebDebugError, .sfWebDebugError td {   background-color: #f99 !important; }  .sfWebDebugLogNumber {   width: 1%; }  .sfWebDebugLogType {   width: 1%;   white-space: nowrap; }  .sfWebDebugLogType, #sfWebDebug .sfWebDebugLogType a {   color: darkgreen; }  #sfWebDebug .sfWebDebugLogType a:hover {   text-decoration: underline; }  .sfWebDebugLogInfo {   color: blue; }  .ison {   color: #3f3;   margin-right: 5px; }  .isoff {   color: #f33;   margin-right: 5px;   text-decoration: line-through; }  .sfWebDebugLogs {   padding: 0;   margin: 0;   border: 1px solid #999;   font-family: Arial;   font-size: 11px; }  .sfWebDebugLogs tr {   padding: 0;   margin: 0;   border: 0; }  .sfWebDebugLogs td {   margin: 0;   border: 0;   padding: 1px 3px;   vertical-align: top; }  .sfWebDebugLogs th {   margin: 0;   border: 0;   padding: 3px 5px;   vertical-align: top;   background-color: #999;   color: #eee;   white-space: nowrap; }  .sfWebDebugDebugInfo {   color: #999;   font-size: 11px;   margin: 5px 0 5px 10px;   padding: 2px 0 2px 5px;   border-left: 1px solid #aaa;   line-height: 1.25em; }  .sfWebDebugDebugInfo .sfWebDebugLogInfo, .sfWebDebugDebugInfo a.sfWebDebugFileLink {   color: #333 !important; }  .sfWebDebugCache {   padding: 0;   margin: 0;   font-family: Arial;   position: absolute;   overflow: hidden;   z-index: 995;   font-size: 9px;   padding: 2px;   filter:alpha(opacity=85);   -moz-opacity:0.85;   opacity: 0.85; }  #sfWebDebugSymfonyVersion {   margin-left: 0;   padding: 1px 4px;   background-color: #666;   color: #fff; }  #sfWebDebugviewDetails ul {   padding-left: 2em;   margin: .5em 0;   list-style: none; }  #sfWebDebugviewDetails li {   margin-bottom: .5em; }  #sfWebDebug .sfWebDebugDataType, #sfWebDebug .sfWebDebugDataType a {   color: #666;   font-style: italic; }  #sfWebDebug .sfWebDebugDataType a:hover {   text-decoration: underline; }  #sfWebDebugDatabaseLogs {   margin-bottom: 10px; }  #sfWebDebugDatabaseLogs ol {   margin: 0;   padding: 0;   margin-left: 20px;   list-style: number; }  #sfWebDebugDatabaseLogs li {   padding: 6px; }  #sfWebDebugDatabaseLogs li:nth-child(odd) {   background-color: #CCC; }  .sfWebDebugDatabaseQuery {   margin-bottom: .5em;   margin-top: 0; }  .sfWebDebugDatabaseLogInfo {   color: #666;   font-size: 11px; }  .sfWebDebugDatabaseQuery .sfWebDebugLogInfo {   color: #909;   font-weight: bold; }  .sfWebDebugHighlight {   background: #FFC; }
    #sf_admin_container{
        width: 750;
        margin: 0 auto;
        font-size: 11px;
    }

    a:active {
        text-decoration: none;
        color: #48732A;
    }

    a:link {
        text-decoration: none;
        color: #48732A;
    }

    a:visited {
        text-decoration: none;
        color: #48732A;
    }

    a:hover {
        text-decoration: underline;
    }
    #DivSelecionadas{
        width:750px;
        height:150px;
        overflow-x:hidden;
        overflow-y:scroll;
        font-size: 11px;
        font-weight:normal;
    }
    #DivPPal{
        width:750px;
        height:240px;
        overflow-x:hidden;
        overflow-y:scroll;
        font-size: 11px;
        font-weight:normal;
    }
    #Div1{
        float:left;
        width:330px;
    }
    #Div2{
        float:left;
        width:330px;
    }
</style>
<script>
    $(document).ready(function() {
        $('#txt_filtar').keyup (function() {
            $('#Div_Filter').show();
            $('#Div_Filter_OK').hide();
            var txt_filtar = $('#txt_filtar').attr('value');
            $("#DivPPal").load('/tbtrial/FilterVariablesmeasured/txt/'+txt_filtar, function(){
                $('#Div_Filter').hide();
                if($('#txt_filtar').attr('value') != ''){
                    $('#Div_Filter_OK').show();
                }else{
                    $('#Div_Filter_OK').hide();
                }
            });
        });

        $('#ButtonSaveClosed').click (function() {
            $('#form_variablesmeasured').submit();
        });
        $('#ButtonResetAll').click (function() {
            window.parent.ResetListVarieties();
            $("#DivPPal").load('/tbtrial/VariablesmeasuredList/');
            $("#DivSelecionadas").html("");
        });
    });

    function SelectVariablesmeasured(check){
        var Valor = check.value;
        var txt_filtar = $('#txt_filtar').attr('value');
        if(txt_filtar == ''){
            txt_filtar = '9999';
        }
        if(check.checked){
            $("#DivPPal").load('/tbtrial/VariablesmeasuredList/txt_filtar/'+txt_filtar+'/Valor/'+Valor+'/Accion/Seleccionar');
            $("#DivSelecionadas").load('/tbtrial/SelectVariablesmeasured/Valor/'+Valor);

        }
    }

    function RemoveVariablesmeasured(check){
        var Valor = check.value;
        var txt_filtar = $('#txt_filtar').attr('value');
        if(txt_filtar == ''){
            txt_filtar = '9999';
        }
        if(!(check.checked)){
            $("#DivPPal").load('/tbtrial/VariablesmeasuredList/txt_filtar/'+txt_filtar+'/Valor/'+Valor+'/Accion/Quitar');
            $("#DivSelecionadas").load('/tbtrial/RemoveVariablesmeasured/Valor/'+Valor);
        }
    }

    function cambiacolor_over(celda){
        celda.style.backgroundColor="#1298F7";
    }
    function cambiacolor_out(celda,fila){
        if(fila % 2)
            celda.style.backgroundColor="#FFFFD9";
        else
            celda.style.backgroundColor="#C0C0C0";
    }
</script>


<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Variables Measured</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <form id="form_variablesmeasured" name="form_variablesmeasured" action="<?php echo url_for('@variablesmeasuredsave'); ?>" enctype="multipart/form-data" method="post">
                <table width="100%" cellspacing="1" cellpadding="10" border="1">
                    <tr>
                        <td colspan="4"><b style="font-size: 13px;">Filter: </b><input type="text" id="txt_filtar" name="txt_filtar" size="50" autocomplete="off" placeholder="Enter first letters of the variable measured name..." style="background-color: #F9EBB2; border: 2px solid #FFD511; font-size: 12px;">&ensp;<span id="Div_Filter" style="display:none;"><?php echo image_tag('loading4.gif', array('size' => '15x15')); ?></span><span id="Div_Filter_OK" style="display:none;"><?php echo image_tag('success.png', array('size' => '15x15')); ?></span></td>
                    </tr>
                    <tr align="center"><td colspan="4" align="center">&ensp;</td></tr>
                    <tr bgcolor="#C7C7C7">
                        <td width="<?php echo $width1; ?>"><label></label></td>
                        <td width="<?php echo $width2; ?>" align="left"><label>Name</label></td>
                        <td width="<?php echo $width3; ?>" align="left"><label>Trait class</label></td>
                        <td width="<?php echo $width4; ?>" align="left"><label>Definition</label></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="DivPPal">
                                <?php echo Variablesmeasured(); ?>
                            </div>
                        </td>
                    </tr>
                    <tr align="center"><td colspan="4" align="center">&ensp;</td></tr>
                    <tr align="center">
                        <td colspan="4" align="center">
                            <div class="fg-toolbar ui-widget-header ui-corner-all">
                                <h1>Selected</h1>
                            </div>
                        </td>
                    </tr>
                    <tr bgcolor="#C7C7C7">
                        <td width="<?php echo $width1; ?>"><label></label></td>
                        <td width="<?php echo $width2; ?>" align="left"><label>Name</label></td>
                        <td width="<?php echo $width3; ?>" align="left"><label>Trait class</label></td>
                        <td width="<?php echo $width4; ?>" align="left"><label>Definition</label></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="DivSelecionadas">
                                <?php echo SelectedVariablesmeasured(); ?>
                            </div>
                        </td>
                    </tr>
                    <tr align="center"><td colspan="4" align="center">&ensp;</td></tr>
                    <tr align="center">
                        <td align="center" <td colspan="4">
                            <button type="button" name="ButtonSaveClosed" id="ButtonSaveClosed" title="Save & Closed"><b>Save & Closed</b></button>
                            <button type="button" name="ButtonResetAll" id="ButtonResetAll" title="Reset All"><b>Reset All</b></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<?php

                                function Variablesmeasured() {
                                    $connection = Doctrine_Manager::getInstance()->connection();
                                    $user = sfContext::getInstance()->getUser();
                                    $WhereList = sfContext::getInstance()->getUser()->getAttribute('WhereList');
                                    $WhereVariety = sfContext::getInstance()->getUser()->getAttribute('WhereVariety');
                                    $WhereListVariablesMeasured = sfContext::getInstance()->getUser()->getAttribute('WhereListVariablesMeasured');

                                    $WhereList .= $WhereVariety . $WhereListVariablesMeasured;

                                    $id_crop = $user->getAttribute('id_crop');
                                    if ($id_crop == '') {
                                        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
                                        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
                                        echo "<script> alert('Before adding a Variables Measured, specify the Technology!'); self.parent.tb_remove();</script>";
                                        Die();
                                    }

                                    $session_variablesmeasured_campo = $user->getAttribute('variablesmeasured_id');
                                    $NotIn = "";
                                    if (count($session_variablesmeasured_campo) > 0) {
                                        foreach ($session_variablesmeasured_campo AS $Value) {
                                            $NotIn .= "$Value,";
                                        }
                                        $NotIn = substr($NotIn, 0, strlen($NotIn) - 1);
                                        $AndNotIn = "AND V.id_variablesmeasured NOT IN ($NotIn)";
                                    }

                                    $width1 = '5%';
                                    $width2 = '35%';
                                    $width3 = '20%';
                                    $width4 = '40%';

                                    if (strpos($WhereList, "AND TV.id_variety IN")) {
                                        $QUERY = "SELECT V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition ";
                                        $QUERY .= "FROM tb_variablesmeasured V ";
                                        $QUERY .= "INNER JOIN tb_trialvariablesmeasured TVM ON V.id_variablesmeasured = TVM.id_variablesmeasured ";
                                        $QUERY .= "INNER JOIN tb_trial T2 ON TVM.id_trial = T2.id_trial ";
                                        $QUERY .= "INNER JOIN tb_traitclass TC ON V.id_traitclass = TC.id_traitclass ";
                                        $QUERY .= "INNER JOIN tb_trialvariety TV ON T2.id_trial = TV.id_trial ";
                                        $QUERY .= "WHERE true $WhereList $AndNotIn ";
                                        $QUERY .= "GROUP BY V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition ";
                                        $QUERY .= "ORDER BY V.vrmsname,TC.trclname ";
                                    } else {
                                        $QUERY = "SELECT V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition ";
                                        $QUERY .= "FROM tb_variablesmeasured V ";
                                        $QUERY .= "INNER JOIN tb_trialvariablesmeasured TVM ON V.id_variablesmeasured = TVM.id_variablesmeasured ";
                                        $QUERY .= "INNER JOIN tb_trial T2 ON TVM.id_trial = T2.id_trial ";
                                        $QUERY .= "INNER JOIN tb_traitclass TC ON V.id_traitclass = TC.id_traitclass ";
                                        $QUERY .= "WHERE true $WhereList $AndNotIn ";
                                        $QUERY .= "GROUP BY V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition ";
                                        $QUERY .= "ORDER BY V.vrmsname,TC.trclname ";
                                    }
                                    $Results = $connection->execute($QUERY);
                                    $Record = $Results->fetchAll();
                                    $total = count($Record);
                                    $flag = 1;
                                    $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
                                    $bgcolor = "#C0C0C0";
                                    foreach ($Record AS $Value) {
                                        if ($bgcolor != "#FFFFD9")
                                            $bgcolor = "#FFFFD9";
                                        else
                                            $bgcolor = "#C0C0C0";

                                        $html .= "<tr bgcolor='$bgcolor' id=fila$flag name=fila$flag onmouseover=\"cambiacolor_over(this)\" onmouseout=\"cambiacolor_out(this,$flag)\">";
                                        $html .= "<td width=$width1><input type='checkbox' name='variablesmeasured$flag' id='variablesmeasured$flag' value='$Value[0]' onclick=SelectVariablesmeasured(this)></td>";
                                        $html .= "<td width=$width2>$Value[1]</td>";
                                        $html .= "<td width=$width3>$Value[2]</td>";
                                        $html .= "<td width=$width4>$Value[3]</td>";
                                        $html .= "</tr>";
                                        $flag++;
                                    }
                                    $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";

                                    return $html;
                                }

                                function SelectedVariablesmeasured() {
                                    $connection = Doctrine_Manager::getInstance()->connection();
                                    $user = sfContext::getInstance()->getUser();
                                    $session_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
                                    $width1 = '5%';
                                    $width2 = '35%';
                                    $width3 = '20%';
                                    $width4 = '40%';
                                    $flag = 1;
                                    $html = '<table width="100%" cellspacing="1" cellpadding="10" border="1">';
                                    $total = count($session_variablesmeasured_id);
                                    if ($total > 0) {
                                        foreach ($session_variablesmeasured_id AS $variablesmeasured_id) {
                                            $QUERY01 = "SELECT V.id_variablesmeasured,V.vrmsname,TC.trclname,V.vrmsdefinition FROM tb_variablesmeasured V INNER JOIN tb_traitclass TC ON V.id_traitclass = TC.id_traitclass WHERE V.id_variablesmeasured = $variablesmeasured_id";
                                            $Results = $connection->execute($QUERY01);
                                            $Record = $Results->fetchAll();
                                            foreach ($Record AS $Value) {
                                                $checked = 'checked';
                                                $html .= "<tr bgcolor='#DEBF43' id=fila$flag name=fila$flag onmouseover=\"this.style.backgroundColor='#1298F7'\" onmouseout=\"this.style.backgroundColor='#DEBF43'\">";
                                                $html .= "<td width=$width1><input type='checkbox' $checked name='variablesmeasured$flag' id='variablesmeasured$flag' value='$Value[0]' onclick=RemoveVariablesmeasured(this,$flag,'$bgcolor')></td>";
                                                $html .= "<td width=$width2>$Value[1]</td>";
                                                $html .= "<td width=$width3>$Value[2]</td>";
                                                $html .= "<td width=$width4>$Value[3]</td>";
                                                $html .= "</tr>";
                                                $flag++;
                                            }
                                        }
                                    }
                                    $html .= "</table><input type='hidden' id='datos' name='datos' value='$total'>";

                                    return $html;
                                }
?>