<?php use_helper('I18N', 'Date') ?>
<?php include_partial('tbvariablesmeasured/assets') ?>
<div id="sf_admin_container">
    <div id="sf_admin_header">
        <?php include_partial('tbvariablesmeasured/list_header', array('pager' => $pager)) ?>
    </div>

    <div id="sf_admin_bar ui-helper-hidden" style="display:none">
        <?php include_partial('tbvariablesmeasured/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_actions_block floatleft">
            <div id="sf_admin_actions_menu" class="ui-helper-hidden fg-menu fg-menu-has-icons">
                <ul class="sf_admin_actions" id="sf_admin_actions_menu_list">
                    <?php include_partial('tbvariablesmeasured/list_actions', array('helper' => $helper)) ?>
                </ul>
            </div>
        </div>

        <!-- INICIO: AQUI SE CARGA Y SE MUESTRA LA LISTA DE Variables Measured-->
        <?php
            $user = sfContext::getInstance()->getUser();
            $session_variablesmeasured = $user->getAttribute('variablesmeasured');
            if (count($session_variablesmeasured) > 0) {
        ?>
                <br>
                <div id="listvariablesmeasured" style="width:550px; height:68px; overflow: scroll; font-size: 12px; font-weight:bold; color: #2E6E9E; background-color: #EAF4FD;">
                    <?php
                        if (is_array($session_variablesmeasured)) {
                            for ($cont = 0; $cont < count($session_variablesmeasured); $cont++) {
                                $variablesmeasured = Doctrine::getTable('TbVariablesmeasured')->findOneByIdVariablesmeasured($session_variablesmeasured[$cont]);
                                echo $variablesmeasured->getVrmsname();
                                if ($cont + 1 < count($session_variablesmeasured)) {
                                    echo ', ';
                                }
                            }
                        }
                    ?>
                </div>
        <?php } ?>

        <?php include_partial('tbvariablesmeasured/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'hasFilters' => $hasFilters)) ?>
        <ul class="sf_admin_actions"><?php include_partial('tbvariablesmeasured/list_batch_actions', array('helper' => $helper)) ?></ul>
     </div>
    <div id="sf_admin_footer">
        <?php include_partial('tbvariablesmeasured/list_footer', array('pager' => $pager)) ?>
    </div>
    <?php include_partial('tbvariablesmeasured/themeswitcher') ?>
</div>