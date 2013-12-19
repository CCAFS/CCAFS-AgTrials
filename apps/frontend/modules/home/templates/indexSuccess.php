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
    hr{height:1px;border:1px solid #FFD41C;}

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
    }
    .titulosesiones {
        font-family: Verdana;
        border-top:2px solid #FFD41C;
        background-color: #48732A;
        font-size: 1.2em;
        color: #FFFFFF;
        font-weight: bold;
        padding: 4px;
    }

    #post {  
        width:460px;  
        height:136px;  
        background-color:#F2F2F2;  
        overflow:auto;  
    }  

    .redessociales{
        text-align:center;
        margin:0 auto 0 auto; width:250px;
    }

</style>
<script>
    $(document).ready(function() {

    });
</script>
<div class="sf_admin_edit ui-widget ui-widget-content ui-corner-all" id="sf_admin_container">
    <div id="div_loading" class="loading" align="center" style="display:none;">
        <?php echo image_tag('loading.gif'); ?>
        <br>Please Wait...
    </div>
    <table width="940" border="0" align="center">
        <tr>
            <td width="460" valign="top">
                <table width="455" border="0">
                    <tr>
                        <td>
                            <div align="center" class="titulosesiones">
                                AgTrials&mdash;The Global Agricultural Trial Repository
                            </div>
                            <p align="justify"> Agtrials.org is an information portal developed by the CGIAR Research Program on Climate Change, Agriculture and Food Security (<a title="CCAFS" target="_new" href="http://ccafs.cgiar.org/">CCAFS</a>) which provides access to a database on the performance of agricultural technologies at sites across the developing world. It builds on decades of evaluation trials, mostly of varieties, but includes any agricultural technology for developing world farmers. This project will standardize data and information to the benefit of climate change analyses, future multi-environment trials and research and development in international agriculture.</p>
                            <div align="justify"><br>
                                <div align="center" class="titulosesiones">
                                    What you can do with the interface
                                </div>
                                <div>
                                    <div><img src="/images/check-icon.png" width="12" height="12" border="0"/> Share data and information on evaluations of agricultural technology.</div>
                                    <div><img src="/images/check-icon.png" width="12" height="12" border="0"/> Acquire agricultural evaluation data sets for your own research.</div>
                                    <div><img src="/images/check-icon.png" width="12" height="12" border="0"/> Explore the geographic dimensions of agricultural evaluation</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="441"><br>
                            <div align="center" class="titulosesiones">
                                Partners
                            </div><br>
                            <div align="left">
                                <a title="CIAT" href="http://www.ciat.cgiar.org/Paginas/index.aspx" target="_blank"><span><img src="/images/partners/CIAT.jpg" border="0"/></span></a>
                                <a title="CIP" href="http://www.cipotato.org/" target="_blank"><span><img src="/images/partners/CIP.jpg" border="0"/></span></a>
                                <a title="ICARDA" href="http://www.icarda.org/" target="_blank"><span><img src="/images/partners/ICARDA.jpg" border="0"/></span></a>
                                <a title="ICRISAT" href="http://www.icrisat.org/" target="_blank"><span><img src="/images/partners/ICRISAT.jpg" border="0"/></span></a>
                                <a title="ILRI" href="http://www.ilri.org/" target="_blank"><span><img src="/images/partners/ILRI.jpg" border="0"/></span></a>
                                <a title="IRRI" href="http://irri.org/" target="_blank"><span><img src="/images/partners/IRRI.jpg" border="0"/></span></a>
                                <a title="ARC" href="http://www.warda.cgiar.org/" target="_blank"><span><img src="/images/partners/ARC.jpg" border="0"/></span></a>
                                <a title="GCP" href="http://www.generationcp.org/" target="_blank"><span><img src="/images/partners/GCP.jpg" border="0"/></span></a>
                                <a title="IITA" href="http://www.iita.org/" target="_blank"><span><img src="/images/partners/IITA.jpg" border="0"/></span></a>
                                <a title="Bioversity" href="http://www.bioversityinternational.org/" target="_blank"><span><img src="/images/partners/bioversityinternational.jpg" border="0"/></span></a>
                                <a title="CIMMYT" href="http://www.cimmyt.org/" target="_blank"><span><img src="/images/partners/CIMMYT.jpg" border="0"/></span></a>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><br>
                            <div align="center" class="titulosesiones">Social Media</div><br>
                            <div align="center" class="redessociales">
                                <a title="Facebook" target="_blank" href="http://www.facebook.com/profile.php?id=100003323023382"><img src="/images/facebook-icon2.png" border="0"></a>
                                <a title="Twitter" target="_blank" href="https://twitter.com/AgTrials"><img src="/images/twitter-icon2.png" border="0"></a>
                                <a title="Youtube" target="_blank" href="http://www.youtube.com/user/AgTrials"><img src="/images/youtube-icon2.png" border="0"></a>
                                <a href="http://gisweb.ciat.cgiar.org/trialsitesblog/" target="_blank" title="Blog"><img width="32" height="32" border="0" src="/images/blog-icon2.png"></a>
                                <a href="http://www.agtrials.org/forum" target="_blank" title="Forum"><img width="32" height="32" border="0" src="/images/forum-icon.png"></a>
                                <a href="mailto:noreplyagtrials@gmail.com" target="_blank" title="Send E-mail"><img width="32" height="32" border="0" src="/images/mail-icon2.png"></a>
                            </div>
                            </br></br></br></br>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="20" valign="top"></td>
            <td width="460" valign="top">
                <table width="455" border="0">
                    <tr>
                        <td width="450" colspan="2">
                            <iframe width="462" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="/home/mapindex"></iframe>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="center" class="titulosesiones">
                                Latest Posts
                                <span><a valign="middle" title="Follow AgTrials Blog via RSS" target="_new" href="AgTrialsBlogRSS"><img src="/images/rss2.png" width="14" height="14" border="0"/></a></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" valign="top">
                            <div align="center" id="post">
                                <?php
                                $first = true;
                                if (count($lastpost) > 0) {
                                    foreach ($lastpost AS $post) {
                                        ?>
                                        <table>
                                            <tr>
                                                <td width="30%" align="center">
                                                    <a title="Permanent Link to <?php echo $post['post_title']; ?>" target="_new" rel="bookmark" href="http://gisweb.ciat.cgiar.org/trialsitesblog/?p=<?php echo $post['id']; ?>">
                                                        <span><img width=90 height=90 border="0" src="<?php echo $post['image']; ?>"/></span>
                                                    </a>
                                                </td>
                                                <td width="70%">
                                                    <a title="Permanent Link to <?php echo $post['post_title']; ?>" target="_new" href="http://gisweb.ciat.cgiar.org/trialsitesblog/?p=<?php echo $post['id']; ?>"><b><?php echo $post['post_title']; ?></b><br><?php echo date("M jS, Y", strtotime($post['post_date'])) . " | by {$post['user']}"; ?></a><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p align="justify">
                                                        <?php
                                                        $total = 0;
                                                        $post_content = html_entity_decode($post['post_content']);
                                                        $maximo = strlen($post_content);
                                                        $cadena_comienzo = "[/caption]";
                                                        $total = strpos($post_content, $cadena_comienzo) + 10;
                                                        if ($total != 10)
                                                            $post_content = substr($post_content, $total, $maximo);
                                                        $strfin = strpos($post_content, ". ") + 1;
                                                        $PostContent = substr($post_content, 0, $strfin);
                                                        $PostContent = trim($PostContent);
                                                        echo $PostContent;
                                                        ?>

                                                        <br>
                                                        <span>
                                                            <a title="<?php echo $post['post_title']; ?> Read More..." target="_new" href="http://gisweb.ciat.cgiar.org/trialsitesblog/?p=<?php echo $post['id']; ?>"><b>[Continue Reading...]</b></a>
                                                        </span>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr>
                                        <?php
                                    }
                                }
                                ?>
                                <p align="center">
                                    <a title="AgTrials Blog" target="_new" href="http://gisweb.ciat.cgiar.org/trialsitesblog/"><img src="/images/blog-icon2.png" border="0"/></a>
                                </p>
                                </br>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div align="center" class="titulosesiones">
                                Latest Trials
                                <span onclick='$("#div_loading").show();'>
                                    <a valign="middle" title="Follow AgTrials via GeoRSS" href="geoRSS"><img src="/images/georss.png" width="14" height="14" border="0"/></a>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" valign="top">
                            <div>
                                <?php foreach ($lasttrial as $trial) { ?>
                                    <div onclick='$("#div_loading").show();'><img src="/images/Arrow-icon.png" width="12" height="12" border="0"/> <a rel="bookmark" href="tbtrial/<?php echo $trial['id_trial']; ?>"><?php echo "{$trial['trlname']} - {$trial['cropanimal']} - " . date("M jS, Y", strtotime($trial['created_at'])); ?></a></div>
                                <?php } ?>
                            </div>
                            </br>
                        </td>
                    </tr>
                    <tr>
                        <td width="227">
                            <div align="center" class="titulosesiones">
                                Statistics
                                <span onclick='$("#div_loading").show();'>
                                    <img src="/images/statistics.png" width="14" height="14" border="0"/>
                                </span>
                            </div>
                        </td>
                        <td width="227">
                            <div align="center" class="titulosesiones">
                                Videos
                                <span onclick='$("#div_loading").show();'>
                                    <img src="/images/youtube-icon.png" width="14" height="14" border="0"/>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="227">
                            <div>
                                <div><img src="/images/bullet-black-icon.png" width="16" height="16" border="0"/> Trial Groups: <?php echo $statistics[0][0]; ?></div>
                                <div><img src="/images/bullet-black-icon.png" width="16" height="16" border="0"/> Technologies: <?php echo $statistics[0][2]; ?></div>
                                <div><img src="/images/bullet-black-icon.png" width="16" height="16" border="0"/> Trials: <?php echo $statistics[0][1]; ?></div>
                                <span><a href="statistics" title="More Information..." onclick='$("#div_loading").show();'><b>[More Information...]</b></a></span>
                            </div>
                        </td>
                        <td width="227">
                            <div>
                                <?php foreach ($videos as $video) { ?>
                                    <div onclick='$("#div_loading").show();'><img src="/images/Arrow-icon.png" width="12" height="12" border="0"/> <a rel="bookmark" href="viewvideo/?id_video=<?php echo $video['id_video']; ?>"><?php echo "{$video['vdename']}"; ?></a></div>
                                <?php } ?>
                                <span onclick='$("#div_loading").show();'><a href="viewvideo" title="More Videos..." onclick='$("#div_loading").show();'><b>[More Videos...]</b></a></span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
