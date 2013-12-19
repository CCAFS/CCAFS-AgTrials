<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT" />
<meta name="description" content="The Global Agricultural Trial Repository" />
<meta name="keywords" content="Trials, Sites, Bibliography, CGIAR, CCAFS, CIAT" />
<meta name="language" content="en" />
<meta name="robots" content="index, follow" />
<title>The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT</title>
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/mqThickboxPlugin/css/thickbox.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/jquery.alerts.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/jroller.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/fg.menu.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" />
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/jquery.min.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="/js/jquery.alerts.js"></script>
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/js/jquery.simpletip-1.3.1.js"></script>
<script type="text/javascript" src="/js/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/js/jquery.qtip-1.0.0-rc3.min.js"></script>
<script type="text/javascript" src="/js/funtions.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/fg.menu.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/jroller.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/ui.selectmenu.js"></script>
<script type="text/javascript" src="/mqThickboxPlugin/js/thickbox.js"></script>

<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Batch Processes</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
</br>
<form id="Formbatchprocesses" name="Formbatchprocesses" action="<?php echo url_for('@batchprocesses'); ?>" enctype="multipart/form-data" method="post">
    <table>
        <tr><td><span> <?php echo image_tag('execute-icon.png'); ?><a title="Batch Upload Trials" href="/batchupload">&ensp;<b>Batch Upload Trials</b></a></span></td></tr>
        <tr><td><span> <?php echo image_tag('execute-icon.png'); ?><a title="Batch Upload Trial Groups" href="/batchuploadtrialgroup">&ensp;<b>Batch Upload Trial Groups</b></a></span></td></tr>
        <tr><td><span> <?php echo image_tag('execute-icon.png'); ?><a title="Batch Upload Trial Sites" href="/batchuploadtrialsite">&ensp;<b>Batch Upload Trial Sites</b></a></span></td></tr>
        <tr><td><span> <?php echo image_tag('execute-icon.png'); ?><a title="Batch Upload Varieties" href="/batchuploadvariety">&ensp;<b>Batch Upload Varieties</b></a></span></td></tr>
        <tr><td><span> <?php echo image_tag('execute-icon.png'); ?><a title="Batch Upload Variables Measured" href="/batchuploadvariablesmeasured">&ensp;<b>Batch Upload Variables Measured</b></a></span></td></tr>
        <tr><td><span> <?php echo image_tag('execute-icon.png'); ?><a title="Batch Upload Locations" href="/batchuploadlocation">&ensp;<b>Batch Upload Locations</b></a></span></td></tr>
    </table>
</form>
</br>
</div>
