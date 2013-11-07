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
        
        //VALIDAMOS LA SELECION DE CRITERIOS
        $('#next').click(function() {
            if($('#id_weatherstation').attr('value') == ''){
                jAlert('error', '* Weather Station','Incomplete Information', null);
            }else if($('#meteorologicalfields').attr('value') == ''){
                jAlert('error', '* Meteorological Fields','Incomplete Information', null);
            }else{
                $('#div_loading').show();
                $('#form1').submit();           }
        });

        //VALIDAR Y ENVIAR EL FORMULARIO 2
        $('#uploadsubmit').click(function() {
            if($('#FileInformation').attr('value') == ''){
                jAlert('error', 'File Information','Invalid File', null);
            }else{
                $('#forma2').val(true);
                $('#div_loading').show();
                $('#form2').submit();
            }
        });


        $('#FileInformation').blur(function() {
            var metadata = $('#FileInformation').attr('value');
            if(metadata != ''){
                var fragmento = metadata.split('.');
                var extension = fragmento[1];
                if(!((extension == 'XLS') || (extension == 'XLSX') || (extension == 'xls') || (extension == 'xlsx'))){
                    $('#FileInformation').attr('value','');
                    $("#FileInformation").val('');
                    jAlert('error', 'Permitted file (.XLS - .XLSX)','Invalid File', null);
                }
            }
        });

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <?php if ($form) { ?>
        <div class="fg-toolbar ui-widget-header ui-corner-all">
            <h1>Part 1/2 - Batch Upload Meteorology</h1>
        </div>
        <div id="div_loading" class="loading" align="center" style="display:none;">
            <?php echo image_tag('loading.gif'); ?>
            <br>Please Wait...
        </div>
        <div id="sf_admin_content">
            <div class="sf_admin_form">
                <form id="form1" name="form1" action="<?php echo url_for('@batchuploadmeteorology'); ?>" enctype="multipart/form-data" method="post">
                    <table align="center">
                        <tr>
                            <td><b>Weather station:</b></td>
                            <td> <?php echo select_from_table("id_weatherstation", "TbWeatherstation", "id_weatherstation", "wtstname", null, null); ?></td>
                        </tr>
                        <tr>
                            <td><b>Meteorological fields:</b></td>
                            <td>
                                <?php echo thickbox_iframe("<textarea id=\"meteorologicalfields\" name=\"meteorologicalfields\" readonly=\"readonly\" cols=\"58\" rows=\"2\">$meteorologicalfields</textarea>" . image_tag('list-icon.png'), '@listmeteorologicalfields', array('pop' => '1')) ?>
                                <span id="add_meteorologicalfields">
                                    <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbmeteorologicalfields/new', array('pop' => '1')) ?>
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td align="center">
                                <input type="button" value="Next >>" id="next"/>
                                <input type="hidden" value="false" id="form" name="form"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <div class="fg-toolbar ui-widget-header ui-corner-all">
            <h1>Part 2/2 - Batch Upload Meteorology</h1>
        </div>
        <div id="div_loading" class="loading" align="center" style="display:none;">
            <?php echo image_tag('loading.gif'); ?>
            <br>Please Wait...
        </div>
        <div id="sf_admin_content">
            <div class="sf_admin_form">
                <form id="form2" name="form2" action="<?php echo url_for('@batchuploadmeteorology'); ?>" enctype="multipart/form-data" method="post">
                    <table align="center">
                        <br>
                        <tr>
                            <td><b>File Information:</b></td>
                            <td><input type="file" name="FileInformation" id="FileInformation"></td>
                        </tr>
                        <tr align="center">
                            <td align="center">
                                <input type="button" value="<< Back" id="Back" onclick="window.history.back()">
                                <input type="button" value="Upload" id="uploadsubmit">
                                <input type="hidden" value="" id="forma2" name="forma2"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&ensp;</td>
                        </tr>  

                        <tr>
                            <td colspan="2">
                                <fieldset>            
                                    <legend align= "left">&ensp;<b>Templates</b>&ensp;</legend>
                                    <?php
                                    echo link_to(image_tag('excel-icon.png') . ' Meteorological Fields', "@templatemeteorologicalfields");
                                    ?>
                                </fieldset>
                            </td>
                        </tr>  
                    </table>
                </form>
                <br><br><br><br><br><br><br><br><br><br><br>

            </div>
        </div>
    <?php } ?>
</div>