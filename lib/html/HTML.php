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
        <style type="text/css">
            .macro{
                background-color: #FFFFFF;
                border:1px solid #000000;
                margin: auto;
                text-align: center;
                width: 970px;
            }

            .Banner{
                font-family: Verdana;
                font-weight:bold;
                text-align: center;
                font-size:25px;
                width: 970px;
            }

            .Cuerpo {
                border-collapse:collapse;
                border:0px solid #B9E895;
                top: 50%;
                left: 50%;
                width: 90%;
                height: 10%;
                margin: auto;
                text-align: center;
                width: 950px;
            }

            .Forma {
                margin-left: auto;
                margin-right: auto;
                text-align: center;
                width: 80%;
            }

            .TRTDCenter {
                margin-left: auto;
                margin-right: auto;
                text-align: center;
            }

            .Buttons{
                margin-left: auto;
                margin-right: auto;
                text-align: center;
                width: 15%;
            }

            .Pie {
                width: 970px;
                text-align: center;
                margin: 0 auto;
                font-size:11;
            }

        </style>
    </head>
    <body class="body">
        <table width="970"  class="macro" align="center">
            <tr width="970">
                <td width="970">
                    <table class="Banner">
                        <tr><td>&ensp;</td></tr>
                        <tr class="Banner">
                            <td class="Banner">
                                <a style="text-decoration: none;" href="/">
                                    <span>The Global Agricultural Trial Repository and Database</span>
                                </a>
                            </td>
                        </tr>
                        <tr><td>&ensp;</td></tr>
                    </table>

                    <table class="Cuerpo">
                        <?php
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> TrialFileErrorZip
                        if ($Forma == "TrialFileErrorZip")
                            include("TrialFileErrorZip.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> TrialFileErrorZipUncompress
                        if ($Forma == "TrialFileErrorZipUncompress")
                            include("TrialFileErrorZipUncompress.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> TrialFileErrorTemplates
                        if ($Forma == "TrialFileErrorTemplates")
                            include("TrialFileErrorTemplates.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> TrialFileErrorTemplatesCols
                        if ($Forma == "TrialFileErrorTemplatesCols")
                            include("TrialFileErrorTemplatesCols.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> TrialFileErrorTemplatesRecord
                        if ($Forma == "TrialFileErrorTemplatesRecord")
                            include("TrialFileErrorTemplatesRecord.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> TrialBody
                        if ($Forma == "TrialBody")
                            include("TrialBody.php");

                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> FileErrorTemplates
                        if ($Forma == "FileErrorTemplates")
                            include("FileErrorTemplates.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> FileErrorTemplatesCols
                        if ($Forma == "FileErrorTemplatesCols")
                            include("FileErrorTemplatesCols.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> FileErrorTemplatesRecords
                        if ($Forma == "FileErrorTemplatesRecords")
                            include("FileErrorTemplatesRecords.php");
                        //AQUI LLAMAMOS LA FORMA GENERAL -> Body
                        if ($Forma == "Body")
                            include("Body.php");

                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> FileErrorCheckTemplates
                        if ($Forma == "FileErrorCheckTemplates")
                            include("FileErrorCheckTemplates.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> FileErrorCheckTemplatesCols
                        if ($Forma == "FileErrorCheckTemplatesCols")
                            include("FileErrorCheckTemplatesCols.php");
                        //AQUI LLAMAMOS LA FORMA PARA EL ERROR -> FileErrorCheckTemplatesRecords
                        if ($Forma == "FileErrorCheckTemplatesRecords")
                            include("FileErrorCheckTemplatesRecords.php");
                        //AQUI LLAMAMOS LA FORMA GENERAL -> BodyCheck
                        if ($Forma == "BodyCheck")
                            include("BodyCheck.php");
                        ?>
                        <tr class="Pie">
                            <td class="Pie">Copyright © The CGIAR Research Program on Climate Change, Agriculture and Food Security (<a title="CCAFS" target="_new" href="http://ccafs.cgiar.org/">CCAFS</a>) 2013. All rights reserved.</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>

