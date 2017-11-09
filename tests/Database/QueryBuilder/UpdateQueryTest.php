<?php

namespace Tests\Database\QueryBuilder;

use Mvc2\Database\QueryBuilder\QueryBuilder;

class UpdateQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testUpdateQueryResultShouldReturnFalse(){
        $update = QueryBuilder::update()->getQuery();
        $this->assertFalse($update);
        $update = QueryBuilder::update()->table('users')->getQuery();
        $this->assertFalse($update);
        $update = QueryBuilder::update()->where(['id'=>5])->getQuery();
        $this->assertFalse($update);
        $update = QueryBuilder::update()->set(['id'=>5])->getQuery();
        $this->assertFalse($update);
    }

    public function testUpdateQueryResultShouldReturnUpdateQueryInstance(){
        $update = QueryBuilder::update();
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\UpdateQuery', $update);
        $update = QueryBuilder::update()->table('users');
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\UpdateQuery', $update);
        $update = QueryBuilder::update()->set(['id'=>5]);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\UpdateQuery', $update);
        $update = QueryBuilder::update()->limit(5);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\UpdateQuery', $update);
        $update = QueryBuilder::update()->where(['id'=>5]);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\UpdateQuery', $update);
    }

    public function testUpdateQueryResultShouldReturnQueryString(){
        $update = QueryBuilder::update()
            ->table('users')
            ->set(['id'=>5])
            ->where(['name'=>'Emily'])
            ->getQuery();
        $this->assertSame("UPDATE `users` SET `id` = :id WHERE `name` = :name", $update);
        $update = QueryBuilder::update()
            ->table('users')
            ->set(['id'=>5])
            ->where(['name'=>'Emily'])
            ->limit()
            ->getQuery();
        $this->assertSame("UPDATE `users` SET `id` = :id WHERE `name` = :name LIMIT 1", $update);
        $update = QueryBuilder::update()
            ->table('tasks')
            ->set(['name'=>'car washing', 'status' => 'done'])
            ->where(['status'=>'todo', 'priority'=>'low'])
            ->limit(2)
            ->getQuery();
        $this->assertSame("UPDATE `tasks` SET `name` = :name, `status` = :status WHERE `status` = :status AND `priority` = :priority LIMIT 2", $update);
    }
}