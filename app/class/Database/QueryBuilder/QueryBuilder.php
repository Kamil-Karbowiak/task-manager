<?php
namespace TaskManager\Database\QueryBuilder;

class QueryBuilder
{
    public static function select()
    {
        return new SelectQuery();
    }

    public static function insert()
    {
        return new InsertQuery();
    }

    public static function update()
    {
        return new UpdateQuery();
    }

    public static function delete()
    {
        return new DeleteQuery();
    }
}