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
$QUERY00 = Doctrine_Query::create()
        ->select()
        ->from("TbVideo V")
        ->orderBy("V.id_video DESC");
$Resultado00 = $QUERY00->execute();
?>
<style type="text/css">
    .style6 {font-size: 16px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; }
</style>
<script>
    $(document).ready(function() {
        $('#videosubmit').click(function() {
            if($('#vdename').attr('value') == ''){
                jAlert('error', 'Name','Invalid', null);
            }else if($('#vdedescription').attr('value') == ''){
                jAlert('error', 'Description','Invalid', null);
            }else if($('#vdeurl').attr('value') == ''){
                jAlert('error', 'URL','Invalid', null);
            }else{
                $('#div_loading').show();
                $('#form_video').submit();
            }
        });
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Video</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="form_video" class="style1" name="form_video" action="<?php echo url_for('@video'); ?>" enctype="multipart/form-data" method="post">
                <table id="tablecss">
                    <br>
                    <tr>
                        <td><b>Name:</b></td>
                        <td><input type="text" name="vdename" id="vdename" size="36"></td>
                    </tr>
                    <tr>
                        <td><b>Description:</b></td>
                        <td><input type="text" name="vdedescription" id="vdedescription" size="36"></td>
                    </tr>
                    <tr>
                        <td><b>URL:</b></td>
                        <td><input type="text" name="vdeurl" id="vdeurl" size="36"></td>
                    </tr>
                    <tr align="center">
                        <td align="center" colspan="2">
                            <input type="button" value="Save" id="videosubmit">
                            <br>
                        </td>
                    </tr>
                </table>
            </form>
            <table width="789" height="64" border="1" bordercolor="#000000">
                <tr>
                    <td width="45" scope="col"><span class="style6">Id</span></td>
                    <td width="200" scope="col"><span class="style6">Name</span></td>
                    <td width="300" scope="col"><span class="style6">Description</span></td>
                    <td width="115" scope="col"><span class="style6">Date</span></td>
                </tr>
                <?php foreach ($Resultado00 AS $fila) { ?>
                    <tr>
                        <td><?php echo $fila['id_video']; ?></td>
                        <td><?php echo $fila['vdename']; ?></td>
                        <td><?php echo $fila['vdedescription']; ?></td>
                        <td><?php echo $fila['vdedate']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
