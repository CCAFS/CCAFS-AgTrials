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
$Ttechnology = 0;
$Tcountry = 0;
$Tinstitution = 0;
$Tgroup = 0;
$Tsite = 0;
?>
<style type="text/css">
    a:active {
        text-decoration: none;
        color: #48732A;
        font-size: 14px;
    }

    a:link {
        text-decoration: none;
        color: #48732A;
        font-size: 14px;
    }

    a:visited {
        text-decoration: none;
        color: #48732A;
        font-size: 14px;
    }

    a:hover {
        text-decoration: none;
        color: #659831;
        font-size: 14px;
    }

    .divdetail {
        background-color:#FFFFFF;
        border:1px solid;
        border-color: #FFD90F;
        display: none;
    }
    .detail {
        border:1px solid;
        border-color: #FFD90F;
    }

    .image{
        text-align: center;
        vertical-align:top;
    }

    .name{
        border:1px solid;
        border-color: #FFD90F;
        text-align: center;
    }

    .number{
        border:1px solid;
        border-color: #FFD90F;
        text-align: right;
    }
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>Statistics</h1>
    </div>
    <br>

    <a class="linkname" href="#" title="View Trials by Technology" onclick='$("#div_trialxtechnology").toggle(200);'>
        <img src="/images/statistics.png" width="14" height="14" border="0"/>
        <b>Trials by Technology</b>
    </a>
    <div id="div_trialxtechnology" class="divdetail">
        <table width="945" align="center">
            <tr class="detail">
                <td class="detail" width="300">
                    <table width="300">
                        <tr>
                            <td width="250" class="name"><b>Technology</b></td>
                            <td width="50" class="name"><b>Trials</b></td>
                        </tr>
                        <?php
                            $TB_trialxtechnology = array_sort($trialxtechnology, 'crpname', SORT_ASC);
                            $count = 1;
                            foreach ($TB_trialxtechnology AS $valor) {
                            $Ttechnology = $Ttechnology + $valor[1]; ?>
                            <tr>
                                <td class="detail"><?php echo "$count. {$valor[0]}"; ?></td>
                                <td class="number"><?php echo $valor[1]; ?></td>
                            </tr>
                        <?php $count++; } ?>
                        <tr>
                            <td class="name"><b>Total</b></td>
                            <td class="number"><b><?php echo $Ttechnology; ?></b></td>
                        </tr>
                    </table>
                </td>
                <td width="645" align="center" class="image">
                    <span>
                        <?php
                        #CREAMOS EL OBJETO PARA LA GRAFICA
                        $FC = new FusionCharts("Bar2D", "600", "1000");

                        #CONFIGURAMOS LA RUTA DONDE ESTAN LOS SWF
                        $FC->setSwfPath("../../FusionCharts/");

                        #DEFINIMOS LOS ATRIBUTOS DE LA GRAFICA
                        $strParam = "caption=Total Trials by Technology; xAxisName=Technologies;yAxisName=Trials;decimalPrecision=0; showNames=1;formatNumberScale=0";

                        #ASIGNAMOS LOS ATRIBUTOS AL OBJETO DE LA GRAFICA
                        $FC->setChartParams($strParam);

                        #ADICIONAMOS LOS VALORES PARA LA GRAFICA AL OB
                        foreach ($trialxtechnology AS $valor) {
                            $FC->addChartData($valor[1], "name={$valor[0]}");
                        }

                        #IMPRIMIMOS LA GRAFICA
                        $FC->renderChart();
                        ?>
                    </span> 
                </td>
            </tr>
        </table>
    </div>
    <br>

    <a class="linkname" href="#" title="View Trials by Country" onclick='$("#div_trialxcountry").toggle(200);'>
        <img src="/images/statistics.png" width="14" height="14" border="0"/>
        <b>Trials by Country</b>
    </a>
    <div id="div_trialxcountry" class="divdetail">
        <table width="945" align="center">
            <tr class="detail">
                <td class="detail" width="300">
                    <table width="300">
                        <tr>
                            <td width="250" class="name"><b>Country</b></td>
                            <td width="50" class="name"><b>Trials</b></td>
                        </tr>
                        <?php
                            $TB_trialxcountry = array_sort($trialxcountry, 'cntname', SORT_ASC);
                            $count = 1;
                            foreach ($TB_trialxcountry AS $valor2) {
                            $Tcountry = $Tcountry + $valor2[1]; ?>
                            <tr>
                                <td class="detail"><?php echo "$count. {$valor2[0]}"; ?></td>
                                <td class="number"><?php echo $valor2[1]; ?></td>
                            </tr>
                        <?php $count++; } ?>
                        <tr>
                            <td class="name"><b>Total</b></td>
                            <td class="number"><b><?php echo $Tcountry; ?></b></td>
                        </tr>
                    </table>
                </td>
                <td width="645" align="center" class="image">
                    <span>
                        <?php
                        #CREAMOS EL OBJETO PARA LA GRAFICA
                        $FC2 = new FusionCharts("Bar2D", "600", "3000");

                        #CONFIGURAMOS LA RUTA DONDE ESTAN LOS SWF
                        $FC2->setSwfPath("../../FusionCharts/");

                        #DEFINIMOS LOS ATRIBUTOS DE LA GRAFICA
                        $strParam = "caption=Total Trials by Country; xAxisName=Country;yAxisName=Trials;decimalPrecision=0; showNames=1;formatNumberScale=0";

                        #ASIGNAMOS LOS ATRIBUTOS AL OBJETO DE LA GRAFICA
                        $FC2->setChartParams($strParam);

                        #ADICIONAMOS LOS VALORES PARA LA GRAFICA AL OB
                        foreach ($trialxcountry AS $valor2) {
                            $FC2->addChartData($valor2[1], "name={$valor2[0]}");
                        }

                        #IMPRIMIMOS LA GRAFICA
                        $FC2->renderChart();
                        ?>                   
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <br>

    <a class="linkname" href="#" title="View Trials by Institution" onclick='$("#div_trialxinstitution").toggle(200);'>
        <img src="/images/statistics.png" width="14" height="14" border="0"/>
        <b>Trials by Institution</b>
    </a>
    <div id="div_trialxinstitution" class="divdetail">
        <table width="945" align="center">
            <tr class="detail">
                <td class="detail" width="300">
                    <table width="300">
                        <tr>
                            <td width="250" class="name"><b>Institution</b></td>
                            <td width="50" class="name"><b>Trials</b></td>
                        </tr>
                        <?php 
                            $TB_trialxinstitution = array_sort($trialxinstitution, 'insname', SORT_ASC);
                            $count = 1;
                            foreach ($TB_trialxinstitution AS $valor3) {
                            $Tinstitution = $Tinstitution + $valor3[1]; ?>
                            <tr>
                                <td class="detail"><?php echo "$count. {$valor3[0]}"; ?></td>
                                <td class="number"><?php echo $valor3[1]; ?></td>
                            </tr>
                        <?php $count++; } ?>
                        <tr>
                            <td class="name"><b>Total</b></td>
                            <td class="number"><b><?php echo $Tinstitution; ?></b></td>
                        </tr>
                    </table>
                </td>
                <td width="645" align="center" class="image">
                    <span>
                        <?php
                        #CREAMOS EL OBJETO PARA LA GRAFICA
                        $FC3 = new FusionCharts("Bar2D", "645", "5000");

                        #CONFIGURAMOS LA RUTA DONDE ESTAN LOS SWF
                        $FC3->setSwfPath("../../FusionCharts/");

                        #DEFINIMOS LOS ATRIBUTOS DE LA GRAFICA
                        $strParam = "caption=Total Trials by Institution; xAxisName=Institution;yAxisName=Trials;decimalPrecision=0; showNames=1;formatNumberScale=0";

                        #ASIGNAMOS LOS ATRIBUTOS AL OBJETO DE LA GRAFICA
                        $FC3->setChartParams($strParam);

                        #ADICIONAMOS LOS VALORES PARA LA GRAFICA AL OB
                        foreach ($trialxinstitution AS $valor3) {
                            $FC3->addChartData($valor3[1], "name=".substr($valor3[0], 0, 50)." ...");
                        }

                        #IMPRIMIMOS LA GRAFICA
                        $FC3->renderChart();
                        ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <br>

    <a class="linkname" href="#" title="View Trials by Trial Group" onclick='$("#div_trialxtrialgroup").toggle(200);'>
        <img src="/images/statistics.png" width="14" height="14" border="0"/>
        <b>Trials by Trial Group</b>
    </a>
    <div id="div_trialxtrialgroup" class="divdetail">
        <table width="945" align="center">
            <tr class="detail">
                <td class="detail" width="300">
                    <table width="300">
                        <tr>
                            <td width="250" class="name"><b>Trial Group</b></td>
                            <td width="50" class="name"><b>Trials</b></td>
                        </tr>
                        <?php 
                            $TB_trialxtrialgroup = array_sort($trialxtrialgroup, 'trgrname', SORT_ASC);
                            $count = 1;
                            foreach ($TB_trialxtrialgroup AS $valor4) {
                            $Tgroup = $Tgroup + $valor4[1]; ?>
                            <tr>
                                <td class="detail"><?php echo "$count. {$valor4[0]}"; ?></td>
                                <td class="number"><?php echo $valor4[1]; ?></td>
                            </tr>
                        <?php $count++; } ?>
                        <tr>
                            <td class="name"><b>Total</b></td>
                            <td class="number"><b><?php echo $Tgroup; ?></b></td>
                        </tr>
                    </table>
                </td>
                <td width="645" align="center" class="image">
                    <span>
                        <?php
                        #CREAMOS EL OBJETO PARA LA GRAFICA
                        $FC4 = new FusionCharts("Bar2D", "645", "1200");

                        #CONFIGURAMOS LA RUTA DONDE ESTAN LOS SWF
                        $FC4->setSwfPath("../../FusionCharts/");

                        #DEFINIMOS LOS ATRIBUTOS DE LA GRAFICA
                        $strParam = "caption=Total Trials by Trial Group; xAxisName=Trial Group;yAxisName=Trials;decimalPrecision=0; showNames=1;formatNumberScale=0";

                        #ASIGNAMOS LOS ATRIBUTOS AL OBJETO DE LA GRAFICA
                        $FC4->setChartParams($strParam);

                        #ADICIONAMOS LOS VALORES PARA LA GRAFICA AL OB
                        foreach ($trialxtrialgroup AS $valor4) {
                            $FC4->addChartData($valor4[1], "name=".substr($valor4[0], 0, 50)." ...");
                        }

                        #IMPRIMIMOS LA GRAFICA
                        $FC4->renderChart();
                        ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <br>

    <a class="linkname" href="#" title="View Trials by Trial Site" onclick='$("#div_trialxtrialsite").toggle(200);'>
        <img src="/images/statistics.png" width="14" height="14" border="0"/>
        <b>Trials by Trial Site</b>
    </a>
    <div id="div_trialxtrialsite" class="divdetail">
        <table width="945" align="center">
            <tr class="detail">
                <td class="detail" width="300">
                    <table width="300">
                        <tr>
                            <td width="250" class="name"><b>Trial Site</b></td>
                            <td width="50" class="name"><b>Trials</b></td>
                        </tr>
                        <?php 
                            $TB_trialxtrialsite = array_sort($trialxtrialsite, 'trstname', SORT_ASC);
                            $count = 1;
                            foreach ($TB_trialxtrialsite AS $valor5) {
                            $Tsite = $Tsite + $valor5[1]; ?>
                            <tr>
                                <td class="detail"><?php echo "$count. {$valor5[0]}"; ?></td>
                                <td class="number"><?php echo $valor5[1]; ?></td>
                            </tr>
                        <?php $count++; } ?>
                        <tr>
                            <td class="name"><b>Total</b></td>
                            <td class="number"><b><?php echo $Tsite; ?></b></td>
                        </tr>
                    </table>
                </td>
                <td width="645" align="center" class="image">
                    <span>
                        <?php
                        #CREAMOS EL OBJETO PARA LA GRAFICA
                        $FC5 = new FusionCharts("Bar2D", "645", "20000");

                        #CONFIGURAMOS LA RUTA DONDE ESTAN LOS SWF
                        $FC5->setSwfPath("../../FusionCharts/");

                        #DEFINIMOS LOS ATRIBUTOS DE LA GRAFICA
                        $strParam = "caption=Total Trials by Trial Site; xAxisName=Trial Site;yAxisName=Trials;decimalPrecision=0; showNames=1;formatNumberScale=0";

                        #ASIGNAMOS LOS ATRIBUTOS AL OBJETO DE LA GRAFICA
                        $FC5->setChartParams($strParam);

                        #ADICIONAMOS LOS VALORES PARA LA GRAFICA AL OB
                        foreach ($trialxtrialsite AS $valor5) {
                            $FC5->addChartData($valor5[1], "name=".substr($valor5[0], 0, 50)." ...");
                        }

                        #IMPRIMIMOS LA GRAFICA
                        $FC5->renderChart();
                        ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <br>
</div>