<?php thickbox_iframe() ?>
<div class="ui-corner-all" id="sf_fieldset_none">
    <div class="sf_admin_form_row sf_admin_text">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_crop']->renderLabel('Technology') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_crop']->renderError() ?>
        </div>
        <?php echo $form['id_crop']->render() ?>
        </div>
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix">
            <?php echo $form['id_traitclass']->renderLabel('Trait Class') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_traitclass']->renderError() ?>
        </div>
        <?php echo $form['id_traitclass']->render() ?>
        </div>
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix">
            <?php echo $form['vrmsname']->renderLabel('Name') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['vrmsname']->renderError() ?>
        </div>
        <?php
            if ($form->getObject()->get('id_ontology') != '') {
        ?>
                <input type="text" id="tb_variablesmeasured_vrmsname" value="<?php echo $form->getObject()->get('vrmsname'); ?>" name="tb_variablesmeasured[vrmsname]" size="30" readonly>
        <?php
            } else {
                echo $form['vrmsname']->render();
            }
        ?>
        </div>
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix">
            <?php echo $form['vrmsshortname']->renderLabel('Short name') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['vrmsshortname']->renderError() ?>
        </div>
        <?php echo $form['vrmsshortname']->render() ?>
        </div>
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix">
            <?php echo $form['vrmsdefinition']->renderLabel('Definition') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['vrmsdefinition']->renderError() ?>
        </div>
        <?php echo $form['vrmsdefinition']->render() ?>
        </div>
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix">
            <?php echo $form['vrmnmethod']->renderLabel('Method') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['vrmnmethod']->renderError() ?>
        </div>
        <?php echo $form['vrmnmethod']->render() ?>
        </div>
        <div class="sf_admin_form_row sf_admin_text">
            <div class="label ui-helper-clearfix">
            <?php echo $form['vrmsunit']->renderLabel('Unit') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['vrmsunit']->renderError() ?>
        </div>
        <?php echo $form['vrmsunit']->render() ?>
    </div>
</div>
