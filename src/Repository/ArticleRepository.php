<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;


class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[]
    //  */

    public function findAllPublishedOrderedByNewest()
    {
        $this->createQueryBuilder('a')
            ->addCriteria(CommentRepository::createNonDeletedCriteria());

        return $this->addIsPublishedQueryBuilder()
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    private function addIsPublishedQueryBuilder(QueryBuilder $qb = null) {
        return $this->getOrCreateQueryBuilder($qb)
            ->andWhere('a.publishedAt IS NOT NULL');
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null) {
        return $qb ?: $this->createQueryBuilder('a');
    }

}
