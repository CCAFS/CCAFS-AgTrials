<?php

class sfWidgetFormPopUp extends sfWidgetFormInput {

    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        $display = link_to('New Location', 'tblocation/new',array('popup'=>array('popupWindow', 'status=no,location=yes,resizable=no,width=610,height=400,left=320,top=0')));
        return $display;
    }

}