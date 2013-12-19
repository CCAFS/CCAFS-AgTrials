<?php


class TbTrialvarietyLogTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TbTrialvarietyLog');
    }
}