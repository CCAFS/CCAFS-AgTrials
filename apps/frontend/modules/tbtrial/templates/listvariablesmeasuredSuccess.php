<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<link href="/autocompletemultiple/autocomplete.css" rel="stylesheet" type="text/css" />
<link href="/autocompletemultiple/jquery-ui/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script src="/autocompletemultiple/jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="/autocompletemultiple/jquery-ui/js/jquery-ui-1.8.6.custom.min.js" type="text/javascript"></script>
<script src="/autocompletemultiple/autocomplete.js" type="text/javascript"></script>
<script src="/js/jquery.alerts.js" type="text/javascript"></script>
<?php

$user = sfContext::getInstance()->getUser();
$id_crop = $user->getAttribute('id_crop');
if ($id_crop == '') {
    sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
    sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
    echo "<script> alert('Before adding a variables measured, specify the Technology!'); self.parent.tb_remove();</script>";
    Die();
}
$consulta = Doctrine::getTable('Tbcrop')->findOneByIdCrop($id_crop);
$session_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');
$session_variablesmeasured_name = $user->getAttribute('variablesmeasured_name');
if (isset($session_variablesmeasured_id)) {
    $consulta1 = Doctrine::getTable('Tbvariablesmeasured')->findOneByIdVariablesmeasured($session_variablesmeasured_id[0]);
    $crop_ant = $consulta1->getIdCrop();
    if ($id_crop != $crop_ant) {
        $session_variablesmeasured_id = null;
        $session_variablesmeasured_name = null;
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_id');
        sfContext::getInstance()->getUser()->getAttributeHolder()->remove('variablesmeasured_name');
    }
}
$selected = "";
if (isset($session_variablesmeasured_id)) {
    foreach ($session_variablesmeasured_id as $key => $id_variablesmeasured) {
        $selected .= '{id:' . intval($id_variablesmeasured) . ',title:"' . htmlspecialchars(str_replace(',', '-', $session_variablesmeasured_name[$key]), ENT_QUOTES, 'UTF-8') . '"},';
    }
}
?>
<script type="text/javascript">
    $(function(){
        $('#variablesmeasured_id').autocompletevariablesmeasured({
            selected: [<?php
if ($selected)
    echo $selected;
?>]
            });
        });
</script>
<style type="text/css">
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
    #DivPPal{
        width:680px;
        height:480px;
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
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1><?php echo "{$consulta->getCrpname()} Variables Measured"; ?></h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <form id="variablesmeasured" name="variablesmeasured" action="<?php echo url_for('@savelistvariablesmeasured'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr align="center">
                        <td align="center">
                            <div id="DivPPal">
                                <?php echo SesionVariablesMeasured(); ?>
                            </div>
                        </td>
                    </tr>
                    <tr align="center"><td align="center">&ensp;</td></tr>
                    <tr align="center">
                        <td align="center">
                            <input type="submit" value=" Save & Close " id="submit">
                        </td>
                    </tr>
                </table>
            </form>
            <br>
        </div>
    </div>
</div>

<?php

                                function SesionVariablesMeasured() {
                                    $connection = Doctrine_Manager::getInstance()->connection();
                                    $user = sfContext::getInstance()->getUser();
                                    $id_crop = $user->getAttribute('id_crop');
                                    $session_variablesmeasured_id = $user->getAttribute('variablesmeasured_id');

                                    $QUERY = "SELECT id_variablesmeasured,vrmsname FROM tb_variablesmeasured WHERE id_crop = $id_crop ORDER BY vrmsname";
                                    $Results = $connection->execute($QUERY);
                                    $Record = $Results->fetchAll();
                                    $total = count($Record);
                                    $corte = round($total / 2);
                                    $flag = 1;
                                    $html = "<div id='Div1'>";
                                    foreach ($Record AS $Value) {
                                        $checked = '';
                                        if (count($session_variablesmeasured_id) > 0) {
                                            if (in_array($Value[0], $session_variablesmeasured_id)) {
                                                $checked = 'checked';
                                            }
                                        }

                                        if ($flag <= $corte) {
                                            $html .= "<input type='checkbox' $checked name='variablesmeasured$flag' value='$Value[0]'><a href='#' title='View Detail' onclick=\"window.open('/ViewVariablesMeasured/id/$Value[0]','ViewVariablesMeasured','height=400,width=700,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> $Value[1]</a> <br>";
                                        } else {
                                            if ($flag == $corte + 1)
                                                $html .= "</div><div id='Div2'><input type='checkbox' $checked name='variablesmeasured$flag' value='$Value[0]'><a href='#' title='View Detail' onclick=\"window.open('/ViewVariablesMeasured/id/$Value[0]','ViewVariablesMeasured','height=400,width=700,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> $Value[1]</a> <br>";
                                            else
                                                $html .= "<input type='checkbox' $checked name='variablesmeasured$flag' value='$Value[0]'><a href='#' title='View Detail' onclick=\"window.open('/ViewVariablesMeasured/id/$Value[0]','ViewVariablesMeasured','height=400,width=700,scrollbars=1')\" href=\"\"><span style=\"color: #48732A;\"><img width=\"12\" height=\"12\" src=\"/images/lens-icon.png\"> $Value[1]</a> <br>";
                                        }
                                        $flag++;
                                    }
                                    $html .= "</div><input type='hidden' id='datos' name='datos' value='$total'>";

                                    return $html;
                                }
?>