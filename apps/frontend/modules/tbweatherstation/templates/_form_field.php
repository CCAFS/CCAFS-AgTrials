<?php if ($field->isPartial()): ?>
    <?php include_partial('tbweatherstation/' . $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('tbweatherstation', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
    <div class="<?php echo $class ?><?php $form[$name]->hasError() and print ' ui-state-error ui-corner-all' ?>">
        <div class="label ui-helper-clearfix">
            <?php echo $form[$name]->renderLabel($label) ?>

            <?php if ($help || $help = $form[$name]->renderHelp()): ?>
                <div class="help">
                    <span class="ui-icon ui-icon-help floatleft"></span>
                    <?php echo __(strip_tags($help), array(), 'messages') ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        if ($name == 'wtstrestricted') {
            echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes);
            $st_display = "none";
            if ($form->getObject()->get('wtstrestricted') == 'YES')
                $st_display = "block";
            ?>
            <div id="tb_weatherstation_userpermission"  style="display: <?php echo $st_display; ?>">
                <div class="sf_admin_form_row sf_admin_text">
                    <div class="label ui-helper-clearfix">
                        <label for="tb_weatherstation_wtstrestricted">Users with permission</label>
                    </div>
                    <span id="add_listuser">
                        <?php
                        $id_weatherstation = $form->getObject()->get('id_weatherstation');
                        $user = sfContext::getInstance()->getUser();
                        $session_user_name = $user->getAttribute('user_name');
                        $list_user = "";
                        if (isset($session_user_name)) {
                            foreach ($session_user_name as $username) {
                                $list_user .= $username . ", ";
                            }
                            $list_user = substr($list_user, 0, strlen($list_user) - 2);
                        }
                        echo thickbox_iframe("<textarea id='tb_weatherstation_user' name='tb_weatherstation_user' readonly='readonly' cols='58' rows='5'>$list_user</textarea> " . image_tag('user.jpg'), '@weatherstationuserpermission', array('pop' => '1'))
                        ?>
                    </span>
                </div>
            </div>
            <?php
        } else {
            echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes);
        }
        ?>
        <?php if ($form[$name]->hasError()): ?>
            <div class="errors">
                <span class="ui-icon ui-icon-alert floatleft"></span>
                <?php echo $form[$name]->renderError() ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
