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
<script>
    $(document).ready(function() {
        $('#DownloadData').click(function() {
            var Enviar = false;
            var count_variablesmeasured = $('#count_variablesmeasured').attr('value');
            for (var a = 1; a <= count_variablesmeasured; a++) {
                if ($("#variablesmeasured" + a).is(':checked')) {
                    Enviar = true;
                }
            }
            if (Enviar) {
                $('#form').val("add");
                $('#Form').val("Enviar");
                $('#FormDownloadData').submit();
            } else {
                jAlert('error', 'Please, Choose Any Variable Measured for Download', 'Incomplete Information', null);
            }
        });
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Choose Variable Measured for Download</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="FormDownloadData" name="FormDownloadData" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr><td colspan="2">&ensp;</td></tr>
                    <tr><td colspan="2"><?php echo html_entity_decode($HTML); ?></td></tr>
                    <tr><td colspan="2">&ensp;</td></tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="button" value="Download Data" id="DownloadData" name="DownloadData"/>
                            <input type="hidden" value="" id="Form" name="Form"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </div>