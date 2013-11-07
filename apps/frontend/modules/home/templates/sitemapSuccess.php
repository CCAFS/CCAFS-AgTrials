<?php
require_once '../lib/funtions/funtion.php';
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
<style type="text/css">
    p {
        font-size: 14px;
    }
    a {
        font-size: 13px;
    }
    a:active {
        text-decoration: none;
        color: #48732A;
    }

    a:link {
        text-decoration: none;
        color: #48732A;
    }

    a:visited {
        text-decoration: none;
        color: #48732A;
    }

    a:hover {
        text-decoration: underline;
        color: #659831;
    }
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Site Map</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <br>
    <p>The site map is an easy way to see all the sections of which is made a web site.</p>
    <br>
    <div>
        <div><p>Unauthenticated</p></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/" rel="bookmark">Home</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/list" rel="bookmark">Search Trials</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/aboutagtrials" rel="bookmark">About Us</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/contactagtrials" rel="bookmark">Contact Us</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/sitemap" rel="bookmark">Site Map</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/login" rel="bookmark">Sign In</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/register" rel="bookmark">Sign Up</a></div>
        <br>
        <div><p>Authenticated</p></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/" rel="bookmark">Home</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/aboutagtrials" rel="bookmark">About Us</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/contactagtrials" rel="bookmark">Contact Us</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/sitemap" rel="bookmark">Site Map</a></div>
        <div><img width="12" height="12" border="0" src="/images/Arrow-icon.png"> <a href="#" rel="bookmark">Name User</a><img width="16" height="16" border="0" src="/images/bullet-gear-icon.png"></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/sfGuardUser/user" rel="bookmark">Profile</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/sfGuardUser/changepassword" rel="bookmark">Change password</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="http://gisweb.ciat.cgiar.org/trialsitesblog/wp-login.php">Login Blog</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/api" rel="bookmark">API</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a onclick="return confirm('*** CLOSE SESSION *** \n\n Are you sure?');" href="/logout">Log Out</a></div>
        <br>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/list" rel="bookmark">Search Trials</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbtrial/new" rel="bookmark">New Trial</a></div>
        <div><img width="12" height="12" border="0" src="/images/Arrow-icon.png"> <a href="#" rel="bookmark">Processes</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/batchupload" rel="bookmark">Upload Trials</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/batchuploadtrialgroup" rel="bookmark">Upload Trial Groups</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/batchuploadtrialsite" rel="bookmark">Upload Trial Sites</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/batchuploadvariety" rel="bookmark">Upload Varieties/Race</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/batchuploadvariablesmeasured" rel="bookmark">Upload Variables Measured</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/batchuploadlocation" rel="bookmark">Upload Locations</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/checktrialsite" rel="bookmark">Check Trial Site</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/checktrialsitebatch" rel="bookmark">Check Trial Site Batch</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/checkvariablesmeasured" rel="bookmark">Check Variables Measured</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/checkvariablesmeasuredbatch" rel="bookmark">Check Variables Measured Batch</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/checkvariety" rel="bookmark">Check Variety/Race</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/checkvarietybatch" rel="bookmark">Check Variety/Race Batch</a></div>
        <div><img width="12" height="12" border="0" src="/images/Arrow-icon.png"> <a href="#" rel="bookmark">Others</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbbibliography" rel="bookmark">Bibliography</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbcontactperson" rel="bookmark">Contact Person</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbcontactpersontype" rel="bookmark">Contact Person Type</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbfieldnamenumber" rel="bookmark">Field Name Number</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbinstitution" rel="bookmark">Institution</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tblocation" rel="bookmark">Location Site</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbobjective" rel="bookmark">Objective</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tborigin" rel="bookmark">Origin</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbprimarydiscipline" rel="bookmark">Primary Discipline</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbcrop" rel="bookmark">Technology</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbtraitclass" rel="bookmark">Trait Class</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbtrialenvironmenttype" rel="bookmark">Trial Environment Type</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbtrialgroup" rel="bookmark">Trial Group</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbtrialgrouptype" rel="bookmark">Trial Group Type</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbtrialsite" rel="bookmark">Trial Site</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbvariablesmeasured" rel="bookmark">Variables Measured</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbvariety" rel="bookmark">Variety/Race</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/tbweathervariablesmeasured" rel="bookmark">Weather Variables Measured</a></div>
        <div><img width="12" height="12" border="0" src="/images/Arrow-icon.png"> <a href="#" rel="bookmark">Admin</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/sfGuardUser" rel="bookmark">Users</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/administration" rel="bookmark">Administration</a></div>
        <div>&ensp;&ensp;&ensp;<img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/communications" rel="bookmark">Communications</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/" rel="bookmark">Help</a></div>
        <br>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="http://gismap.ciat.cgiar.org/AgTrials/" rel="bookmark">Maps</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="/AgTrialsBlogRSS" rel="bookmark">Follow AgTrials Blog via RSS</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="/geoRSS" rel="bookmark">Follow AgTrials via GeoRSS</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a href="/viewvideo" rel="bookmark">Videos</a></div>
        <br>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="http://www.facebook.com/profile.php?id=100003323023382" rel="bookmark">Facebook</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="https://twitter.com/AgTrials" rel="bookmark">Twitter</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="http://www.youtube.com/user/AgTrials" rel="bookmark">TouTube</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="http://gisweb.ciat.cgiar.org/trialsitesblog/" rel="bookmark">Blog</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="http://www.agtrials.org/forum" rel="bookmark">Forum</a></div>
        <div><img width="12" height="12" border="0" src="/images/bullet-black-icon.png"> <a target="_blank" href="mailto:noreplyagtrials@gmail.com" rel="bookmark">Send E-mail</a></div>
        <br>
    </div>










</div>
