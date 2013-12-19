<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT" />
<meta name="description" content="The Global Agricultural Trial Repository" />
<meta name="keywords" content="Trials, Sites, Bibliography, CGIAR, CCAFS, CIAT" />
<meta name="language" content="en" />
<meta name="robots" content="index, follow" />
<title>The Global Agricultural Trial Repository - CGIAR - CCAFS - CIAT</title>
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/jquery.alerts.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/jquery/custom-theme/jquery-ui.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/jroller.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/fg.menu.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/fg.buttons.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/sfAdminThemejRollerPlugin/css/ui.selectmenu.css" />
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/jquery.min.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="/js/jquery.alerts.js"></script>
<script type="text/javascript" src="/js/funtions.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/fg.menu.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/jroller.js"></script>
<script type="text/javascript" src="/sfAdminThemejRollerPlugin/js/ui.selectmenu.js"></script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        $('#ButtonBarley').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Barley');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonBean').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Bean');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonCassava').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Cassava');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonChickpea').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Chickpea');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonCowpea').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Cowpea');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonGroundnut').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Groundnut');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonMaize').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Maize');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonPearlMillet').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','PearlMillet');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonPigeonpea').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Pigeonpea');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonRice').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Rice');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonSorghum').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Sorghum');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonWheat').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Wheat');
            $('#Form_CropOntology').submit();
        });
        $('#ButtonYam').click (function() {
			$('#div_loading').show();
			$('#CropName').attr('value','Yam');
            $('#Form_CropOntology').submit();
        });
	});
</script>

	
	<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
		<div class="fg-toolbar ui-widget-header ui-corner-all">
			<h1>Crop Ontology</h1>
		</div>
		<div id="div_loading" class="loading" align="center" style="display:none;">
            <?php echo image_tag('loading.gif'); ?>
            </br>Please wait, connecting with Crop Ontology Curation Tool...
        </div>
		<?php if (isset($notice)) { ?>
        <div id="notice" class="sf_admin_flashes ui-widget">
            <div class="notice ui-state-highlight ui-corner-all">
                <span class="ui-icon ui-icon-info floatleft"></span>&ensp;<?php echo $notice; ?>
            </div>
        </div>
		<?php } ?>
        <div id="sf_admin_content">
            <div class="sf_admin_form">
                <form id="Form_CropOntology" name="Form_CropOntology" action="" enctype="multipart/form-data" method="post">
                    <table align="center">
                        <tr>
                            <td>
								</br><a href="http://www.cropontology.org/" target="_new" title="Crop Ontology Curation Tool"><?php echo image_tag('page-url-icon.png'); ?><b>Crop Ontology Curation Tool</b></a>
							</td>
						</tr>
						<tr><td>&ensp;</td></tr>
						<tr>
                            <td>
                                <fieldset>
                                    <legend align= "left">&ensp;<b>Update Variable Measured to AgTrial with Crop Ontology Curation Tool</b>&ensp;</legend>
                                    <span><button type="button" name="ButtonBarley" id="ButtonBarley" title="Barley"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Barley</b></button></span>
									<span><button type="button" name="ButtonBean" id="ButtonBean" title="Bean"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Bean</b></button></span>
									<span><button type="button" name="ButtonCassava" id="ButtonCassava" title="Cassava"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Cassava</b></button></span>
									<span><button type="button" name="ButtonChickpea" id="ButtonChickpea" title="Chickpea"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Chickpea</b></button></span>
									<span><button type="button" name="ButtonCowpea" id="ButtonCowpea" title="Cowpea"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Cowpea</b></button></span>
									<span><button type="button" name="ButtonGroundnut" id="ButtonGroundnut" title="Groundnut"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Groundnut</b></button></span>
									<span><button type="button" name="ButtonMaize" id="ButtonMaize" title="Maize"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Maize</b></button></span>
									<span><button type="button" name="ButtonPearlMillet" id="ButtonPearlMillet" title="Pearl Millet"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Pearl Millet</b></button></span>
									<span><button type="button" name="ButtonPigeonpea" id="ButtonPigeonpea" title="Pigeonpea"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Pigeonpea</b></button></span>
									<span><button type="button" name="ButtonRice" id="ButtonRice" title="Rice"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Rice</b></button></span>
									<span><button type="button" name="ButtonSorghum" id="ButtonSorghum" title="Sorghum"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Sorghum</b></button></span>
									<span><button type="button" name="ButtonWheat" id="ButtonWheat" title="Wheat"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Wheat</b></button></span>
									<span><button type="button" name="ButtonYam" id="ButtonYam" title="Yam"><?php echo image_tag("execute-icon.png",array('size' => '14x14')); ?> <b>Yam</b></button></span>
                                </fieldset>
								<input type="hidden" id="CropName" name="CropName">
                            </td>
                        </tr>
                    </table>
                </form>
                </br>
            </div>
        </div>
		<div id="sf_admin_content">
			<div class="sf_admin_form">
				<table align="center">
					<tr align="center">
						<td align="center">
							<?php
								if(count($out) > 0){
									foreach ($out AS $valor) {
										if(strstr($valor, "***"))
											$valor = "<b>".$valor."</b>";
											
										$valor = str_replace("Records Analyzed:", "<b>Records Analyzed:</b>", $valor);
										$valor = str_replace("Records Updated:", "<b>Records Updated:</b>", $valor);
										$valor = str_replace("Records New:", "<b>Records New:</b>", $valor);
										echo "$valor <br>";
									}
								}
							?>
							<br>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</html>