<?php
namespace TaskManager\Database\QueryBuilder;

class InsertQuery extends AbstractQuery
{
    private $values;
    private $columns;

    public function __construct()
    {
        $this->queryType = "INSERT ";
        $this->table = '';
        $this->columns = [];
    }

    public function into($table)
    {
        $this->table = $this->addQuotes($table);
        return $this;
    }

    public function params($params = [])
    {
        $params  = array_keys($params);
        $columns = [];
        $values  = [];
        foreach ($params as $param){
            $columns[] = $this->addQuotes($param);
            $values[]  = ":".$param;
        }
        $this->columns = implode(', ', $columns);
        $this->values  = implode(', ', $values);
        return $this;
    }

    public function getQuery()
    {
        return $this->prepareQuery();
    }

    private function prepareQuery()
    {
        if(!$this->getTable() || !$this->getColumns() || !$this->getValues()){
            return false;
        }
        $query  = $this->queryType."INTO ".$this->getTable();
        $query .= " (".$this->getColumns().")";
        $query .= " VALUES (".$this->getValues().")";
        return $query;
    }

    private function getTable()
    {
        return empty($this->table) ? false : $this->table;
    }

    private function getColumns()
    {
        return empty($this->columns) ? false : $this->columns;
    }

    private function getValues()
    {
        return empty($this->values) ? false : $this->values;
    }
}