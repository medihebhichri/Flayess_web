<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    /**
     * Find categories by subfield.
     *
     * @param string $subfield
     * @return Categories[]
     */
    public function findBySubfield(string $subfield): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.subfield = :subfield')
            ->setParameter('subfield', $subfield)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find categories by type of funding.
     *
     * @param string|null $typeOfFunding
     * @return Categories[]
     */
    public function findByTypeOfFunding(?string $typeOfFunding): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.typeOfFunding = :typeOfFunding')
            ->setParameter('typeOfFunding', $typeOfFunding)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find categories with a specific profitability index range.
     *
     * @param string $minIndex
     * @param string $maxIndex
     * @return Categories[]
     */
    public function findByProfitabilityIndexRange(string $minIndex, string $maxIndex): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.profitabilityIndex BETWEEN :minIndex AND :maxIndex')
            ->setParameter('minIndex', $minIndex)
            ->setParameter('maxIndex', $maxIndex)
            ->getQuery()
            ->getResult();
    }
    public function save(Categories $category): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($category);
        $entityManager->flush();
    }
    
    public function remove(Categories $category, bool $flush = true): void
{
    $this->_em->remove($category);
    if ($flush) {
        $this->_em->flush();
    }
}

}
