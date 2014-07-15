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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico" />
        <script type="text/javascript">
            $(document).ready(function() {
                $("#navmenu-h li,#navmenu-v li").hover(function() {
                    $(this).addClass("iehover");
                }, function() {
                    $(this).removeClass("iehover");
                });
            });
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-22429807-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
    <div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
        <div class="fg-toolbar ui-widget-header ui-corner-all">
            <h1>Licence</h1>
        </div>
        <div id="sf_admin_content">
            <div class="sf_admin_form">
                <br>
                    <span id="licence">
                        <b>IMPORTANT: Read this before you build your license </b>
                </br></br>
                We now ask you to designate the intellectual property rights of the agricultural evaluation data you are registering through this application. Click on the
                <a href="http://creativecommons.org/choose/" alt="Commons License Generator">creative commons logo</a>
                below and you will be taken to a license generator developed by Creative Commons. It will ask you a series of questions whose responses determine the data sharing and use policy for your data set. At this point, the application will develop lines of computer code designating the intellectual property rights. Copy these lines of code from the pop-up window back into the main window of the application.
                </span>
                </br></br></br></br></br></br></br></br></br></br></br></br></br></br>
                <div align="center">
                    <a href="#" onclick="
                            javascript:openWindow('http://creativecommons.org/choose/');
                            self.parent.tb_remove();
                            self.parent.getElementById('tb_trial_trllicense').focus();" alt="Commons License Generator"><?php echo image_tag('creative_commons.jpeg'); ?></a>
                </div>

            </div>
        </div>
    </div>
</html>