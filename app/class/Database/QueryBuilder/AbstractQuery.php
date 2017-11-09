<?php
namespace TaskManager\Database\QueryBuilder;

abstract class AbstractQuery
{
    protected $queryType;
    protected $table;

    protected function addQuotes($string)
    {
        return '`'.$string.'`';
    }

    protected function addQuotesToMany($strings)
    {
        foreach ($strings as &$string) {
            $string = $this->addQuotes($string);
        }
        return $strings;
    }

    protected function generateConditionsString($fields)
    {
        return implode(" AND ", $this->getParamsAndPlaceholdersPairsArray($fields));
    }

    protected function getParamsAndPlaceholdersPairsArray($params)
    {
        $params = array_keys($params);
        foreach ($params as &$param) {
            $param = $this->addQuotes($param)." = :".$param;
        }
        return $params;
    }

    protected function generateColumnsString($columns)
    {
        foreach ($columns as &$column) {
            $column = $this->addQuotes($column);
        }
        return implode(', ', $columns);
    }
}