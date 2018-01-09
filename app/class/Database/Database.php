<?php
namespace TaskManager\Database;

use TaskManager\Database\QueryBuilder\QueryBuilder;
use TaskManager\Model\EntityInterface;
use PDO;
use PDOException;

class Database
{
    private $pdo;
    private $stmt;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try{
            $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS,
                array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ));
        }catch(PDOException $e){
            print "Database connection error: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function row($table, $class, $params = [])
    {
        $query = QueryBuilder::select()->from($table)->where($params)->limit(1)->getQuery();
        $this->init($query, $class, $params);
        $result = $this->stmt->fetch();
        $this->stmt->closeCursor();
        return $result;
    }

    public function bindArrayValue($params = [])
    {
        foreach($params as $key => $value){
            $this->bind($key, $value);
        }
    }

    public function bind($name, $value)
    {
        $this->stmt->bindValue(":".$name, $value);
    }

    public function column($table, $class, $params = [], $orderBy = [], $orderMethod=null)
    {
        $query = QueryBuilder::select()->from($table)->where($params)->orderBy($orderBy, $orderMethod)->getQuery();
        $this->init($query, $class, $params);
        $result = $this->stmt->fetchAll();
        $this->stmt->closeCursor();
        return $result;
    }

    private function init($sql, $class, $params)
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $class);
        return $this->stmt->execute($params);
    }

    public function insert(EntityInterface $entity)
    {
        $table = $entity::getTableName();
        $columns = $entity->getObjectVars();
        $query = QueryBuilder::insert()->into($table)->params($columns)->getQuery();
        $params = $entity->getObjectVars();
        $this->stmt = $this->pdo->prepare($query);
        return $this->stmt->execute($params);
    }

    public function update(EntityInterface $entity)
    {
        $table = $entity::getTableName();
        $params = $entity->getObjectVars();
        $id = $entity::getPrimaryKey();
        $query = QueryBuilder::update()->table($table)->set($params)->where(['id' => $id])->limit(1)->getQuery();
        $params = $entity->getObjectVars();
        $params['id'] = $entity->getId();
        $this->stmt = $this->pdo->prepare($query);
        return $this->stmt->execute($params);
    }

    public function remove($table, $id)
    {
        $query = QueryBuilder::delete()->from($table)->where(['id' => $id])->getQuery();
        $params['id'] = $id;
        $this->stmt = $this->pdo->prepare($query);
        return $this->stmt->execute($params);
    }
}