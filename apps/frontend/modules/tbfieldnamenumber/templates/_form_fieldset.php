<?php use_helper('Thickbox') ?>
<div class="ui-corner-all" id="sf_fieldset_none">
    <div class="sf_admin_form_row sf_admin_foreignkey">
        <div class="label ui-helper-clearfix">
            <?php echo $form['id_trialsite']->renderLabel('Trial site') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_trialsite']->renderError() ?>
        </div>
        <?php echo $form['id_trialsite']->render() ?>
        <?php echo thickbox_iframe(image_tag('add-icon.png'), 'tbtrialsite/new', array('pop' => '1'), array(), array('width' => '500', 'height' => '500')) ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['id_trialenvironmenttype']->renderLabel('Trial environment type') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_trialenvironmenttype']->renderError() ?>
        </div>
        <?php echo $form['id_trialenvironmenttype']->render() ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['trialenvironmentname']->renderLabel('Trial environment name') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['trialenvironmentname']->renderError() ?>
        </div>
        <?php echo $form['trialenvironmentname']->render() ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['finanulatitude']->renderLabel('Latitude') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['finanulatitude']->renderError() ?>
        </div>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Latitude of site. Degree (2 digits) minutes (2 digits), and seconds (2 digits) followed by N (North) or S (South) (e.g. 103020S).
        </div>
        <?php echo $form['finanulatitude']->render() ?>
            <br>
            <b>or</b>
            <div class="help">
                <span class="ui-icon ui-icon-help floatleft"></span>
                Latitude of site. Decimal degrees (e.g. -10.505556).
            </div>
        <?php echo $form['finanulatitudedecimal']->render() ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['finanulongitude']->renderLabel('Longitude') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['finanulongitude']->renderError() ?>
        </div>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Longitude of site. Degree (3 digits), minutes (2 digits), and seconds (2 digits) followed by E (East) or W (West) (e.g. 0762510W).
        </div>
        <?php echo $form['finanulongitude']->render() ?>
            <br>
            <b>or</b>
            <div class="help">
                <span class="ui-icon ui-icon-help floatleft"></span>
                Longitude of site. Decimal degrees (e.g. 76.419444).
            </div>
        <?php echo $form['finanulongitudedecimal']->render() ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['finanualtitude']->renderLabel('Altitude') ?>
        </div>
        <div class="help">
            <span class="ui-icon ui-icon-help floatleft"></span>
            Elevation of site expressed in meters above sea level. Negative values are allowed (e.g. -1500).
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['finanualtitude']->renderError() ?>
        </div>
        <?php echo $form['finanualtitude']->render() ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['finanuph']->renderLabel('Ph') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['finanuph']->renderError() ?>
        </div>
        <?php echo $form['finanuph']->render() ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['id_soil']->renderLabel('Soil texture') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_soil']->renderError() ?>
        </div>
        <?php echo $form['id_soil']->render() ?>
        </div>

        <div class="sf_admin_form_row sf_admin_foreignkey">
            <div class="label ui-helper-clearfix">
            <?php echo $form['id_taxonomyfao']->renderLabel('Taxonomy FAO') ?>
        </div>
        <div class="label ui-state-error-text">
            <?php echo $form['id_taxonomyfao']->renderError() ?>
        </div>
        <?php echo $form['id_taxonomyfao']->render() ?>
    </div>
</div>