<?php

namespace Tests\Database\QueryBuilder;

use TaskManager\Database\QueryBuilder\QueryBuilder;

class InsertQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testInsertQueryResultShouldReturnFalse(){
        $insert = QueryBuilder::insert()->getQuery();
        $this->assertFalse($insert);
        $insert = QueryBuilder::insert()->into('users')->getQuery();
        $this->assertFalse($insert);
        $insert = QueryBuilder::insert()->params(['id'=>5])->getQuery();
        $this->assertFalse($insert);
    }

    public function testInsertQueryResultShouldReturnInsertQueryInstance(){
        $insert = QueryBuilder::insert();
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\InsertQuery', $insert);
        $insert = QueryBuilder::insert()->into('users');
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\InsertQuery', $insert);
        $insert = QueryBuilder::insert()->params(['id'=>5]);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\InsertQuery', $insert);
    }

    public function testInsertQueryResultShouldReturnQueryString(){
        $insert = QueryBuilder::insert()->into('users')->params(['id'=>5])->getQuery();
        $this->assertSame("INSERT INTO `users` (`id`) VALUES (:id)", $insert);
        $insert = QueryBuilder::insert()->into('users')->params(['id'=>5, 'name'=>'Emily'])->getQuery();
        $this->assertSame("INSERT INTO `users` (`id`, `name`) VALUES (:id, :name)", $insert);
    }
}

