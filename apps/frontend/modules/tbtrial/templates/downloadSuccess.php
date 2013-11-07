<script src="/sfAdminThemejRollerPlugin/js/jquery.min.js" type="text/javascript"></script>
<script src="/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js" type="text/javascript"></script>
<script src="/js/jquery.alerts.js" type="text/javascript"></script>
<link href="/sfAdminThemejRollerPlugin/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/jroller.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.menu.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" rel="stylesheet" type="text/css" />
<link href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" rel="stylesheet" type="text/css" />
<link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
<?php
$id_trial = sfContext::getInstance()->getRequest()->getParameterHolder()->get('id_trial');
$trial = Doctrine::getTable('TbTrial')->findOneByIdTrial($id_trial);
$licence = $trial->getTrllicense();
$trialresultsfile = $trial->getTrltrialresultsfile();
$supplementalinformationfile = $trial->getTrlsupplementalinformationfile();
$weatherduringtrialfile = $trial->getTrlweatherduringtrialfile();
$soiltypeconditionsduringtrialfile = $trial->getTrlsoiltypeconditionsduringtrialfile();
?>
<script type="text/javascript">
    function RegisterDownload(id_trial,type,file){
        $.ajax({
            type: "GET",
            url: "tbtrial/registerdownload/?id_trial="+id_trial+"&type="+type+"&file="+file,
            success: function(){
                if(file == 'MetadataData'){
                    window.location.href = "tbtrial/DownloadMetadataData/?id_trial="+id_trial;
                }else if(file == 'All'){
                    window.location.href = "tbtrial/DownloadAll/?id_trial="+id_trial;
                } else{
                    window.location.href = "/uploads/"+file;
                }
            }
        });
    }

    function verarchivos(){
        div = document.getElementById('divlicence');
        div.style.display = '';
    }
    function cerrar(){
        self.parent.tb_remove();
    }
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Download Metadata - Data - Files</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_form">
            <form id="form1" name="form1" action="" enctype="multipart/form-data" method="post">
                <table align="center">
                    <span id="download">
                        <?php
                        if ($licence != null) {
                            echo "<b>IMPORTANT: Read the license before downloading files.</b>";
                            echo "<br><br>";
                            echo $licence;
                            echo "<br><br>";
                        ?>
                            <input type="button" value="I accept the license" onclick="verarchivos()">
                            <input type="button" value="I do not accept the license" onclick="cerrar()">
                            <br>
                            <div id="divlicence"  style="display: none;">
                            <?php
                            echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Metadata_Data','MetadataData')\"> Results Metadata/Data " . image_tag('Excel-icon.png') . "</a><br>";
                            if ($trialresultsfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Results','{$trialresultsfile}')\"> Trial results file " . image_tag('download-file-icon.png') . "</a><br>";

                            if ($supplementalinformationfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Supplemental_information','{$supplementalinformationfile}')\"> Supplemental information file " . image_tag('download-file-icon.png') . "</a><br>";

                            if ($weatherduringtrialfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Weather','{$weatherduringtrialfile}')\"> Weather during trial file " . image_tag('download-file-icon.png') . "</a><br>";

                            if ($soiltypeconditionsduringtrialfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Soil','{$soiltypeconditionsduringtrialfile}')\"> Soil type conditions during trial file " . image_tag('download-file-icon.png') . "</a><br><br>";

                            echo "<br><a href='#' title='Click to Download All' onclick=\"RegisterDownload('{$id_trial}','All','All')\"> Download All in ZIP Format " . image_tag('Zip-icon.png') . "</a><br>";
                            ?>
                        </div>

                        <?php
                        } else {
                            echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Metadata_Data','MetadataData')\"> Results Metadata/Data " . image_tag('Excel-icon.png') . "</a><br>";
                            if ($trialresultsfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Results','{$trialresultsfile}')\"> Trial results file " . image_tag('download-file-icon.png') . "</a><br>";

                            if ($supplementalinformationfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Supplemental_information','{$supplementalinformationfile}')\"> Supplemental information file " . image_tag('download-file-icon.png') . "</a><br>";

                            if ($weatherduringtrialfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Weather','{$weatherduringtrialfile}')\"> Weather during trial file " . image_tag('download-file-icon.png') . "</a><br>";

                            if ($soiltypeconditionsduringtrialfile != null)
                                echo "<br><a href='#' title='Click to Download' onclick=\"RegisterDownload('{$id_trial}','Soil','{$soiltypeconditionsduringtrialfile}')\"> Soil type conditions during trial file " . image_tag('download-file-icon.png') . "</a><br>";

                            echo "<br><a href='#' title='Click to Download All' onclick=\"RegisterDownload('{$id_trial}','All','All')\"> Download All in ZIP Format " . image_tag('Zip-icon.png') . "</a><br><br>";
                        }
                        ?>
                    </span>
                </table>
            </form>
        </div>
    </div>
</div>