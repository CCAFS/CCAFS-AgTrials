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
    a:active {
        text-decoration: none;
        color: #48732A;
        font-size: 14px;
    }

    a:link {
        text-decoration: none;
        color: #48732A;
        font-size: 14px;
    }

    a:visited {
        text-decoration: none;
        color: #48732A;
        font-size: 14px;
    }

    a:hover {
        text-decoration: none;
        color: #659831;
        font-size: 14px;
    }

    .divdetail {
        background-color:#FFFFFF;
        border:1px solid;
        border-color: #FFD90F;
        display: none;
    }
    .detail {
        border:1px solid;
        border-color: #FFD90F;
    }

    .image{
        text-align: center;
        vertical-align:top;
    }

    .name{
        border:1px solid;
        border-color: #FFD90F;
        text-align: center;
    }

    .number{
        border:1px solid;
        border-color: #FFD90F;
        text-align: right;
    }
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Search</h1>
    </div>
    <div>
        <script>
            (function() {
                var cx = '011202367318939728698:omcs8jimj9k';
                var gcse = document.createElement('script');
                gcse.type = 'text/javascript';
                gcse.async = true;
                gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                    '//www.google.com/cse/cse.js?cx=' + cx;
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(gcse, s);
            })();
        </script>
        <gcse:search></gcse:search>
    </div>
</div>