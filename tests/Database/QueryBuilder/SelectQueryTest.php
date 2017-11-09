<?php

namespace Tests\Database\QueryBuilder;

use Mvc2\Database\QueryBuilder\QueryBuilder;

class SelectQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testSelectQueryResultShouldReturnFalse(){
        $select = QueryBuilder::select()->getQuery();
        $this->assertFalse($select);
        $select = QueryBuilder::select()->columnsToFetch('id', 'name')->getQuery();
        $this->assertFalse($select);
    }

    public function testSelectQueryResultShouldReturnSelectQueryInstance(){
        $select = QueryBuilder::select();
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\SelectQuery', $select);
        $select = QueryBuilder::select()->from('users');
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\SelectQuery', $select);
        $select = QueryBuilder::select()->columnsToFetch('id')->from('users')->where(['id'=>5]);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\SelectQuery', $select);
        $select = QueryBuilder::select()
            ->columnsToFetch('id')
            ->from('users')
            ->where(['id'=>5])
            ->orderBy(['id', 'name'], 'DESC');
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\SelectQuery', $select);
        $select = QueryBuilder::select()
            ->columnsToFetch('id')
            ->from('users')
            ->where(['id'=>5])
            ->orderBy(['id', 'name'], 'DESC')
            ->limit(5);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\SelectQuery', $select);
    }

    public function testSelectQueryResultShouldReturnQueryString(){
        $select = QueryBuilder::select()->from('users')
            ->where(['id'=>5])
            ->orderBy(['id', 'name'])
            ->limit(2)
            ->getQuery();
        $this->assertSame("SELECT * FROM `users` WHERE `id` = :id ORDER BY `id`, `name` ASC LIMIT 2", $select);
        $select = QueryBuilder::select()
            ->columnsToFetch('id', 'name')
            ->from('users')
            ->where(['id'=>5, 'name'=>'Emily'])
            ->orderBy(['id'], 'DESC')
            ->getQuery();
        $this->assertSame("SELECT `id`, `name` FROM `users` WHERE `id` = :id AND `name` = :name ORDER BY `id` DESC", $select);
        $select = QueryBuilder::select()
            ->from('users')
            ->where(['id'=>5])
            ->getQuery();
        $this->assertSame("SELECT * FROM `users` WHERE `id` = :id", $select);
        $select = QueryBuilder::select()
            ->from('users')
            ->where(['id'=>5])
            ->limit()
            ->getQuery();
        $this->assertSame("SELECT * FROM `users` WHERE `id` = :id LIMIT 1", $select);
    }
}