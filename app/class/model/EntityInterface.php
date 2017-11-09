<?php

namespace TaskManager\Model;

interface EntityInterface
{
    public static function getTableName();
    public static function getPrimaryKey();
    public function getObjectVars();
    public function isValid();
    public function getValidationErrors();
}