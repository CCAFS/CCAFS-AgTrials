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
use_helper('Thickbox');
?>
<script>
    $(document).ready(function() {
        $('#id_crop_batchupload').change(function() {
            var id_crop = $('#id_crop_batchupload').attr('value');
            $('#varieties').val("");
            $('#variablesmeasured').val("");
            $.ajax({
                type: "GET",
                url: "/tbtrial/assigncrop/",
                data:"id_crop="+id_crop,
                success: function(){}
            });

        });
        
        //VALIDAMOS LA SELECION DE CRITERIOS
        $('#next').click(function() {
            if($('#id_crop_batchupload').attr('value') == ''){
                jAlert('error', '* Technology','Incomplete Information', null);
            }else if($('#varieties').attr('value') == ''){
                jAlert('error', '* Varieties/Race','Incomplete Information', null);
            }else if($('#variablesmeasured').attr('value') == ''){
                jAlert('error', '* Variables measured','Incomplete Information', null);
            }else{
                $('#div_loading').show();
                $('#flag_step').attr('value',false);
                $('#form1').submit();           
            }
        });
        
        //VALIDAMOS LA SELECION DE CRITERIOS
        $('#step').click(function() {
            $('#div_loading').show();
            $('#flag_step').attr('value',true);
            $('#form1').submit();           
        });

        //VALIDAMOS EL CAMPO DE ALTITUDE
        $('#uploadsubmit').click(function() {
            validaFiles();
        });

        $('#file').blur(function() {
            var file = $('#file').attr('value');
            if(file != ''){
                var fragmento = file.split('.');
                var extension = fragmento[1];
                if(!((extension == 'zip') || (extension == 'ZIP'))){
                    $('#file').attr('value','');
                    $("#file").val('');
                    jAlert('error', 'Permitted file compressed(.Zip)','Invalid File', null);
                }
            }
        });

        $('#metadata').blur(function() {
            var metadata = $('#metadata').attr('value');
            if(metadata != ''){
                var fragmento = metadata.split('.');
                var extension = fragmento[1];
                if(!((extension == 'XLS') || (extension == 'xls'))){
                    $('#metadata').attr('value','');
                    $("#metadata").val('');
                    jAlert('error', 'Permitted file (.XLS)','Invalid File', null);
                }
            }
        });
        
        $('#data').blur(function() {
            var metadata = $('#data').attr('value');
            if(metadata != ''){
                var fragmento = metadata.split('.');
                var extension = fragmento[1];
                if(!((extension == 'XLS') || (extension == 'xls'))){
                    $('#data').attr('value','');
                    $("#data").val('');
                    jAlert('error', 'Permitted file (.XLS)','Invalid File', null);
                }
            }
        });

        function validaFiles(){
            var file = $('#file').attr('value');
            var metadata = $('#metadata').attr('value');
            if(metadata == ''){
                jAlert('error', 'Select Trial Template File','Invalid File', null);
            }else{
                $('#div_loading').show();
                $('#batchupload').submit();
            }
        }
    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <?php if ($form) {
    ?>
        <div class="fg-toolbar ui-widget-header ui-corner-all">
            <h1>Batch Upload Trials (Select Technology - Varieties/Race - Variables measured)</h1>
        </div>
        <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="form1" name="form1" action="<?php echo url_for('@batchupload'); ?>" enctype="multipart/form-data" method="post">
                <table align="center" width="945">
                    <tr><td colspan="2">&ensp;</td></tr>
                    <tr>
                        <td colspan="2">
                            <fieldset>
                                <legend align= "left">&ensp;<b>Attention</b>&ensp;</legend>
                                <span><?php echo link_to(image_tag('information-icon.png') . ' Templates Information', '@informationbatchupload', array('popup' => array('popupWindow', 'status=no,location=yes,resizable=no,width=1000,height=600,left=320,top=0'))); ?> </span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Templates Files must have <b>.xls</b> extension and must be smaller than <b>5 MB</b> maximum size </span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Compressed File must have <b>.zip</b> extension and must be smaller than <b>20 MB</b> maximum size </span></br>
								<span><?php echo image_tag('attention-icon.png'); ?> Exact number of columns <b>'20'</b> for Template File</span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Max. <b>300</b> trials with result templates files data </span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Max. <b>1000</b> trials without result templates files data </span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Don't close the window during the process </span>
                            </fieldset>
                        </td>
                    </tr>
                    <tr><td colspan="2">&ensp;</td></tr>
                    <tr>
                        <td><b>Technology:</b></td>
                        <td> <?php echo select_from_table("id_crop_batchupload", "TbCrop", "id_crop", "crpname", null, null); ?></td>
                    </tr>
                    <tr>
                        <td><b>Varieties/Race:</b></td>
                        <td><?php echo thickbox_iframe("<textarea id=\"varieties\" name=\"varieties\" readonly=\"readonly\" cols=\"58\" rows=\"2\">$varieties</textarea>" . image_tag('list-icon.png'), '@listvarieties', array('pop' => '1')) ?></td>
                    </tr>
                    <tr>
                        <td><b>Variables measured:</b></td>
                        <td><?php echo thickbox_iframe("<textarea id=\"variablesmeasured\" name=\"variablesmeasured\" readonly=\"readonly\" cols=\"58\" rows=\"2\">$variablesmeasured</textarea>" . image_tag('list-icon.png'), '@listvariablesmeasured', array('pop' => '1')) ?></td>
                    </tr>
                    <tr><td colspan="2">&ensp;</td></tr>
                    <tr>
                        <td align="center">
                            <input type="hidden" value="" name="VariablesMeasureds" id="VariablesMeasureds">
                            <button type="button" name="Next step" id="next" title="Next step"><?php echo image_tag("Next-icon.png"); ?> <b>Next step</b></button>
                            <button type="button" name="Skip this step" id="step" title="Skip this step"><?php echo image_tag("skip-right-icon.png"); ?> <b>Skip this step</b></button>
                            <input type="hidden" value="false" id="form" name="form"/>
                            <input type="hidden" value="" id="flag_step" name="flag_step"/>
                        </td>
                    </tr>
                    <tr><td colspan="2">&ensp;</td></tr>
                </table>
            </form>
        </div>
    </div>
    <?php } else {
    ?>
        <div class="fg-toolbar ui-widget-header ui-corner-all">
            <h1>Batch Upload Trials (Choose Files 'Trial Template - Trial Data Template - Compressed')</h1>
        </div>
        <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Copying files to the server, please wait...
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <table align="center" width="945">
                <form id="batchupload" name="batchupload" action="<?php echo url_for('@upload'); ?>" enctype="multipart/form-data" method="post">
                    <tr><td colspan="3">&ensp;</td></tr>
                    <tr>
                        <td colspan="3">
                            <fieldset>
                                <legend align= "left">&ensp;<b>Attention</b>&ensp;</legend>
                                <span><?php echo link_to(image_tag('information-icon.png') . ' Templates Information', '@informationbatchupload', array('popup' => array('popupWindow', 'status=no,location=yes,resizable=no,width=1000,height=600,left=320,top=0'))); ?> </span></br>
								<span><?php echo image_tag('attention-icon.png'); ?> Templates Files must have <b>.xls</b> extension and must be smaller than <b>5 MB</b> maximum size </span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Compressed File must have <b>.zip</b> extension and must be smaller than <b>20 MB</b> maximum size </span></br>
								<span><?php echo image_tag('attention-icon.png'); ?> Exact number of columns <b>'20'</b> for Template File</span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Max. <b>300</b> trials with result templates files data </span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Max. <b>1000</b> trials without result templates files data </span></br>
                                <span><?php echo image_tag('attention-icon.png'); ?> Don't close the window during the process </span>
                            </fieldset>
                        </td>
                    </tr>
                    <tr><td colspan="3">&ensp;</td></tr>
                    <?php if ($step == 'false') {
                    ?>
                        <tr>
                            <td colspan="3">
                                <fieldset>
                                    <legend align= "left">&ensp;<b>Download Templates</b>&ensp;</legend>
                                <?php
                                echo link_to(image_tag('excel-icon.png') . ' Trial Template File', "@downloadestruture") . "<br>";
                                echo link_to(image_tag('excel-icon.png') . ' Trial Data Template File', "@templatedownload");
                                ?>
                            </fieldset>
                        </td>
                    </tr>
                    <tr><td colspan="3">&ensp;</td></tr>
                    <?php } ?>

                            <tr>
                                <td><b>Trial Template File:</b></td>
                                <td><input type="file" name="metadata" id="metadata"/></td>
                                <td><li>Only is permitted file <b>.xls</b> and must be smaller than <b>5 MB</b> maximum size </li></td>
                            </tr>
                            <tr>
                                <td><b>Trial Data Template File:</b></td>
                                <td><input type="file" name="data" id="data"/></td>
                                <td><li>Only is permitted file <b>.xls</b> and must be smaller than <b>5 MB</b> maximum size </li></td>
                            </tr>
                            <tr><td colspan="3">&ensp;</td></tr>
                            <tr>
                                <td><b>Compressed Files:</b></td>
                                <td>
                                    <input type="file" name="file" id="file"/>
                                </td>
                                <td>
                                    <ul>
                                        <li>Results file</li>
                                        <li>Supplemental information file</li>
                                        <li>Weather during trial file</li>
                                        <li>Soil type conditions during trial file</li>
                                        <li>Only is permitted file <b>.zip</b> and must be smaller than <b>20 MB</b> maximum size</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr><td colspan="3">&ensp;</td></tr>
                            <tr align="center">
                                <td align="center" colspan="3">
                                    <button type="button" name="Back" id="Back" title="Back" onclick="history.back();"><?php echo image_tag("back-icon.png"); ?> <b>Back</b></button>
                                    <button type="button" name="Execute" id="uploadsubmit" title="Execute"><?php echo image_tag("execute-icon.png"); ?> <b>Execute</b></button>
                                </td>
                            </tr>
                            <tr><td colspan="3">&ensp;</td></tr>
                        </form>
                    </table>
                </div>
            </div>
    <?php } ?>
</div>