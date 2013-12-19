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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <script type="text/javascript">
            $(document).ready(function(){ $("#navmenu-h li,#navmenu-v li").hover( function() { $(this).addClass("iehover"); }, function() { $(this).removeClass("iehover"); } ); });
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-22429807-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
    <script>
        $(document).ready(function() {
            $('#uploadsubmit').click(function() {
                var id_crop = $('#id_crop').attr('value');
                var filevariety = $('#filevariety').attr('value');
                if(id_crop == ''){
                    jAlert('error', 'Select Technology','Incomplete Information', null);
                }else if(filevariety == ''){
                    jAlert('error', 'Select Check Variety Template File','Invalid File', null);
                }else{
                    var fragmento = filevariety.split('.');
                    var extension = fragmento[1];
                    if(!((extension == 'XLS') || (extension == 'xls'))){
                        $('#filevariety').attr('value','');
                        $("#filevariety").val('');
                        jAlert('error', 'Permitted file (.XLS)','Invalid File', null);
                    }else{
                        $('#div_loading').show();
                        $('#checkvarietybatch').submit();
                    }
                }
            });
        });
    </script>

    <div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
        <div class="fg-toolbar ui-widget-header ui-corner-all">
            <h1>Batch Check Variety</h1>
        </div>
        <div id="div_loading" class="loading" align="center" style="display:none;">
            <?php echo image_tag('loading.gif'); ?>
            </br>Please Wait...
        </div>
        <div id="sf_admin_content">
            <div class="sf_admin_form">
                <form id="checkvarietybatch" name="checkvarietybatch" action="<?php echo url_for('@checkvarietybatch'); ?>" enctype="multipart/form-data" method="post">
                    <table align="center">
                        </br>
                        <tr>
                            <td colspan="3">
                                <fieldset>
                                    <legend align= "left">&ensp;<b>Attention</b>&ensp;</legend>
                                    <span><?php echo image_tag('attention-icon.png'); ?><?php echo link_to(' Check Variety Template File', "@downloadcheckvarietytemplate"); ?> must have <b>.xls</b> extension and must be smaller than <b>5 MB</b> maximum size</span></br>
                                    <span><?php echo image_tag('attention-icon.png'); ?> Max. <b><?php echo $MaxRecordsFile; ?> Records</b> for Template File</span></br>
                                    <span><?php echo image_tag('attention-icon.png'); ?> Exact number of columns <b>'<?php echo $Cols; ?>'</b> for Template File</span></br>
                                    <span><?php echo image_tag('attention-icon.png'); ?> Don't close the window during the process</span>
                                </fieldset>
                            </td>
                        </tr>
                        <tr align="center"><td colspan="3" align="center">&ensp;</td></tr>
                        <tr>
                            <td colspan="3">
                                <fieldset>
                                    <legend align= "left">&ensp;<b>Download Template</b>&ensp;</legend>
                                    <?php echo link_to(image_tag('excel-icon.png') . ' Check Variety Template File', "@downloadcheckvarietytemplate") . "<br>"; ?>
                                </fieldset>
                            </td>
                        </tr>
                        <tr align="center"><td colspan="3" align="center">&ensp;</td></tr>
                        <tr>
                            <td width="35%"><b>Technology:</b></td>
                            <td width="65%"><?php echo select_from_table("id_crop", "TbCrop", "id_crop", "crpname", null, null); ?></td>
                        </tr>
                        <tr>
                            <td width="35%"><b>Check Variety Template File:</b></td>
                            <td width="65%"><input type="file" name="filevariety" id="filevariety"></td>
                        </tr>
                        <tr align="center"><td colspan="3" align="center">&ensp;</td></tr>
                        <tr align="center">
                            <td colspan="3" align="center">
                                <button type="button" name="Execute" id="uploadsubmit" title="Execute"><?php echo image_tag("execute-icon.png"); ?> <b>Execute</b></button>
                            </td>
                        </tr>
                    </table>
                </form>
                </br>
            </div>
        </div>
    </div>
</html>
