<link href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<link href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/autocompletemultiple/autocomplete.css" rel="stylesheet" type="text/css" />
<link href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/autocompletemultiple/jquery-ui/css/reset.css" rel="stylesheet" type="text/css" />
<script src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/autocompletemultiple/jquery-1.4.3.min.js" type="text/javascript"></script>
<script src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/autocompletemultiple/jquery-ui/js/jquery-ui-1.8.6.custom.min.js" type="text/javascript"></script>
<script src="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/autocompletemultiple/autocomplete.js" type="text/javascript"></script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Oops! Page Not Founds</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <ul class="sfTIconList">
                <br><br>
                <a href="javascript:history.go(-1)"> * Back to previous page</a><br>
                <?php echo link_to(' * Go to Homepage', '@homepage') ?>
                <br><br>
            </ul>
        </div>
    </div>
</div>