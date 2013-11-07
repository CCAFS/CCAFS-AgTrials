<?php use_helper('I18N', 'Date') ?>
<?php include_partial('tbvariety/assets') ?>
<div id="sf_admin_container">
    <div id="sf_admin_header">
        <?php include_partial('tbvariety/list_header', array('pager' => $pager)) ?>
    </div>

    <div id="sf_admin_bar ui-helper-hidden" style="display:none">
        <?php include_partial('tbvariety/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
    <div id="sf_admin_content">
        <div class="sf_admin_actions_block floatleft">
            <div id="sf_admin_actions_menu" class="ui-helper-hidden fg-menu fg-menu-has-icons">
                <ul class="sf_admin_actions" id="sf_admin_actions_menu_list">
                    <?php include_partial('tbvariety/list_actions', array('helper' => $helper)) ?>
                </ul>
            </div>
        </div>

        <!-- INICIO: AQUI SE CARGA Y SE MUESTRA LA LISTA DE VARIEDADES-->
        <?php
            $user = sfContext::getInstance()->getUser();
            $session_vari = $user->getAttribute('variety');
            if (count($session_vari) > 0) {
        ?>
                <br>
                <div id="listvariety" style="width:550px; height:68px; overflow: scroll; font-size: 12px; font-weight:bold; color: #2E6E9E; background-color: #EAF4FD;">
                    <?php
                        if (is_array($session_vari)) {
                            for ($cont = 0; $cont < count($session_vari); $cont++) {
                                $Variety = Doctrine::getTable('TbVariety')->findOneByIdVariety($session_vari[$cont]);
                                echo $Variety->getVrtname();
                                if ($cont + 1 < count($session_vari)) {
                                    echo ', ';
                                }
                            }
                        }
                    ?>
                </div>
        <?php } ?>

        <?php include_partial('tbvariety/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper, 'hasFilters' => $hasFilters)) ?>
        <ul class="sf_admin_actions"><?php include_partial('tbvariety/list_batch_actions', array('helper' => $helper)) ?></ul>
     </div>
    <div id="sf_admin_footer">
        <?php include_partial('tbvariety/list_footer', array('pager' => $pager)) ?>
    </div>
    <?php include_partial('tbvariety/themeswitcher') ?>
</div>