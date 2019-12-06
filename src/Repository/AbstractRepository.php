<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class AbstractRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata($this->entityClass()));
    }

    abstract protected function entityClass(): string;

    public function persist($entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    public function save($entity)
    {
        $this->persist($entity);
        $this->flush();

        return $entity;
    }
}
