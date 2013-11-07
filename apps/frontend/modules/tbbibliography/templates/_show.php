<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>
<?php use_helper('Thickbox') ?>

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

        <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields) {  ?>
                <div id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
                    <div class="sf_admin_form_row">
                        <label>id:</label>
                        <?php echo $form->getObject()->get('id_bibliography'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Crop:</label>
                        <?php
                            $Crop = Doctrine::getTable('TbCrop')->findOneByIdCrop($form->getObject()->get('id_crop'));
                            echo $Crop->getCrpname();
                        ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Trial group:</label>
                        <?php
                            $Trialgroup = Doctrine::getTable('TbTrialgroup')->findOneByIdTrialgroup($form->getObject()->get('id_trialgroup'));
                            echo $Trialgroup->getTrgrname();
                        ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Language:</label>
                        <?php
                            $Language = Doctrine::getTable('TbLanguage')->findOneByIdLanguage($form->getObject()->get('id_language'));
                            echo $Language->getLngname();
                        ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Reference type:</label>
                        <?php echo $form->getObject()->get('bbgreferencetype'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Title:</label>
                        <?php echo $form->getObject()->get('bbgtitle'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Author:</label>
                        <?php echo $form->getObject()->get('bbgauthor'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Volume:</label>
                        <?php echo $form->getObject()->get('bbgvolume'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Number:</label>
                        <?php echo $form->getObject()->get('bbgnumber'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Year:</label>
                        <?php echo $form->getObject()->get('bbgyear'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Document title:</label>
                        <?php echo $form->getObject()->get('bbgdocumenttitle'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Publisher:</label>
                        <?php echo $form->getObject()->get('bbgpublisher'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Pages:</label>
                        <?php echo $form->getObject()->get('bbgpages'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Abstract:</label>
                        <?php echo $form->getObject()->get('bbgabstract'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Keywords:</label>
                        <?php echo $form->getObject()->get('bbgkeywords'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Notes:</label>
                        <?php echo $form->getObject()->get('bbgnotes'); ?>
                    </div>

                    <div class="sf_admin_form_row">
                        <label>Added to library:</label>
                        <?php echo $form->getObject()->get('bbgaddedtolibrary'); ?>
                    </div>


                </div>
<?php } ?>
    </div>
</div>