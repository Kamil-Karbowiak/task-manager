<?php
namespace TaskManager\Database\QueryBuilder;

class DeleteQuery extends AbstractQuery
{
    private $conditions;
    private $limit;

    public function __construct()
    {
        $this->queryType  = "DELETE ";
        $this->table      = '';
        $this->conditions = '';
        $this->limit      = '';
    }

    public function from($table)
    {
        $this->table = $this->addQuotes($table);
        return $this;
    }

    public function where($fields = [])
    {
        $this->conditions = $this->generateConditionsString($fields);
        return $this;
    }

    public function limit($limit = 1)
    {
        $this->limit = $limit;
        return $this;
    }

    public function getQuery()
    {
        return $this->prepareQuery();
    }

    private function prepareQuery()
    {
        if(!$this->getTable() || !$this->getConditions()){
            return false;
        }
        $query = $this->queryType."FROM ".$this->getTable();
        $query .= " WHERE ".$this->getConditions();
        if($this->getLimit()){
            $query .= " LIMIT ".$this->limit;
        }
        return $query;
    }

    private function getTable()
    {
        return empty($this->table) ? false : $this->table;
    }

    private function getConditions()
    {
        return empty($this->conditions) ? false : $this->conditions;
    }

    private function getLimit()
    {
        return empty($this->limit) ? false : $this->limit;
    }
}