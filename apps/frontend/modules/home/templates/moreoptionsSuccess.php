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
$pop = sfContext::getInstance()->getRequest()->getParameterHolder()->get('pop');
?>
<script>
function enviar(modulo){
    parent.document.location.href='/'+modulo;
    self.parent.tb_remove();
}
</script>
<style type="text/css">
<!--
.style2 {font-size: 16px}
-->
</style>

<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>More Options</h1>
    </div>
    <div>
        <blockquote>
          <p>
              <span class="style2">
                  <?php if($pop == 'other'){ ?>
                        <a title="Trial Group" onclick="enviar('tbobjective');" href="#">Objective</a><br>
                        <a title="Primary Discipline" onclick="enviar('tbprimarydiscipline');" href="#">Primary Discipline</a><br>
                        <a title="Trial Site" onclick="enviar('tbtrialsite');" href="#">Trial Site</a><br>
                        <a title="Field Name Number" onclick="enviar('tbfieldnamenumber');" href="#">Field Name Number</a><br>
                        <a title="Institution" onclick="enviar('tbinstitution');" href="#">Institution</a><br>
                        <a title="Variety/Race" onclick="enviar('tbcontactperson');" href="#">Contact person</a><br>
                        <a title="Variety/Race" onclick="enviar('tbvariety');" href="#">Variety/Race</a><br>
                        <a title="Variables Measured" onclick="enviar('tbvariablesmeasured');" href="#">Variables Measured</a><br>
                        <a title="Location" onclick="enviar('tblocation');" href="#">Location</a><br>
                        <a title="Origin" onclick="enviar('tborigin');" href="#">Origin</a><br>
                        <a title="Crop/Animal" onclick="enviar('tbcrop');" href#">Technology</a><br>
                        <a title="Trait Class" onclick="enviar('tbtraitclass');" href="#">Trait Class</a><br>
                        <a title="Contact Person Type" onclick="enviar('tbcontactpersontype');" href="#">Contact Person Type</a><br>
                        <a title="Trial Group Type" onclick="enviar('tbtrialgrouptype');" href#">Trial Group Type</a><br>
                        <a title="Trial Environment Type" onclick="enviar('tbtrialenvironmenttype');" href="#">Trial Environment Type</a><br>
                        <a title="Network" onclick="enviar('tbnetwork');" href="#">Network</a><br>
                        <a title="Country" onclick="enviar('tbcountry');" href="#">Country</a><br>
                  <?php }elseif($pop == 'admin'){ ?>
                        <?php
                            $Username = sfContext::getInstance()->getUser()->getUsername();
                            $sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneBy("Username", $Username);
                            if ($sfGuardUser->is_super_admin) {
                        ?>
                                <a title="User" onclick="enviar('sfGuardUser/user');" href="#">User</a><br>
                                <a title="Users" onclick="enviar('sfGuardUser');" href="#">Users</a><br>
                        <?php } else { ?>
                                <a title="User" onclick="enviar('sfGuardUser/user');" href="#">User</a><br>
                        <?php } ?>
                        <a title="Change password" onclick="self.parent.tb_remove();" href="http://gisweb.ciat.cgiar.org/trialsitesblog/wp-login.php" target="_blank">Login Blog</a><br>
                        <a title="Change password" onclick="enviar('sfGuardUser/changepassword');" href="#">Change password</a><br>
                        <a title="Communications" onclick="enviar('communications');" href="#">Communications</a><br>
                        <a title="Administration" onclick="enviar('administration');" href="#">Administration</a><br>

                  <?php } ?>
              </span>
            </p>
        </blockquote>
    </div>
</div>