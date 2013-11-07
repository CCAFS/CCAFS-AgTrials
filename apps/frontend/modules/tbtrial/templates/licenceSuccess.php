<?php
use_stylesheet('/sfAdminThemejRollerPlugin/css/reset.css', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery.min.js', 'first');
use_javascript('/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js', 'first');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/jroller.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.menu.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/fg.buttons.css');
use_stylesheet('/sfAdminThemejRollerPlugin/css/ui.selectmenu.css');
use_javascript('/sfAdminThemejRollerPlugin/js/fg.menu.js');
use_javascript('/sfAdminThemejRollerPlugin/js/jroller.js');
use_javascript('/sfAdminThemejRollerPlugin/js/ui.selectmenu.js');
?>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Licence</h1>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <br>
            <span id="licence">
                <b>IMPORTANT: Read this before you build your license </b>
                <br><br>
                We now ask you to designate the intellectual property rights of the agricultural evaluation data you are registering through this application. Click on the
                <a href="http://creativecommons.org/choose/" alt="Commons License Generator">creative commons logo</a>
                below and you will be taken to a license generator developed by Creative Commons. It will ask you a series of questions whose responses determine the data sharing and use policy for your data set. At this point, the application will develop lines of computer code designating the intellectual property rights. Copy these lines of code from the pop-up window back into the main window of the application.
            </span>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div align="center">
                <a href="http://creativecommons.org/choose/" alt="Commons License Generator"><b><?php echo image_tag('creative_commons.jpeg'); ?></b></a>
            </div>
        </div>
    </div>

</div>
