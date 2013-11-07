<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Thickbox') ?>
<script>
    function downloadfile(id_trialgroupfile){
        location.href="/tbtrialgroup/downloadfile/?id_trialgroupfile="+id_trialgroupfile;
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
                        <label>id:</label>
                <?php echo $form->getObject()->get('id_trialgroup'); ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Institution:</label>
                <?php
                $Institution = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($form->getObject()->get('id_institution'));
                echo $Institution->getInsname();
                ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Contact person:</label>
                <?php
                $ListContactperson = "";
                $TbTrialgroupcontactperson = Doctrine::getTable('TbTrialgroupcontactperson')->findByIdTrialgroup($form->getObject()->get('id_trialgroup'));
                foreach ($TbTrialgroupcontactperson AS $Trialgroupcontactperson) {
                    $Contactperson = Doctrine::getTable('TbContactperson')->findOneByIdContactperson($Trialgroupcontactperson->id_contactperson);
                    $ListContactperson .= $Contactperson->getCnprfirstname() . " " . $Contactperson->getCnprlastname() . ", ";
                }
                $ListContactperson = substr($ListContactperson, 0, strlen($ListContactperson) - 2);
                echo $ListContactperson;
                ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Trial group type:</label>
                <?php
                $Trialgrouptype = Doctrine::getTable('TbTrialgrouptype')->findOneByIdTrialgrouptype($form->getObject()->get('id_trialgrouptype'));
                echo $Trialgrouptype->getTrgptyname();
                ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Objective:</label>
                <?php
                $Objective = Doctrine::getTable('TbObjective')->findOneByIdObjective($form->getObject()->get('id_objective'));
                echo $Objective->getObjname();
                ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Primary discipline:</label>
                <?php
                $Primarydiscipline = Doctrine::getTable('TbPrimarydiscipline')->findOneByIdPrimarydiscipline($form->getObject()->get('id_primarydiscipline'));
                echo $Primarydiscipline->getPrdsname();
                ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Name:</label>
                <?php echo $form->getObject()->get('trgrname'); ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Start year:</label>
                <?php echo $form->getObject()->get('trgrstartyear'); ?>
            </div>

            <div class="sf_admin_form_row">
                <label>End year:</label>
                <?php echo $form->getObject()->get('trgrendyear'); ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Trial group record status:</label>
                <?php echo $form->getObject()->get('trgrtrialgrouprecordstatus'); ?>
            </div>

            <div class="sf_admin_form_row">
                <label>Trial group record date:</label>
                <?php echo $form->getObject()->get('trgrtrialgrouprecorddate'); ?>
            </div>

            <div class="sf_admin_form_row sf_admin_foreignkey sf_admin_text">
                <div class="label ui-helper-clearfix">
                    <label>Documents</label>
                </div>
                <?php
                //TAMANO DE LAS COLUMNAS
                $width1 = '30%';
                $width2 = '50%';
                $width3 = '20%';
                ?>
                <div class="label ui-helper-clearfix">
                    <table cellspacing="1" cellpadding="10" border="1" width="100%">
                        <tbody>
                            <tr bgcolor="#C7C7C7">
                                <td width="<?php echo $width1; ?>"><label>File</label></td>
                                <td width="<?php echo $width2; ?>"><label>Description</label></td>
                                <td width="<?php echo $width3; ?>"><label>Actions</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <table cellspacing="1" cellpadding="10" border="1" width="100%">
                        <?php
                        $HTML2 = "";
                        $QUERY = Doctrine_Query::create()
                                        ->select("TGF.id_trialgroupfile,TGF.trgrflfile,TGF.trgrfldescription")
                                        ->from("TbTrialgroupfile TGF")
                                        ->where("TGF.id_trialgroup = {$form->getObject()->get('id_trialgroup')}")
                                        ->orderBy("TGF.id_trialgroupfile");
                        //echo $QUERY->getSqlQuery();
                        $Results = $QUERY->execute();
                        $bgcolor = "#C0C0C0";
                        foreach ($Results AS $row) {
                            if ($bgcolor != "#FFFFD9")
                                $bgcolor = "#FFFFD9";
                            else
                                $bgcolor = "#C0C0C0";

                            $trgrflfile = $row['trgrflfile'];
                            $PartFile = explode(".", $trgrflfile);
                            $Extension = strtoupper($PartFile[1]);
                            $HTML2 .= "<tr bgcolor='$bgcolor'>";
                            $HTML2 .= "<td width='$width1'>{$row['trgrflfile']}</td>";
                            $HTML2 .= "<td width='$width2'>{$row['trgrfldescription']}</td>";
                            $HTML2 .= "<td width='$width3'>";
                            $HTML2 .= "<span alt='Download' onclick='downloadfile({$row['id_trialgroupfile']})'><img src=\"/images/download-icon.png\"></span>&ensp;";
                            $HTML2 .= "</td>";
                            $HTML2 .= "</tr>";
                        }
                        ?>
                        <tbody id="photographs">
                            <?php echo $HTML2; ?>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
        </div>
        <?php } ?>
    </div>
</div>