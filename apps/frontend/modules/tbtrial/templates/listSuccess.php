<?php
//include_once 'funtion.php';
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

$id_trialgroup_Clear_Display = "none";
$id_contactperson_Clear_Display = "none";
$countries_Clear_Display = "none";
$id_trialsite_Clear_Display = "none";
$id_crop_Clear_Display = "none";
$varieties_Clear_Display = "none";
$variablesmeasured_Clear_Display = "none";

if ($id_trialgroup != '')
    $id_trialgroup_Clear_Display = "visible";
if ($id_contactperson != '')
    $id_contactperson_Clear_Display = "visible";
if ($countries != '')
    $countries_Clear_Display = "visible";
if ($id_trialsite != '')
    $id_trialsite_Clear_Display = "visible";
if ($id_crop != '')
    $id_crop_Clear_Display = "visible";
if ($varieties != '')
    $varieties_Clear_Display = "visible";
if ($variablesmeasured != '')
    $variablesmeasured_Clear_Display = "visible";
?>
<style type="text/css">
    #controls {
        margin: 0;
        list-style: none;
    }
    #controls li {
        display: inline;
        margin-left: 10px;
        font-size: 12pt;
    }

    #tbtrial_list{
        width:950px;
        height:700px;
        overflow:auto;
    }
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Search Trials</h1>
        <div id="sf_admin_filters_buttons" class="fg-buttonset fg-buttonset-multi ui-state-default"><br>
            <span class="fg-button ui-state-default fg-button-icon-left ui-corner-all" onclick="muestra_oculta('tbtrial_filter')">Show/Hide Filters</span>
            <?php if (count($listtrial) > 0): ?>
                <span class="fg-button ui-state-default fg-button-icon-left ui-corner-all" onclick="muestra_oculta('tbtrial_list')">Show/Hide List</span>
                <span class="fg-button ui-state-default fg-button-icon-left ui-corner-all" onclick="muestra_oculta('tbtrial_map')">Show/Hide Map</span>
                <a href="/tbtrial/downloadexcel/" class="fg-button ui-state-default fg-button-icon-left ui-corner-all" tabindex="-1"><span></span><img height="13" width="13" border="0" src="/images/excel-icon.png">  Download Excel</img></a>
            <?php endif; ?>
            <?php if ($sf_user->isAuthenticated()) {
                ?>
                <a href="tbtrial/new" class="fg-button ui-state-default fg-button-icon-left ui-corner-all" tabindex="-1"><span class="ui-icon ui-icon-plus"></span>New</a>
            <?php } ?>


        </div>
    </div>
    <?php if ($rows != '') {
        ?>
        <div id="notice" class="sf_admin_flashes ui-widget">
            <div class="notice ui-state-highlight ui-corner-all">
                <span class="ui-icon ui-icon-info floatleft"></span>&ensp;<b>Total records found:</b> <?php echo $rows; ?>
            </div>
        </div>
    <?php } ?>

    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <div id="tbtrial_filter">
        <form id="tbtriallist" name="tbtriallist" action="<?php echo url_for('@list'); ?>" enctype="multipart/form-data" method="post">
            <table align="center">
                <tr>
                    <td nowrap><b>Trial group:</b></td>
                    <td><?php echo select_from_table_trial("id_trialgroup_list", "tb_trialgroup", "id_trialgroup", "trgrname", null, $id_trialgroup); ?>&ensp;<span id="Div_id_trialgroup_list" style="display:none;"><?php echo image_tag('loading4.gif'); ?></span><span id="Div_id_trialgroup_list_Clear" style="display:<?php echo $id_trialgroup_Clear_Display; ?>;"><a href="#" title="Clear value"><?php echo image_tag('clear-icon.png'); ?>Reset</a></span></td>
                </tr>
                <tr>
                    <td nowrap><b>Contact person:</b></td>
                    <td><?php echo select_from_table_trial("id_contactperson_list", "tb_contactperson", "id_contactperson", "(cnprfirstname||' '||cnprlastname)", null, $id_contactperson); ?>&ensp;<span id="Div_id_contactperson_list" style="display:none;"><?php echo image_tag('loading4.gif'); ?></span><span id="Div_id_contactperson_list_Clear" style="display:<?php echo $id_contactperson_Clear_Display; ?>;"><a href="#" title="Clear value"><?php echo image_tag('clear-icon.png'); ?>Reset</a></span></td>
                </tr>
                <tr>
                    <td nowrap><b>Countries:</b></td>
                    <td>
                        <?php echo thickbox_iframe("<textarea id=\"countries\" name=\"countries\" readonly=\"readonly\" cols=\"58\" rows=\"1\" placeholder=\"Click to select Countries\">$countries</textarea>" . image_tag('list-icon.png'), '@countries') ?>
                        <span id="Div_countries_list_Clear" style="display:<?php echo $countries_Clear_Display; ?>;"><a href="#" title="Reset values"><?php echo image_tag('clear-icon.png'); ?>Reset</a></span>
                    </td>
                </tr>
                <tr>
                    <td nowrap><b>Trial site:</b></td>
                    <td><?php echo select_from_table_trial("id_trialsite_list", "tb_trialsite", "id_trialsite", "trstname", null, $id_trialsite); ?>&ensp;<span id="Div_id_trialsite_list" style="display:none;"><?php echo image_tag('loading4.gif'); ?></span><span id="Div_id_trialsite_list_Clear" style="display:<?php echo $id_trialsite_Clear_Display; ?>;"><a href="#" title="Clear value"><?php echo image_tag('clear-icon.png'); ?>Reset</a></span></td>
                </tr>
                <tr>
                    <td nowrap><b>Technology:</b></td>
                    <td><?php echo select_from_table_trial("id_crop_list", "tb_crop", "id_crop", "crpname", null, $id_crop); ?>&ensp;<span id="Div_id_crop_list" style="display:none;"><?php echo image_tag('loading4.gif'); ?></span><span id="Div_id_crop_list_Clear" style="display:<?php echo $id_crop_Clear_Display; ?>;"><a href="#" title="Clear value"><?php echo image_tag('clear-icon.png'); ?>Reset</a></span></td>
                </tr>
                <tr>
                    <td nowrap><b>Varieties/Race:</b></td>
                    <td>
                        <?php echo thickbox_iframe("<textarea id=\"varieties\" name=\"varieties\" readonly=\"readonly\" cols=\"58\" rows=\"1\" placeholder=\"Click to select Varieties/Race\">$varieties</textarea>" . image_tag('list-icon.png'), '@varieties', array('pop' => '1')) ?>
                        <span id="Div_varieties_list_Clear" style="display:<?php echo $varieties_Clear_Display; ?>;"><a href="#" title="Reset values"><?php echo image_tag('clear-icon.png'); ?>Reset</a></span>
                    </td>
                </tr>
                <tr>
                    <td nowrap><b>Variables measured:</b></td>
                    <td>
                        <?php echo thickbox_iframe("<textarea id=\"variablesmeasured\" name=\"variablesmeasured\" readonly=\"readonly\" cols=\"58\" rows=\"1\" placeholder=\"Click to select Variables measured\">$variablesmeasured</textarea>" . image_tag('list-icon.png'), '@variablesmeasured', array('pop' => '1')) ?>
                        <span id="Div_variablesmeasured_list_Clear" style="display:<?php echo $variablesmeasured_Clear_Display; ?>;"><a href="#" title="Reset values"><?php echo image_tag('clear-icon.png'); ?>Reset</a></span>
                    </td>
                </tr>
                <tr class="sf_admin_form_row sf_admin_text">
                    <td nowrap><b>Sow/plant date:</b></td>
                    <td>
                        <input type="text" placeholder="yyyy-mm-dd" name="trlsowdate1" id="trlsowdate1" size="15" value="<?php echo $trlsowdate1; ?>" onkeyUp="ValidaFecha(this);" maxlength="10"> to 
                        <input type="text" placeholder="yyyy-mm-dd" name="trlsowdate2" id="trlsowdate2" size="15" value="<?php echo $trlsowdate2; ?>" onkeyUp="ValidaFecha(this);" maxlength="10"><br>
                    </td>
                </tr>
                <tr class="sf_admin_form_row sf_admin_text">
                    <td nowrap><b>Harvest date:</b></td>
                    <td>
                        <input type="text" placeholder="yyyy-mm-dd"  name="trlharvestdate1" id="trlharvestdate1" size="15" value="<?php echo $trlharvestdate1; ?>" onkeyUp="ValidaFecha(this);" maxlength="10"> to
                        <input type="text" placeholder="yyyy-mm-dd"  name="trlharvestdate2" id="trlharvestdate2" size="15" value="<?php echo $trlharvestdate2; ?>" onkeyUp="ValidaFecha(this);" maxlength="10"><br>
                    </td>
                </tr>
                <tr class="sf_admin_form_row sf_admin_text">
                    <td nowrap><b>Trial name:</b></td>
                    <td><input type="text" name="trlname" id="trlname" size="15" value="<?php echo $trlname; ?>"><br></td>
                </tr>

                <tr>
                    <td nowrap><b>Trial type:</b></td>
                    <td>
                        <?php
                        $Real = "";
                        $Simulated = "";
                        if ($trialtype == "Real")
                            $Real = "selected";
                        else if ($trialtype == "Simulated")
                            $Simulated = "selected";
                        ?>
                        <select name="trialtype" id="trialtype">
                            <option value=""></option>
                            <option value="Real" <?php echo $Real; ?>>Real</option>
                            <option value="Simulated" <?php echo $Simulated; ?>>Simulated</option>
                        </select>
                        <span>&ensp;<?php echo image_tag('flag-red-icon.png'); ?> Red flags will accompany listings of simulated trials</span>
                    </td>
                </tr>
                <tr>
                    <td nowrap><b>Pagination:</b></td>
                    <td>
                        <?php
                        $Y_pagination = "";
                        $N_pagination = "";
                        if (($pagination == "YES") || ($pagination == ""))
                            $Y_pagination = "selected";
                        else
                            $N_pagination = "selected";
                        ?>
                        <select name="pagination" id="pagination">
                            <option value="YES" <?php echo $Y_pagination; ?>>YES</option>
                            <option value="NO" <?php echo $N_pagination; ?>>NO</option>
                        </select>      
                    </td>
                </tr>
                <tr align="right">
                    <td align="right" colspan="6">&ensp;&ensp;</td>
                </tr>  
                <tr align="center">
                    <td align="center" colspan="6">
                        <input type="hidden" value="" name="VariablesMeasureds" id="VariablesMeasureds">
                        <input type="hidden" size="2" maxlength="7" value="" name="paginar" id="paginar">
                        <button type="button" name="tbtrialfilter" id="tbtrialfilter" title="Search "><?php echo image_tag("search-brown-icon.png"); ?> <b>Search </b></button>
                        <button type="button" name="tbtrialclear" id="tbtrialclear" title="Reset All "><?php echo image_tag("clear-icon.png"); ?> <b>Reset All</b></button>
                    </td>
                </tr>
            </table>

        </form>
    </div>

    <?php if (count($listtrial) > 0): ?>
        <div id="tbtrial_list">
            <div class="sf_admin_list_2 ui-grid-table ui-widget ui-corner-all ui-helper-reset ui-helper-clearfix">
                <table width="930"><br>

                    <thead class="ui-widget-header" style="display: table-header-group;">
                        <tr>
                            <th width="5%" class="sf_admin_text ui-state-default ui-th-column" widht>Id</th>
                            <th width="10%" class="sf_admin_text ui-state-default ui-th-column">Contact person</th>
                            <th width="13%" class="sf_admin_text ui-state-default ui-th-column">Trial group</th>
                            <th width="10%" class="sf_admin_text ui-state-default ui-th-column">Country</th>
                            <th width="10%" class="sf_admin_text ui-state-default ui-th-column">Trial site</th>
                            <th width="10%" class="sf_admin_text ui-state-default ui-th-column">Technology</th>
                            <th width="20%" class="sf_admin_text ui-state-default ui-th-column">Name</th>
                            <th width="18%" class="sf_admin_text ui-state-default ui-th-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $datosJSON = "";
                        foreach ($listtrial AS $trial) {
                            $datosJSON .= "{'id_trial':{$trial['id_trial']}, 'contactperson':'{$trial['contactperson']}', 'trialgroup':'{$trial['trialgroup']}', 'trialsite':'{$trial['trialsite']}', 'trlname':'{$trial['trlname']}', 'lat':{$trial['lat']}, 'long':{$trial['long']}},";
                            $datosmap[] = array('id_trial' => $trial['id_trial'], 'id_contactperson' => $trial['id_contactperson'], 'id_trialsite' => $trial['id_trialsite'], 'trlname' => $trial['trlname'], 'trltrialtype' => $trial['trltrialtype']);
                            $Query = Doctrine_Query::create()
                                    ->select("TC.id_trial as trial")
                                    ->from("TbTrialcomments TC")
                                    ->where("TC.id_trial = {$trial['id_trial']}");
                            $Resultado = $Query->execute();
                            $commentsxtrial = count($Resultado);
                            if ($trcolor == '' || $trcolor == '#F7FEF0')
                                $trcolor = '#C4E492';
                            else
                                $trcolor = '#F7FEF0';
                            ?>
                            <tr bgcolor="<?php echo $trcolor; ?>" border="1" title="Trial Type: <?php echo $trial['trltrialtype']; ?>">
                                <td class="sf_admin_text"><a href="/tbtrial/<?php echo $trial['id_trial']; ?>/edit"><?php
                                        echo $trial['id_trial'];
                                        if ($trial['trltrialtype'] == 'Simulated') {
                                            echo " " . image_tag("flag-red-icon.png");
                                        }
                                        ?></a></td>
                                <td class="sf_admin_text"><?php echo $trial['contactperson']; ?></td>
                                <td class="sf_admin_text"><?php echo $trial['trialgroup']; ?></td>
                                <td class="sf_admin_text"><?php echo $trial['country']; ?></td>
                                <td class="sf_admin_text"><?php echo $trial['trialsite']; ?></td>
                                <td class="sf_admin_text"><?php echo $trial['crop']; ?></td>
                                <td class="sf_admin_text"><?php echo $trial['trlname']; ?></td>
                                <td style="white-space: nowrap;">
                                    <ul class="sf_admin_td_actions fg-buttonset fg-buttonset-single">
                                        <li class="sf_admin_action_edit"><a href="/tbtrial/<?php echo $trial['id_trial']; ?>/edit" class="fg-button-mini fg-button ui-state-default fg-button-icon-left"><span class="ui-icon ui-icon-pencil"></span>Edit</a></li>
                                        <li class="sf_admin_action_show"><a href="/tbtrial/<?php echo $trial['id_trial']; ?>" class="fg-button-mini fg-button ui-state-default fg-button-icon-left"><span class="ui-icon ui-icon-document"></span>Show</a></li>
                                        <li class="sf_admin_action_comments"><a href="/tbtrial/<?php echo $trial['id_trial']; ?>/List_Comments" class="fg-button-mini fg-button ui-state-default fg-button-icon-left">Comments (<?php echo $commentsxtrial; ?>)</a>      </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php
                        }
                        $TrialJSON = "";
                        $TrialJSON = "[" . substr($datosJSON, 0, (strlen($datosJSON) - 1)) . "]";
                        ?>
                    </tbody>
                </table>
            </div>
            <?php //echo $TrialJSON;    ?>
            <?php if (($paginas > 0) && ($pagination == "YES")): ?>
                <div>
                    <table align="center">
                        <tr align="center">
                            <td nowrap align="center"><br>
                                <span title="First" onclick="paginar(1);"><?php echo image_tag('ui-icons-first.png'); ?></span>
                                <span title="Previous" onclick="paginar(<?php echo $paginaprev; ?>);"><?php echo image_tag('ui-icons-prev.png'); ?></span>
                                Page <input type="text" title="Go to" size="2" maxlength="7" value="<?php echo $paginar; ?>" name="page" id="page" onkeypress="validarpagina(event, this.value)"> of <?php echo $paginas; ?>
                                <span title="Next" onclick="paginar(<?php echo $paginanext; ?>);"><?php echo image_tag('ui-icons-next.png'); ?></span>
                                <span title="Last" onclick="paginar(<?php echo $paginas; ?>);"><?php echo image_tag('ui-icons-end.png'); ?></span>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!--  AQUI VA EL CODIGO PARA EL MAPA-->
        <?php
        $a = 0;
        foreach ($datosmap AS $dato) {
            $flag = "";
            $idtrial = $dato['id_trial'];
            $idcontactperson = $dato['id_contactperson'];
            $idtrialsite = $dato['id_trialsite'];
            $trlname = $dato['trlname'];
            if ($dato['trltrialtype'] == 'Simulated') {
                $flag = image_tag("flag-red-icon.png");
            }
            $Tbcontactperson = Doctrine::getTable('Tbcontactperson')->findOneByIdContactperson($idcontactperson);
            $Tbtrialsite = Doctrine::getTable('Tbtrialsite')->findOneByIdTrialsite($idtrialsite);
            $Desc_punto = "<b>{$Tbcontactperson->getCnprfirstname()} {$Tbcontactperson->getCnprlastname()}</b> <br>";
            $Desc_punto .= "{$Tbtrialsite->getTrstname()} <br>";
            $Desc_punto .= "$trlname $flag<br>";
            $Desc_punto .= "<A HREF=\"#\" onClick=\"wopen({$idtrial})\">Go to Trial</A>";
            if (($Tbtrialsite->getTrstlatitudedecimal() != '') && ($Tbtrialsite->getTrstlongitudedecimal() != '')) {
                $puntos['info'][$a] = array('title' => $trlname, 'context' => $Desc_punto, 'lat' => $Tbtrialsite->getTrstlatitudedecimal(), 'log' => $Tbtrialsite->getTrstlongitudedecimal());
                $a++;
            }
        }

        $maps = json_encode($puntos);
        ?>
        <div id="tbtrial_map">
            <html>
                <head>
                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                    <script type="text/javascript" src="/js/GoogleMapsV3/GoogleMapsV3.js"></script>
                    <script type="text/javascript" src="/js/GoogleMapsV3/GoogleMapsV3-MarkerClusterer.js"></script>
                    <script type="text/javascript" src="/js/GoogleMapsV3/GoogleMapsV3-MarkerManager.js"></script>
                    <script type="text/javascript" >var markers = <?php echo $maps; ?></script>
                </head>
                <body>
                    <br>
                    <div class="fg-toolbar ui-widget-header ui-corner-all">
                        <ul id="controls">
                            <li>
                                <label for="mgr-cb">View Map</label>
                            </li>
                            <li>
                                <label for="mgr-cb">Marker Manager</label>
                                <input type="checkbox" id="mgr-cb" name="mgr-cb" />
                            </li>
                            <li>
                                <label for="mc-cb">Marker Cluster</label>
                                <input type="checkbox" id="mc-cb" name="mc-cb" />
                            </li>
                        </ul>
                    </div>
                    <div id="map" style="width:940px; height:600px"></div>
                </body>
            </html>
        </div>
    <?php endif; ?>
</div>