<?php
namespace TaskManager\Repository;

use TaskManager\Database\Database;
use TaskManager\Model\EntityInterface;

class EntityRepository implements EntityRepositoryInterface
{
    private $db;
    private $table;
    private $fullClassName;

    public function __construct($db, $class, $table)
    {
        $this->fullClassName = $class;
        $this->table = $table;
        $this->db = $db;
    }

    public function findOneBy($params = [])
    {
        return $this->db->row($this->table, $this->fullClassName, $params);
    }

    public function findBy($params, $orderBy = [], $orderMethod = null)
    {
        return $this->db->column($this->table, $this->fullClassName, $params, $orderBy, $orderMethod);
    }

    public function findAll($sort)
    {
        return $this->db->column($this->table, $this->fullClassName, $sort);
    }

    public function remove($id)
    {
        return $this->db->remove($this->table, $id);
    }

    public function persist(EntityInterface $entity)
    {
        if ($entity->getId()) {
            $this->db->update($entity);
        }else{
            $this->db->insert($entity);
        }
    }
}