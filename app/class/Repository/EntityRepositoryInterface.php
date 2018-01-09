<?php
namespace TaskManager\Repository;

use TaskManager\Model\EntityInterface;

interface EntityRepositoryInterface
{
    public function findOneBy($params);
    public function findBy($params, $orderBy, $orderMethod);
    public function findAll($sort);
    public function remove($id);
    public function persist(EntityInterface $entity);
}