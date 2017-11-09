<?php

namespace Tests\Database\QueryBuilder;

use Mvc2\Database\QueryBuilder\QueryBuilder;

class DeleteQueryTest extends \PHPUnit\Framework\TestCase
{
    public function testDeleteQueryResultShouldReturnFalse(){
        $delete = QueryBuilder::delete()->getQuery();
        $this->assertFalse($delete);
        $delete = QueryBuilder::delete()->where(['id'=>5])->getQuery();
        $this->assertFalse($delete);
        $delete = QueryBuilder::delete()->limit(5)->getQuery();
        $this->assertFalse($delete);
        $delete = QueryBuilder::delete()->from('users')->getQuery();
        $this->assertFalse($delete);
    }

    public function testDeleteQueryResultShouldReturnDeleteQueryInstance(){
        $delete = QueryBuilder::delete();
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\DeleteQuery', $delete);
        $delete = QueryBuilder::delete()->from('users');
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\DeleteQuery', $delete);
        $delete = QueryBuilder::delete()->limit(5);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\DeleteQuery', $delete);
        $delete = QueryBuilder::delete()->where(['id'=>5]);
        $this->assertInstanceOf('Mvc2\Database\QueryBuilder\DeleteQuery', $delete);
    }

    public function testDeleteQueryResultShouldReturnQueryString(){
        $delete = QueryBuilder::delete()
            ->from('users')
            ->where(['id'=>5])
            ->getQuery();
        $this->assertSame("DELETE FROM `users` WHERE `id` = :id", $delete);
        $delete = QueryBuilder::delete()
            ->from('users')
            ->where(['id'=>5, 'name'=>'Emily'])
            ->limit()
            ->getQuery();
        $this->assertSame("DELETE FROM `users` WHERE `id` = :id AND `name` = :name LIMIT 1", $delete);
        $delete = QueryBuilder::delete()
            ->from('users')
            ->where(['id'=>5])
            ->limit(2)
            ->getQuery();
        $this->assertSame("DELETE FROM `users` WHERE `id` = :id LIMIT 2", $delete);
    }
}