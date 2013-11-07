<?php


class TbTrialvariablesmeasuredLogTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TbTrialvariablesmeasuredLog');
    }
}