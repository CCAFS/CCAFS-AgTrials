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
if ($id_video != '') {
    $QUERY00 = Doctrine_Query::create()
            ->select()
            ->from("TbVideo V")
            ->where("V.id_video = $id_video")
            ->orderBy("V.id_video DESC");
} else {
    $QUERY00 = Doctrine_Query::create()
            ->select()
            ->from("TbVideo V")
            ->orderBy("V.id_video DESC");
}
$Resultado00 = $QUERY00->execute();
?> 
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>View Videos</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <table>
        <?php foreach ($Resultado00 AS $fila) { ?>
            <tr>
                <td><b><?php echo $fila['vdename']; ?></b></td>
            </tr>
            <tr>
                <td><?php echo $fila['vdeurl']; ?></td>
            </tr>
            <tr>
                <td><?php echo $fila['vdedescription']; ?></td>
            </tr>
            <tr>
                <td>&ensp;</td>
            </tr>
        <?php
        }
        if ($id_video != '') {
            ?>
            <tr>
                <td>
                    <span><a href="/viewvideo" title="More Videos..."><b>[More Videos...]</b></a></span>
                </td>
            </tr>
<?php } ?>
    </table>
</div>
