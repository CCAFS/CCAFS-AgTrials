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
$session_trialgroup_id = $user->getAttribute('trialgroup_id');
$session_trialgroup_name = $user->getAttribute('trialgroup_name');
$selected = "";
if (isset($session_trialgroup_id)) {
    foreach ($session_trialgroup_id as $key => $trialgroup_id) {
        $selected .= '{id:' . intval($trialgroup_id) . ',title:"' . htmlspecialchars(str_replace(',', '-', $session_trialgroup_name[$key]), ENT_QUOTES, 'UTF-8') . '"},';
    }
}
?>
<script type="text/javascript">
$(function(){
    $('#trialgroups_id').autocompletetrialgroups({
        selected: [<?php if ($selected)  echo $selected; ?>]
    });

});
</script>

<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Trial Groups</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <form id="trialgroups" name="trialgroups" action="<?php echo url_for('@savetrialgroups'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr align="center">
                        <td align="center">
                            <fieldset align="center">
                                <div>
                                    <input id="trialgroups_id" name="trialgroups_id" type="text" size="50" />
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