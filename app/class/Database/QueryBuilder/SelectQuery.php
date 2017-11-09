<?php
namespace TaskManager\Database\QueryBuilder;

class SelectQuery extends AbstractQuery
{
    private $columnsToFetch;
    private $conditions;
    private $order;
    private $limit;

    public function __construct()
    {
        $this->queryType = "SELECT ";
        $this->columnsToFetch = '*';
        $this->table = '';
        $this->conditions = '';
        $this->order = '';
        $this->limit = '';
    }

    public function columnsToFetch(...$columns)
    {
        if (!empty($columns)) {
            $this->setColumns($columns);
        }
        return $this;
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

    public function orderBy($columns, $order = 'ASC')
    {
        $sort = '';
        if (is_array($columns)) {
            foreach ($columns as &$column) {
                $column = $this->addQuotes($column);
            }
            $sort .= implode(', ', $columns);
        }else{
            $sort .= $this->addQuotes($columns);
        }
        $sortingMethod = $order == 'DESC' ? $order : 'ASC';
        $sort .= " ".$sortingMethod;
        $this->order = $sort;
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

    private function setColumns($fields)
    {
        $this->columnsToFetch = $this->generateColumnsString($fields);
        return $this;
    }

    private function prepareQuery()
    {
        if (!$this->getColumns() || !$this->getTable()) {
            return false;
        }
        $query = $this->queryType.$this->getColumns();
        $query .= " FROM ".$this->getTable();
        $query .= " WHERE ".$this->getConditions();
        if ($this->getOrder()) {
            $query .= " ORDER BY ".$this->getOrder();
        }
        if ($this->getLimit()) {
            $query .= " LIMIT ".$this->getLimit();
        }
        return $query;
    }

    private function getColumns()
    {
        return empty($this->columnsToFetch) ? false : $this->columnsToFetch;
    }

    private function getTable()
    {
        return empty($this->table) ? false : $this->table;
    }

    private function getConditions()
    {
        return empty($this->conditions) ? false : $this->conditions;
    }

    private function getOrder()
    {
        return empty($this->order) ? false : $this->order;
    }

    private function getLimit()
    {
        return empty($this->limit) ? false : $this->limit;
    }
}