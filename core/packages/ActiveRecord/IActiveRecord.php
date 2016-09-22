<?php

namespace core\packages\ActiveRecord;

/**
 * @author farZa
 */
interface IActiveRecord
{
    public function findOne(array $condition = []):IActiveRecord;
    public function findAll(array $condition = []):array;
    public function save():bool;
    public function remove():bool;
}