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
$sfGuardUser = Doctrine::getTable('sfGuardUser')->findOneBy("Username", sfContext::getInstance()->getUser()->getUsername());
$sfGuardUserInformation = Doctrine::getTable('sfGuardUserInformation')->findOneByUserId($sfGuardUser->id);
$key = $sfGuardUserInformation->key;
?>
<style type="text/css">
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
        text-decoration: none;
        color: #659831;
    }

    .Info{
        font-size: 13px;
    }
    .InfoApi{
        background:#FFFFCE;
        width: 940px;
        overflow:scroll;
        white-space:nowrap;
    }


</style>
<script language="JavaScript">
    function muestra_oculta(id) {
        if (document.getElementById) { //se obtiene el id
            var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
            el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
        }
    }
</script>
<div class="sf_admin_edit ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>API</h1>
    </div>
    <br>
    <div class="Info">
        <fieldset>
            <legend align= "left">&ensp;<b>Information</b>&ensp;</legend>
            <div><strong>Key:</strong> Generated key for each user <span><a target="_blank" href="/sfGuardUser/user">View your Key</a></span></div>
            <div><strong>Options:</strong> You can use one or more options separated by '&'</div>
            <div><strong>Values:</strong> You can use one or more values separated by ','</div>
            <div><strong>Value:</strong> You can use only one value numeric</div>
            <div><strong>Returns:</strong> JSON Format</div>
        </fieldset>
        <br>
        <b>Retrieve Trials</b> <a href="#" onclick="muestra_oculta('ApiTrials')" title="">View Info</a>
        <div id="ApiTrials" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apitrials?key=<?php echo $key; ?>&{Options}</code></div>
            <div><strong>Options:</strong> <code>trialgroup=values&contactperson=values&country=values&trialsite=values&technology=values&latitude=value1|value2&longitude=value1|value2&varieties=values&variablesmeasureds=values&latest=value &ensp;</code> </div>
            <div><strong>Return:</strong> <code>id,trialgroup,contactperson,country,trialsite,latitude,longitude,crop,trialname,varieties,variablesmeasured,sowdate,harvestdate,trialtype,irrigation,url</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apitrials?key=<?php echo $key; ?>&trialgroup=71,86&country=47">http://www.agtrials.org/api/apitrials?key=<?php echo $key; ?>&trialgroup=71,86&country=47</a></code> </div>
            <br>
        </div>
        <br>
        <b>Retrieve Trial Groups</b> <a href="#" onclick="muestra_oculta('ApiTrialGroup')" title="">View Info</a>
        <div id="ApiTrialGroup" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apitrialgroups?key=<?php echo $key; ?></code></div>
            <div><strong>Return:</strong> <code>id,institution,contactpersons,objective,primarydiscipline,trialgroup,startyear,endyear,trialgrouptype</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apitrialgroups?key=<?php echo $key; ?>">http://www.agtrials.org/api/apitrialgroups?key=<?php echo $key; ?></a></code> </div>
            <br>
        </div>
        <br>
        <b>Retrieve Contact Person</b> <a href="#" onclick="muestra_oculta('ApiContactPerson')" title="">View Info</a>
        <div id="ApiContactPerson" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apicontactperson?key=<?php echo $key; ?></code></div>
            <div><strong>Return:</strong> <code>id,institution,country,contactpersontype,firstname,lastname,address,phone,email</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apicontactperson?key=<?php echo $key; ?>">http://www.agtrials.org/api/apicontactperson?key=<?php echo $key; ?></a></code> </div>
            <br>
        </div>
        <br>
        <b>Retrieve Country</b> <a href="#" onclick="muestra_oculta('ApiCountry')" title="">View Info</a>
        <div id="ApiCountry" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apicountry?key=<?php echo $key; ?></code></div>
            <div><strong>Return:</strong> <code>id,countryname,iso,iso3</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apicountry?key=<?php echo $key; ?>">http://www.agtrials.org/api/apicountry?key=<?php echo $key; ?></a></code> </div>
            <br>
        </div>
        <br>
        <b>Retrieve Trial Sites</b> <a href="#" onclick="muestra_oculta('ApiTrialSites')" title="">View Info</a>
        <div id="ApiTrialSites" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apitrialsites?key=<?php echo $key; ?></code></div>
            <div><strong>Return:</strong> <code>id,contactpersons,institution,country,location,trialsitename,latitude,longitude,altitude,ph,soil,taxonomyfao,status,statereason</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apitrialsites?key=<?php echo $key; ?>">http://www.agtrials.org/api/apitrialsites?key=<?php echo $key; ?></a></code> </div>
            <br>
        </div>
        <br>
        <b>Retrieve Technology (Crops)</b> <a href="#" onclick="muestra_oculta('ApiTechnology')" title="">View Info</a>
        <div id="ApiTechnology" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apitechnology?key=<?php echo $key; ?></code></div>
            <div><strong>Return:</strong> <code>id,technologyname,scientificname</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apitechnology?key=<?php echo $key; ?>">http://www.agtrials.org/api/apitechnology?key=<?php echo $key; ?></a></code> </div>
            <br>
        </div>
        <br>
        <b>Retrieve Variety</b> <a href="#" onclick="muestra_oculta('ApiVariety')" title="">View Info</a>
        <div id="ApiVariety" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apivariety?key=<?php echo $key; ?>&technology=values</code></div>
            <div><strong>Return:</strong> <code>id,technology,origin,varietyname,synonymous,description</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apivariety?key=<?php echo $key; ?>&technology=10">http://www.agtrials.org/api/apivariety?key=<?php echo $key; ?>&technology=10</a></code> </div>
            <br>
        </div>
        <br>
        <b>Retrieve Variables Measured</b> <a href="#" onclick="muestra_oculta('ApiVariablesMeasured')" title="">View Info</a>
        <div id="ApiVariablesMeasured" class="InfoApi" style="display:none;">
            <br>
            <div><strong>URL:</strong> <code>http://www.agtrials.org/api/apivariablesmeasured?key=<?php echo $key; ?>&technology=values</code></div>
            <div><strong>Return:</strong> <code>id,technology,traitclass,variablesmeasuredname,shortname,definition,unit</code> </div>
            <div><strong>Example:</strong> <code><a target="_blank" href="http://www.agtrials.org/api/apivariablesmeasured?key=<?php echo $key; ?>&technology=1">http://www.agtrials.org/api/apivariablesmeasured?key=<?php echo $key; ?>&technology=1</a></code> </div>
            <br>
        </div>
        <br><br>
    </div>
</div>
