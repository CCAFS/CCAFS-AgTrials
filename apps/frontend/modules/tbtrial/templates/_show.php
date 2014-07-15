
<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Thickbox') ?>
<?php $connection = Doctrine_Manager::getInstance()->connection(); ?>

<script>
    $(document).ready(function() {
        $('#acceptthelicense').click(function() {
            Closeresultdata();
            Closebotonresultdata();
            $.ajax({
                type: "GET",
                url: "/tbtrial/showtrialdata/",
                data: "id_trial=<?php echo $form->getObject()->get('id_trial'); ?>",
                success: function(data) {
                    $('#VariablesMeasureds').html(data);
                    if (data != '') {
                        $("#Div_Datos").css("width", "920px");
                        $("#Div_Datos").css("height", "400px");
                        $("#Div_Datos").css("overflow-x", "hidden");
                        $("#Div_Datos").css("overflow-y", "scroll");
                    }
                }
            });
        });

    });

    function Showresultdata() {
        div = document.getElementById('showresultdata');
        div.style.display = '';
    }

    function Closeresultdata() {
        div = document.getElementById('showresultdata');
        div.style.display = 'none';
    }

    function Closebotonresultdata() {
        div = document.getElementById('Showdata');
        div.style.display = 'none';
    }

</script>
<div class="sf_admin_form">
    <?php
    $count = 0;
    foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields):
        $count++;
    endforeach;
    ?>

    <div id="sf_admin_form_tab_menu">
        <?php if ($count > 1) {
            ?>
            <ul>
                <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields): ?>
                    <?php $count++ ?>
                    <li><a href="#sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>"><?php echo __($fieldset, array(), 'messages') ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php } ?>

        <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields) {
            ?>
            <div id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
                <div class="sf_admin_form_row">
                    <label>Id:</label>
                    <values><?php echo $form->getObject()->get('id_trial'); ?></values>

                </div>

                <div class="sf_admin_form_row">
                    <label>Trial group:</label>
                    <values>
                        <?php
                        $trialgroup = Doctrine::getTable('TbTrialgroup')->findOneByIdTrialgroup($form->getObject()->get('id_trialgroup'));
                        echo "<a title='View Trial Group' href=\"{$form->getObject()->get('id_trial')}\" onClick=\"window.open('http://www.agtrials.org/tbtrialgroup/{$form->getObject()->get('id_trialgroup')}','Genebank','height=800,width=1000,scrollbars=1')\"><span style=\"color: #48732A;\"><img src='/images/lens-icon.png' width='12' height='12'>{$trialgroup->getTrgrname()}</span></a>";
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Contact person:</label>
                    <values>
                        <?php
                        $contactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($form->getObject()->get('id_contactperson'));
                        echo $contactperson->getCnprfirstname() . " " . $contactperson->getCnprlastname();
                        if ($contactperson->getCnpremail() != '')
                            echo " - <a href='mailto:{$contactperson->getCnpremail()}'><font color='#48732A'>{$contactperson->getCnpremail()}</font></a>";
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Country:</label>
                    <values>
                        <?php
                        $country = Doctrine::getTable('TbCountry')->findOneByIdCountry($form->getObject()->get('id_country'));
                        echo $country->getCntname();
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Trial site:</label>
                    <values>
                        <?php
                        $trialsite = Doctrine::getTable('TbTrialsite')->findOneByIdTrialsite($form->getObject()->get('id_trialsite'));
                        echo "<a title='View Trial Site' href=\"{$form->getObject()->get('id_trial')}\" onClick=\"window.open('http://www.agtrials.org/tbtrialsite/{$form->getObject()->get('id_trialsite')}','Genebank','height=800,width=1000,scrollbars=1')\"><span style=\"color: #48732A;\"><img src='/images/lens-icon.png' width='12' height='12'>{$trialsite->getTrstname()}</span></a>";
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Field name number:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('id_fieldnamenumber') != null) {
                            $fieldnamenumber = Doctrine::getTable('TbFieldnamenumber')->findOneByIdFieldnamenumber($form->getObject()->get('id_fieldnamenumber'));
                            echo $fieldnamenumber->getTrialenvironmentname();
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Name:</label>
                    <values><?php echo $form->getObject()->get('trlname'); ?></values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Sow/plant date:</label>
                    <values><?php echo $form->getObject()->get('trlsowdate'); ?></values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Harvest date:</label>
                    <values><?php echo $form->getObject()->get('trlharvestdate'); ?></values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Irrigation:</label>
                    <values><?php echo $form->getObject()->get('trlirrigation'); ?></values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Technology:</label>
                    <values>
                        <?php
                        $crop = Doctrine::getTable('TbCrop')->findOneByIdCrop($form->getObject()->get('id_crop'));
                        echo $crop->getCrpname();
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Varieties/Race:</label>
                    <values>
                        <?php
                        $QUERY01 = "SELECT fc_trialvariety({$form->getObject()->get('id_trial')}) AS trialvariety;";
                        $st = $connection->execute($QUERY01);
                        $Resultado01 = $st->fetchAll();
                        if (count($Resultado01) > 0) {
                            foreach ($Resultado01 AS $fila01) {
                                $trialvariety = $fila01['trialvariety'];
                            }
                            echo $trialvariety;
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Variables measured:</label>
                    <values>
                        <?php
                        $QUERY02 = "SELECT fc_trialvariablesmeasured({$form->getObject()->get('id_trial')}) AS trialvariablesmeasured;";
                        $st = $connection->execute($QUERY02);
                        $Resultado02 = $st->fetchAll();
                        if (count($Resultado02) > 0) {
                            foreach ($Resultado02 AS $fila02) {
                                $trialvariablesmeasured = $fila02['trialvariablesmeasured'];
                            }
                            echo $trialvariablesmeasured;
                        }
                        ?>
                    </values>
                </div>

                <?php if (ResultTrialData($form->getObject()->get('id_trial'))) {
                    ?>
                    <div class="sf_admin_form_row">
                        <input type="button" value="Show result data" id="Showdata" onclick="Showresultdata()">
                        <div class="sf_admin_form_row" id="showresultdata"  style="display: none;">
                            <?php
                            if ($form->getObject()->get('trllicense') != null) {
                                echo "<b>IMPORTANT: Read the license before show result data.</b>";
                                echo "<br>";
                                echo $form->getObject()->get('trllicense');
                                echo "<br>";
                                echo "<input type='button' value='I accept the license' id='acceptthelicense'>";
                                echo "<input type='button' value='I do not accept the license' onclick='Closeresultdata()'>";
                            } else {
                                echo "<script>Closebotonresultdata();</script>";
                                $Html_VariablesMeasureds = ShowTrialData($form->getObject()->get('id_trial'));
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>

                <div id="Div_Datos" class="sf_admin_form_row sf_admin_text">
                    <table cellspacing="1" cellpadding="10" border="1" width="100%">
                        <tbody id="VariablesMeasureds"><?php echo $Html_VariablesMeasureds; ?></tbody>
                    </table>
                </div>

                <div class="sf_admin_form_row">
                    <label>Metadata/Data:</label>
                    <values>
                        <?php echo thickbox_iframe('  Download ' . image_tag('Excel-icon.png'), '@download_file', array('pop' => '1', 'id_trial' => $form->getObject()->get('id_trial'), 'trlfileaccess' => $form->getObject()->get('trlfileaccess')), array(), array('width' => '800', 'height' => '500')); ?>

                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Trial results file:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('trltrialresultsfile') != null) {
                            echo thickbox_iframe('  Download ' . image_tag('download-file-icon.png'), '@download_file', array('pop' => '1', 'id_trial' => $form->getObject()->get('id_trial'), 'trlfileaccess' => $form->getObject()->get('trlfileaccess')), array(), array('width' => '800', 'height' => '500'));
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Supplemental information file:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('trlsupplementalinformationfile') != null) {
                            echo thickbox_iframe('  Download ' . image_tag('download-file-icon.png'), '@download_file', array('pop' => '1', 'id_trial' => $form->getObject()->get('id_trial'), 'trlfileaccess' => $form->getObject()->get('trlfileaccess')), array(), array('width' => '800', 'height' => '500'));
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Weather during trial file:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('trlweatherduringtrialfile') != null) {
                            echo thickbox_iframe('  Download ' . image_tag('download-file-icon.png'), '@download_file', array('pop' => '1', 'id_trial' => $form->getObject()->get('id_trial'), 'trlfileaccess' => $form->getObject()->get('trlfileaccess')), array(), array('width' => '800', 'height' => '500'));
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Soil type conditions during trial file:</label>
                    <values>
                        <?php
                        if ($form->getObject()->get('trlsoiltypeconditionsduringtrialfile') != null) {
                            echo thickbox_iframe('  Download ' . image_tag('download-file-icon.png'), '@download_file', array('pop' => '1', 'id_trial' => $form->getObject()->get('id_trial'), 'trlfileaccess' => $form->getObject()->get('trlfileaccess')), array(), array('width' => '800', 'height' => '500'));
                        }
                        ?>
                    </values>
                </div>

                <div class="sf_admin_form_row">
                    <label>License of file Results and file supplemental information:</label>
                    <values><?php echo $form->getObject()->get('trllicense'); ?></values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Files access:</label>
                    <values><?php echo $form->getObject()->get('trlfileaccess'); ?></values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Trial type:</label>
                    <values><?php echo $form->getObject()->get('trltrialtype'); ?></values>
                </div>

                <div class="sf_admin_form_row">
                    <label>Created by user:</label>
                    <values>
                        <?php
                        $User = Doctrine::getTable('SfGuardUser')->findOneById($form->getObject()->get('id_user'));
                        echo "{$User->getFirst_name()} {$User->getLast_name()}";
                        ?>
                    </values>
                </div>
                
                <div class="sf_admin_form_row">
                    <label>Created date:</label>
                    <values><?php echo $form->getObject()->get('created_at'); ?></values>
                </div>
            </div>
        <?php } ?>
    </div>
</div>