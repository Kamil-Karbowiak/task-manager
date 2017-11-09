<?php
namespace TaskManager\Pagination;

class ArrayAdapter
{
    private $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function getArray()
    {
        return $this->items;
    }

    public function getSlice($start, $length)
    {
        return array_slice($this->items, $start, $length);
    }

    public function getItemsCount()
    {
        return count($this->items);
    }

    public function isEmpty()
    {
        return $this->getItemsCount() < 1 ? true : false;
    }
}