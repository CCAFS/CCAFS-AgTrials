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
$user = sfContext::getInstance()->getUser();
$session_weatherstation_id = $user->getAttribute('weatherstation_id');
$session_weatherstation_name = $user->getAttribute('weatherstation_name');
$selected = "";
if (isset($session_weatherstation_id)) {
    foreach ($session_weatherstation_id as $key => $id_weatherstation) {
        $selected .= '{id:' . intval($id_weatherstation) . ',title:"' . htmlspecialchars(str_replace(',', '-', $session_weatherstation_name[$key]), ENT_QUOTES, 'UTF-8') . '"},';
    }
}
?>
<script type="text/javascript">
$(function(){
    $('#weatherstation_id').autocompleteweatherstations({
        selected: [<?php if ($selected)  echo $selected; ?>]
    });

});
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Weather stations</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <form id="trialsiteweatherstation" name="trialsiteweatherstation" action="<?php echo url_for('@savetrialsiteweatherstation'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr align="center">
                        <td align="center">
                            <fieldset align="center">
                                <div>
                                    <input id="weatherstation_id" name="weatherstation_id" type="text" size="50" />
                                </div>
                                <br>
                            </fieldset>
                        </td>
                    </tr>
                </table>
                <table align="center">
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