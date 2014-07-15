<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
//HERLIN R. ESPINOSA G.
//herlin25@gmail.com
require_once '../lib/funtions/funtion.php';
$pop = sfContext::getInstance()->getRequest()->getParameterHolder()->get('pop');
$module = sfContext::getInstance()->getRequest()->getParameterHolder()->get('module');
$action = sfContext::getInstance()->getRequest()->getParameterHolder()->get('action');
include_http_metas();
include_metas();
include_title();
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
include_stylesheets();
include_javascripts();
if ($sf_user->isAuthenticated()) {
    $id_user = sfContext::getInstance()->getUser()->getGuardUser()->getId();
    $Username = sfContext::getInstance()->getUser()->getUsername();
    $CompleteName = sfContext::getInstance()->getUser()->getAttribute('CompleteName');
}
?>
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
    <body class="body">
        <table width="970"  class="macro" align="center">
            <tr width="970">
                <td width="970">
                    <table align="center" class="table_banner">

                        <tr>
                            <td class="imagen_banner">
                                <a style="text-decoration: none;" href="/">
                                    <?php echo image_tag('ccafs.png', array('size' => '293x90', 'border' => '0')); ?> </br>
                                    <span class="texto2"><font size="4">The Global Agricultural Trial Repository and Database</font></span>
                                </a>
                            </td>
                            <td class="texto_banner">
                                <!--<form method="get" id="searchform" action="/search/">
                                    <table align="right">
                                        <tr>
                                            <td>
                                                <input type="text" name="q" id="searchbar" class="search" value="" placeholder="Search..." title="Search"></input>
                                                <input type="submit" id="searchsubmit" value="Search"></input>
                                            </td>
                                        </tr>
                                    </table>
                                </form>-->
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" valign="middle">
                                <div id='cssmenu1'>
                                    <ul>
                                        <li><a href="/">Home</a></li>
                                        <?php if (!($sf_user->isAuthenticated())) {
                                        ?>
                                            <li><a href="/trialsites">Search Trials</a></li>
                                        <?php } ?>
                                        <li><a href="/aboutagtrials">About Us</a></li>
                                        <li><a href="/contactagtrials">Contact Us</a></li>
                                        <li><a href="/sitemap">Site Map</a></li>

                                        <?php if (!($sf_user->isAuthenticated())) {
                                        ?>
                                            <li><a href="/login">Sign In</a></li>
                                            <li><a href="/register">Sign Up</a></li>
                                        <?php } else {
                                        ?>
                                            <li class='has-sub'><a href="#"><?php echo $CompleteName . image_tag('bullet-gear-icon.png', array('size' => '16x16', 'border' => '0')); ?></a>
                                                <ul>
                                                    <li><a href="/sfGuardUser/user">Profile</a></li>
                                                    <li><a href="/sfGuardUser/changepassword">Change password</a></li>
                                                    <li><a href="http://gisweb.ciat.cgiar.org/trialsitesblog/wp-login.php" target="_blank">Login Blog</a></li>
                                                    <li><a href="/api">API</a></li>
                                                    <li><a href="/logout" onclick="return confirm('*** CLOSE SESSION *** \n\n Are you sure?');" >Log Out</a></li>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table align="center" class="table_banner">
                        <tr>
                            <td>

                                <?php if ($sf_user->isAuthenticated()) {
                                ?>
                                            <div id='cssmenu'>
                                                <ul>
                                                    <li><a href='/list'><span>Search Trials</span></a></li>
                                                    <li><a href='/tbtrial/new'><span>New Trial</span></a></li>
                                                    <li class='has-sub'><a href='#'><span>Processes</span></a>
                                                        <ul>
                                                            <li><a href="/batchupload">Upload Trials</a></li>
                                                            <li><a href="/batchuploadtrialgroup">Upload Trial Groups</a></li>
                                                            <li><a href="/batchuploadtrialsite">Upload Trial Sites</a></li>
                                                            <li><a href="/batchuploadvariety">Upload Varieties/Race</a></li>
                                                            <li><a href="/batchuploadvariablesmeasured">Upload Variables Measured</a></li>
                                                            <li><a href="/batchuploadlocation">Upload Locations</a></li>
                                                            <li><a href="/checktrialsite">Check Trial Site</a></li>
                                                            <li><a href="/checktrialsitebatch">Check Trial Site Batch</a></li>
                                                            <li><a href="/checkvariablesmeasured">Check Variables Measured</a></li>
                                                            <li><a href="/checkvariablesmeasuredbatch">Check Variables Measured Batch</a></li>
                                                            <li><a href="/checkvariety">Check Variety/Race</a></li>
                                                            <li><a href="/checkvarietybatch">Check Variety/Race Batch</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class='has-sub'><a href='#'><span>Others</span></a>
                                                        <ul>
                                                            <li><a href='/tbbibliography'><span>Bibliography</span></a></li>
                                                            <li><a href="/tbcontactperson">Contact Person</a></li>
                                                            <li><a href="/tbcontactpersontype">Contact Person Type</a></li>
                                                            <li><a href="/tbfieldnamenumber">Field Name Number</a></li>
                                                            <li><a href="/tbinstitution">Institution</a></li>
                                                            <li><a href="/tblocation">Location Site</a></li>
                                                            <li><a href="/tbobjective">Objective</a></li>
                                                            <li><a href="/tborigin">Origin</a></li>
                                                            <li><a href="/tbprimarydiscipline">Primary Discipline</a></li>
                                                            <li><a href="/tbcrop">Technology</a></li>
                                                            <li><a href="/tbtraitclass">Trait Class</a></li>
                                                            <li><a href="/tbtrialenvironmenttype">Trial Environment Type</a></li>
                                                            <li><a href='/tbtrialgroup'><span>Trial Group</span></a></li>
                                                            <li><a href="/tbtrialgrouptype">Trial Group Type</a></li>
                                                            <li><a href="/tbtrialsite">Trial Site</a></li>
                                                            <li><a href="/tbvariablesmeasured">Variables Measured</a></li>
                                                            <li><a href="/tbvariety">Variety/Race</a></li>
                                                            <li><a href="/tbweathervariablesmeasured">Weather Variables Measured</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class='has-sub'><a href='#'><span>Admin</span></a>
                                                        <ul>
                                                <?php
                                                if (CheckUserPermission($id_user, 1)) {
                                                ?>
                                                    <li><a href="/sfGuardUser">Users</a></li>
                                                    <li><a href="/administration">Administration</a></li>
                                                    <li><a href="/fieldmodulehelp">Field Module Help</a></li>
                                                <?php } ?>
                                                <li><a href="/communications">Communications</a></li>

                                            </ul>
                                        </li>
                                        <li><a href='/help'><span>Help</span></a></li>

                                    </ul>
                                </div>
                                <?php } ?>
                                        </td>
                                    </tr>
                                    <tr align="center">
                                        <td>
                                <?php echo $sf_content; ?>
                            </td>
                        </tr>
                        <tr align="center" class="pie">
                            <td align="center" class="pie">Copyright © The CGIAR Research Program on Climate Change, Agriculture and Food Security (<a title="CCAFS" target="_new" href="http://ccafs.cgiar.org/">CCAFS</a>). All rights reserved.</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>