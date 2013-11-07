<link href="/autocompletemultiple/jquery-ui/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Clear Cache</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <table align="center">
                <br>
                <tr align="center">
                    <td align="center">
                        <?php
                            foreach ($out AS $valor) {
                                echo "$valor <br>";
                            }
                        ?>
                        <br>
                    </td>
                </tr>
                <tr align="center">
                    <td align="center">
                        <input type="button" value="Menu" OnClick="window.location = '/administration'">
                        <input type="button" value="Done" OnClick="window.location = '/'">
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>