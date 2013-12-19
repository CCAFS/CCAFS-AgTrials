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
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<style type="text/css">
  a {text-decoration: none;}
a:hover {text-decoration: underline;}
    
 div.resultados {
  width:1135px;
  height:600px;
  overflow:scroll;
  }

#tablecss{
    border:1px solid #FFD90F;
}
#campos{
    background-color:#6C8E54;
    color:white;
    font-size:14px;
    font-weight:bold;
    text-align: center;

}

#trdatos{
    background-color:#6C8E54;
}

#tddatos{
    border:1px solid #FFD90F;
}

#tddatos2{
    border:1px solid #FFD90F;
    text-align: center;
}

#bold{
    border:0px solid #FFD90F;
    font-size:15px;
    font-weight:bold;
}

#creador{
    border:1px solid #FFD90F;
    font-size:12px;
    font-weight:bold;
    background-color:#6C8E54;
}

#mensaje{
    border:1px solid #FFD90F;
    font-size:13px;
    background-color:#F9F8F6;
}

</style>
<script>
    $(document).ready(function() {
        $('#publishsubmit').click(function() {
            $('#div_loading').show();
            $('#form_message').submit();
        });

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>
            <?php echo image_tag('conversation-icon.png'); ?>
            <a href="forum">Forum</a> 
            <?php echo $ctgname.$thmname; ?> 
        </h1>
    </div>
    <div id="sf_admin_content">
        <br>
        <table id="tablecss" align="center" border="1" width="100%">
            <?php
                if(count($message) == 0)
                    echo "<span>No Message</span><br>";
                foreach ($message AS $Resultado) {
            ?>
                    <tr>
                        <td id="creador" width="15%">
                            <b><?php echo $Resultado->user; ?></b><br>
                            <?php echo $Resultado->created_at; ?>
                        </td>
                        <td id="mensaje" width="85%">
                            <?php echo html_entity_decode($Resultado->mnsmessage); ?>
                        </td>
                    </tr>
            <?php } ?>
         </table>
        <br>
        <?php if ($sf_user->isAuthenticated()) { ?>
            <form id="form_message" name="form_message" action="<?php echo url_for('@savemessage'); ?>" enctype="multipart/form-data" method="post">
                <table align="center">
                    <tr>
                        <td id="bold">Post a comment</td>
                    </tr>
                    <tr>
                        <td>
                            <textarea id="txtmessage" name="txtmessage" title="Message" rows="2" cols="100"></textarea>
                            <script type="text/javascript">
                                tinyMCE.init({
                                mode:                              "exact",
                                elements:                          "txtmessage",
                                theme:                             "advanced",
                                width:                             "800px",
                                height:                            "200px",
                                theme_advanced_toolbar_location:   "top",
                                theme_advanced_toolbar_align:      "left",
                                theme_advanced_statusbar_location: "bottom",
                                theme_advanced_resizing:           true
                                });
                            </script>
                        </td>
                    </tr>
                    <tr align="center">
                        <td align="center">
                            <input type="hidden" id="id_theme" name="id_theme" value="<?php echo $id_theme; ?>">
                            <input type="button" value="Publish" id="publishsubmit">
                            <input type="button" value="Back" OnClick="location.href='/theme?cat=<?php echo $id_category; ?>'">
                        </td>
                    </tr>
                </table>
            </form>
        <?php }else{ ?>
            <tr align="center">
                <td align="center">
                            <input type="button" value="Back" OnClick="location.href='/theme?cat=<?php echo $id_category; ?>'">
                </td>
            </tr>
        <?php } ?>
    </div>

</div>