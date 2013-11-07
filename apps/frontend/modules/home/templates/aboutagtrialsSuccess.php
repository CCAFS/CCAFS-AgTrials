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


    hr{height:1px;border:1px solid #FFD41C;}

    .tituloinicial {
        font-family: Verdana;
        border-top:2px solid #FFD41C;
        background-color: #48732A;
        font-size: 16px;
        color: #FFFFFF;
        font-weight: bold;
        padding: 4px;
        line-height:25px;
    }

    .titulosesiones {
        font-family: Verdana;
        border-top:2px solid #FFD41C;
        background-color: #48732A;
        font-size: 16px;
        color: #FFFFFF;
        font-weight: bold;
        padding: 4px;
    }
</style>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div class="fg-toolbar ui-widget-header ui-corner-all">
        <h1>About Us - a multi site agricultural trial database and file repository for climate change analysis</h1>
    </div>
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        </br>Please Wait...
    </div>
    <table width="940" border="0" align="center">
        <tr>
            <td width="940" valign="top" colspan="3">
                <p align="justify">For decades cultivar testing has proven to be an efficient and valuable methodology for varietal improvement and targeted dissemination. Trial sites in particular, maintained by CG-centers, advanced research institutes and/or NARS, have been key elements for improvement programs addressing issues such as drought tolerance, heat stress, pasture and livestock management, soil, water and forest management, and fisheries.</p>
				</br>
			</td>
        </tr>
        <tr>
            <td width="460" valign="top">
                <div align="center" class="titulosesiones">Issue</div>
                <p align="justify">Much of the information on trial sites is not publically available, and indeed large volumes of historic trials data are likely lost due to poor data management. Gaps remain and there is an urgent need to design and test new institutional arrangements, and to improve the dissemination performance of the system.</p>
                </br>
				<div align="center" class="titulosesiones">Goal</div>
                <p align="justify">This ambitious CCAFS initiative started in 2010, aims to develop an agricultural technology evaluation database for climate change analysis. Its ultimate aims are:</p>
                <span>to <b>facilitate the subsequent analysis</b> on the performance of agricultural technologies under a changing climate and</span>
                <span>to form the <b>basis for improving models</b> of agricultural production under current and future conditions, and <b>for evaluating the efficacy</b> of trialed materials for adaptation.</span>
				</p>
				</br>
				
                <div align="center" class="titulosesiones">Achievements so far</div>
				<p>
                <span>Design of an alpha version of a friendly web application to compile and store information on the performance of agricultural technology</span>
                <span>Collection, organization and upload of raw data and their associated metadata from more than 800 trials carried out in the last three decades; covering:</span>
                <span>More than 20 countries across Africa, South Asia and Latin America</span>
                <span>16 crops and 7 livestock species.</span>
				</p>
				</br></br></br>
             </td>
            <td width="20" valign="top"></td>
            <td width="460" valign="top">
                <div align="center" class="titulosesiones">Other related ongoing activities</div>
				<p>
                <span>Development of a generic methodology for G x E analysis to understand varietal response through genotype by environment. Method fully coded, documented and integrated into R-package.</span>
                <span>Application of the method to one case study, using the gathered data.</span>
                <span>Collaboration with crop modeling initiatives Agricultural Model Intercomparison and Improvement Project(AgMIP) and Global Futures, including modeled trials.</span>
                <span>Development of a community of data analysts looking at varietal response for a whole range of crops.</span>
                <span>Exploring collaboration with selected groups of on-going programs and initiatives.</span>
				</p>
				</br>
  
                <div align="center" class="titulosesiones">Current Partners</div>
					<p>
                     <span>Eight CGIAR centers:
                        the Africa Rice Center (<a href="http://www.warda.cgiar.org/" target="_blank">AfricaRice</a>),
                        the Tropical Soil Biology and Fertility Institute of CIAT (<a href="http://webapp.ciat.cgiar.org/tsbf_institute/" target="_blank">CIAT-TSBF</a>),
                        the International Potato Center (<a href="http://www.cipotato.org/" target="_blank">CIP</a>),
                        the International Crops Research Institute for the Semi-Arid Tropics (<a href="http://www.icrisat.org/" target="_blank">ICRISAT</a>),
                        the International Livestock Research Institute (<a href="http://www.ilri.org/" target="_blank">ILRI</a>),
                        the International Center for Agricultural Research in Dry Areas (<a href="http://www.icarda.cgiar.org/" target="_blank">ICARDA</a>),
                        the International Rice Research Institute (<a href="http://irri.org/" target="_blank">IRRI</a>),
                        the International Institute of Tropical Agriculture (<a href="http://www.iita.org/" target="_blank">IITA</a>) and 
                        Bioversity (<a href="http://www.bioversityinternational.org/" target="_blank">Bioversity</a>).
                    </span>
                    <span>National partners:
                        IER, Réseau Ouest et Centrafricain de recherche sur le Sorgho, CILSS, IRAT -NARS/ CIRAD, SMIP
                    </span>
					</p>
					</br>
 
                <div align="center" class="titulosesiones">How to cite us?</div>
					<p>
                    <span>
                        CGIAR Research Program on Climate Change and Agricultural Food Security (CCAFS). 2013. AgTrials: Global Agricultural Trial Repository and Database. Available from http://www.agtrials.org/. Cali, Colombia
                    </span>
					</p>
					</br>
            </td>
        </tr>
    </table>
</div>

