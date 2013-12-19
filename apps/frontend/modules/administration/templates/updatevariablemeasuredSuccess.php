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
<script>
    $(document).ready(function() {
        $('#updatevariablemeasuredsearch').click(function() {
            if($('#id_crop').attr('value') == ''){
                jAlert('error', 'Technology','Incomplete Data', null);
            }else{
                $('#div_loading').show();
                $('#updatevariablemeasured').submit();
            }
        });

        $('#updatevariablemeasuredclear').click(function() {
            $('#id_crop').val("");
        });
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Update Variable Measured</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div>
        <form id="updatevariablemeasured" name="updatevariablemeasured" action="<?php echo url_for('@updatevariablemeasured'); ?>" enctype="multipart/form-data" method="post">
            <table align="center">
                <tr>
                <tr>
                    <td nowrap><b>Technology:</b></td>
                    <td> <?php echo select_from_table_special("id_crop","TbCrop","id_crop","crpname",null,$id_crop); ?></td>
                </tr>
                <tr align="center">
                    <td align="center" colspan="6">
                        <input type="button" value="Update" id="updatevariablemeasuredsearch">
                        <input type="button" value="Clear" id="updatevariablemeasuredclear">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <br>
</div>
<?php 
function select_from_table_special($name, $table, $idfield, $namefield, $wheretable, $value) {
    $QUERY00 = Doctrine_Query::create()
            ->select("$idfield AS id, ($namefield) AS name")
            ->from("$table")
            ->where("id_crop IN (1,2,4,11,5,14,8)")
            ->orderBy("$namefield");
    //echo $QUERY00->getSqlQuery();
    $Resultado00 = $QUERY00->execute();
    $OPTION = "<OPTION VALUE=''></OPTION>";
    foreach ($Resultado00 AS $fila) {
        $selected = "";
        if ($fila['id'] == $value)
            $selected = "selected";
        $OPTION .= "<OPTION VALUE='{$fila['id']}' $selected>{$fila['name']}</OPTION>";
    }
    $HTML = "<SELECT NAME='$name' id='$name' SIZE='1'>";
    $HTML .= $OPTION;
    $HTML .= "</SELECT>";
    return $HTML;
}
?>