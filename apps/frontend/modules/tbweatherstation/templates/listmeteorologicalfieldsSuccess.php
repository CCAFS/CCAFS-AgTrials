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
?>
<style type="text/css">
    #DivPPal{
        width:680px;
        height:200px;
        overflow-x:hidden;
        overflow-y:scroll;
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
        <h1>Meteorological Fields</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <form id="meteorologicalfields" name="meteorologicalfields" action="<?php echo url_for('@savelistmeteorologicalfields'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr align="center">
                        <td align="center">
                            <div id="DivPPal">
                                <?php echo SesionMeteorologicalFields(); ?>
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

function SesionMeteorologicalFields() {
    $connection = Doctrine_Manager::getInstance()->connection();
    $user = sfContext::getInstance()->getUser();
    $session_meteorologicalfields_id = $user->getAttribute('meteorologicalfields_id');

    $QUERY = "SELECT id_meteorologicalfields,mtflname,mtflunit FROM tb_meteorologicalfields ORDER BY mtflname";
    $Results = $connection->execute($QUERY);
    $Record = $Results->fetchAll();
    $total = count($Record);
    $corte = round($total / 2);
    $flag = 1;
    $html = "<div id='Div1'>";
    foreach ($Record AS $Value) {
        $checked = '';
        if (count($session_meteorologicalfields_id) > 0) {
            if (in_array($Value[0], $session_meteorologicalfields_id)) {
                $checked = 'checked';
            }
        }
        if ($flag <= $corte) {
            $html .= "<input type='checkbox' $checked name='meteorologicalfields$flag' value='$Value[0]'>$Value[1] - ($Value[2]) <br>";
        } else {
            if ($flag == $corte + 1)
                $html .= "</div><div id='Div2'><input type='checkbox' $checked name='meteorologicalfields$flag' value='$Value[0]'>$Value[1] - ($Value[2]) <br>";
            else
                $html .= "<input type='checkbox' $checked name='meteorologicalfields$flag' value='$Value[0]'>$Value[1] - ($Value[2]) <br>";
        }
        $flag++;
    }
    $html .= "</div><input type='hidden' id='datos' name='datos' value='$total'>";

    return $html;
}
?>