<link href="/autocompletemultiple/jquery-ui/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<?php
$user = sfContext::getInstance()->getUser();
?>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Administration</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <table align="center">
                <br>
                <tr>
                    <td>
                        <h2><?php echo link_to('Upload Video','@video'); ?></h2><br>
                    </td>
                </tr>
               <tr>
                    <td>
                        <h2><?php echo link_to('Update variable measured','@updatevariablemeasured'); ?></h2><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h2><?php echo link_to('Log Transaction','@logtransaction'); ?></h2><br>
                    </td>
                </tr>
                <br>
                <tr>
                    <td>
                        <h2><?php echo link_to('Clear cache','/administration/clearcache'); ?></h2><br>
                    </td>
                </tr>
                <br>
                <tr>
                    <td>
                        <h2><?php echo link_to('Schema','/administration/schema'); ?></h2><br>
                    </td>
                </tr>
                <tr>
                    <td>&ensp;</td>
                </tr>
                <tr align="center">
                    <td align="center">
                        <input type="button" value="Done" OnClick="window.location = '/trialsites'">
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>