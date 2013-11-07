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

        <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields) { ?>
            <div id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
                <div class="sf_admin_form_row">
                    <label>Id:</label>
                    <?php echo $form->getObject()->get('id_variablesmeasured'); ?>
                </div>

                <div class="sf_admin_form_row">
                    <label>Crop:</label>
                    <?php
                    $Crop = Doctrine::getTable('TbCrop')->findOneByIdCrop($form->getObject()->get('id_crop'));
                    echo $Crop->getCrpname();
                    ?>
                </div>

                <div class="sf_admin_form_row">
                    <label>Trait class:</label>
                    <?php
                    $Traitclass = Doctrine::getTable('TbTraitclass')->findOneByIdTraitclass($form->getObject()->get('id_traitclass'));
                    echo $Traitclass->getTrclname();
                    ?>
                </div>

                <div class="sf_admin_form_row">
                    <label>Name:</label>
                    <?php echo $form->getObject()->get('vrmsname'); ?>
                </div>

                <div class="sf_admin_form_row">
                    <label>Short name:</label>
                    <?php echo $form->getObject()->get('vrmsshortname'); ?>
                </div>

                <div class="sf_admin_form_row">
                    <label>Definition:</label>
                    <?php echo $form->getObject()->get('vrmsdefinition'); ?>
                </div>

                <div class="sf_admin_form_row">
                    <label>Method:</label>
                    <?php echo $form->getObject()->get('vrmnmethod'); ?>
                </div>

                <div class="sf_admin_form_row">
                    <label>Unit:</label>
                    <?php echo $form->getObject()->get('vrmsunit'); ?>
                </div>

                <?php if ($form->getObject()->get('id_ontology') != '') { ?>
                    <div class="sf_admin_form_row">
                        <a onclick="window.open('http://www.cropontology-curationtool.org/terms/<?php echo $form->getObject()->get('id_ontology'); ?>/Stem%20rust/static-html','cropontology-curationtool','height=800,width=900,scrollbars=1')" href="">View in Crop Ontology Curation Tool</a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>