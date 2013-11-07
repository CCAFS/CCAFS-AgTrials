<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="sf_admin_form">
    <?php
    $count = 0;
    foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields):
        $count++;
    endforeach;
    ?>

    <div id="sf_admin_form_tab_menu">
        <?php if ($count > 1): ?>
            <ul>
            <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields): ?>
            <?php $count++ ?>
                <li><a href="#sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>"><?php echo __($fieldset, array(), 'messages') ?></a></li>
            <?php endforeach; ?>
            </ul>
        <?php endif ?>

        <?php foreach ($configuration->getFormFields($form, 'show') as $fieldset => $fields): ?>
                    <div id="sf_fieldset_<?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?>">
                        <div class="sf_admin_form_row">
                            <label>Username:</label>
                            <values><?php echo $form->getObject()->get('username'); ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label>First name:</label>
                            <values><?php echo $form->getObject()->get('first_name'); ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label>Last name:</label>
                            <values><?php echo $form->getObject()->get('last_name'); ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label> Email address:</label>
                            <values><?php echo $form->getObject()->get('email_address'); ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label>Created:</label>
                            <values><?php echo $form->getObject()->get('created_at'); ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label>Last login:</label>
                            <values><?php echo $form->getObject()->get('last_login'); ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label>Active:</label>
                            <values><?php echo $form->getObject()->get('is_active'); ?></values>
                        </div>
            <?php
                    $SfGuardUserInformation = Doctrine::getTable('SfGuardUserInformation')->findOneByUserId($form->getObject()->get('id'));
                    if (count($SfGuardUserInformation) > 1) {
            ?>

                        <div class="sf_admin_form_row">
                            <label>Permissions:</label>
                            <values><?php echo GetPermissionsUser($form->getObject()->get('id')) ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label>Groups:</label>
                            <values><?php echo GetGroupsUser($form->getObject()->get('id')); ?></values>
                        </div>
                        <div class="sf_admin_form_row">
                            <label>Institution:</label>
                            <values>
                    <?php
                        if ($SfGuardUserInformation->getIdInstitution() != '') {
                            $TbInstitution = Doctrine::getTable('TbInstitution')->findOneByIdInstitution($SfGuardUserInformation->getIdInstitution());
                            echo $TbInstitution->getInsname();
                        }
                    ?>
                    </values>
                </div>
                <div class="sf_admin_form_row">
                    <label>Country:</label>
                    <values>
                    <?php
                        if ($SfGuardUserInformation->getIdCountry() != '') {
                            $TbCountry = Doctrine::getTable('TbCountry')->findOneByIdCountry($SfGuardUserInformation->getIdCountry());
                            echo $TbCountry->getCntname();
                        }
                    ?>
                    </values>
                </div>
                <div class="sf_admin_form_row">
                    <label>City:</label>
                    <values><?php echo $SfGuardUserInformation->getCity(); ?></values>
                </div>
                <div class="sf_admin_form_row">
                    <label>State:</label>
                    <values><?php echo $SfGuardUserInformation->getState(); ?></values>
                </div>
                <div class="sf_admin_form_row">
                    <label>Address:</label>
                    <values><?php echo $SfGuardUserInformation->getAddress(); ?></values>
                </div>
                <div class="sf_admin_form_row">
                    <label>Telephone:</label>
                    <values><?php echo $SfGuardUserInformation->getTelephone(); ?></values>
                </div>
                <div class="sf_admin_form_row">
                    <label>Motivation:</label>
                    <values><?php echo $SfGuardUserInformation->getMotivation(); ?></values>
                </div>
                <div class="sf_admin_form_row">
                    <label>Visits:</label>
                    <values><?php echo $SfGuardUserInformation->getVisits(); ?></values>
                </div>
            <?php } ?>
                </div>
        <?php endforeach; ?>
    </div>
</div>
