<?php

namespace App\ReadModel;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityRepository;

class PostReadRepository
{
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function countAll(): int
    {
        return $this->repository
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return Post[]
     */
    public function all(int $offset, int $limit): array
    {
        return $this->repository
            ->createQueryBuilder('p')
            ->select('p')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('p.createDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     * @return Post|object|null
     */
    public function find(int $id): ?Post
    {
        return $this->repository->find($id);
    }
}
