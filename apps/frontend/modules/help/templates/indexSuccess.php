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
<style type="text/css">
    a {text-decoration: none;}
    a:hover {text-decoration: underline;}
    #bold{
        border:0px solid #87B6D9;
        font-size:15px;
        font-weight:bold;
    }

</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Help</h1>
    </div>
    <br>
    <div id='bold'><?php echo image_tag('foro.jpg') . link_to('Forum & Frequently Asked Questions', '@forum'); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Trial', '/help/help', array('query_string' => 'opt=Trial')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Location', '/help/help', array('query_string' => 'opt=Location')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Variety', '/help/help', array('query_string' => 'opt=Variety')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Variables Measured', '/help/help', array('query_string' => 'opt=Variables_Measured')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Trial Site', '/help/help', array('query_string' => 'opt=Trial_Site')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Locating Trial Site', '/help/help', array('query_string' => 'opt=Locating_Trial_Site')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Localizacion Sitios de Ensayo', '/help/help', array('query_string' => 'opt=Localizacion_Sitios_Ensayo')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('How to upload trial data in batch mode', '/help/help', array('query_string' => 'opt=How_to_upload_the_batch_trialV3')); ?></div><br>
    <div id='bold'><?php echo image_tag('Help-icon-2.png') . link_to('Frequently Asked Questions', '/theme?cat=2'); ?></div><br>
    <br>
</div>