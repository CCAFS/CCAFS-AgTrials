<?php


class TbMetadataattributeTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TbMetadataattribute');
    }
}