<?php
namespace TaskManager\Database\QueryBuilder;

class UpdateQuery extends AbstractQuery
{
    private $params;
    private $conditions;
    private $limit;

    public function __construct()
    {
        $this->queryType  = 'UPDATE ';
        $this->table      = '';
        $this->params     = '';
        $this->conditions = '';
        $this->limit      = '';
    }

    public function table($table)
    {
        $this->table = $this->addQuotes($table);
        return $this;
    }

    public function set($params = [])
    {
        $params = $this->getParamsAndPlaceholdersPairsArray($params);
        $this->params = implode(', ', $params);
        return $this;
    }

    public function where($fields = [])
    {
        $this->conditions = $this->generateConditionsString($fields);
        return $this;
    }

    public function limit($count = 1)
    {
        $this->limit = $count;
        return $this;
    }

    public function getQuery()
    {
        return $this->prepareQuery();
    }

    private function prepareQuery()
    {
        if(!$this->getTable() || !$this->getParams() || !$this->getConditions()){
            return false;
        }
        $query  = $this->getTable();
        $query .= $this->getParams();
        $query .= $this->getConditions();
        if($this->getLimit()){
            $query .= $this->getLimit();
        }
        return $query;
    }

    private function getTable()
    {
        return empty($this->table) ? false : $this->queryType.$this->table;
    }

    private function getParams()
    {
        return empty($this->params) ? false : " SET ".$this->params;
    }

    private function getConditions()
    {
        return empty($this->conditions) ? false : " WHERE ".$this->conditions;
    }

    private function getLimit()
    {
        return empty($this->limit) ? false : " LIMIT ".$this->limit;
    }
}