<?php
// src/Repository/ProjectsRepository.php
namespace App\Repository;


use App\Entity\Projects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class ProjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projects::class);
    }
    /**
     * Dynamic method to find projects based on filters and search term.
     * 
     * @param string|null $searchTerm
     * @param int|null $categoryId
     * @param string|null $status
     * @param string|null $sortOption
     * @return Projects[]
     */

    /**
     * Find all projects ordered by name.
     *
     * @return Projects[] Returns an array of Projects objects
     */
    
    public function findAllOrderedByName(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    

    /** 
     * Find projects by category ID.
     *
     * @param int $categoryId
     * @return Projects[] Returns an array of Projects objects
     */
    public function findByCategoryId(int $categoryId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find projects containing given tag.
     *
     * @param string $tag
     * @return Projects[] Returns an array of Projects objects
     */
    public function findByTag(string $tag): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere(':tag MEMBER OF p.tags')
            ->setParameter('tag', $tag)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find projects with pagination.
     *
     * @param int $page
     * @param int $limit
     * @return Projects[] Returns an array of Projects objects
     */
    public function findWithPagination(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;

        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
    public function findByFilters(?string $searchTerm, ?int $categoryId, ?string $status, ?string $sortOption, ?int $uniqueSellingPointsMax = null): array
    {
        $qb = $this->createQueryBuilder('p');
    
        if ($searchTerm) {
            $qb->andWhere('p.name LIKE :searchTerm OR p.description LIKE :searchTerm')
               ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    
        if ($categoryId !== null) {
            $qb->andWhere('p.category = :categoryId')
               ->setParameter('categoryId', $categoryId);
        }
    
        if ($status !== null) {
            $qb->andWhere('p.status = :status')
               ->setParameter('status', $status);
        }
    
        // Filter by unique selling points if provided
        if (null !== $uniqueSellingPointsMax) {
            $qb->andWhere('p.uniqueSellingPoints <= :uniqueSellingPointsMax')
               ->setParameter('uniqueSellingPointsMax', $uniqueSellingPointsMax);
        }
    
        // Apply sorting options
        $this->addSortOption($qb, $sortOption);
    
        // Execute the query and return the results
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Helper method to add sorting to the query.
     * 
     * @param QueryBuilder $qb
     * @param string|null $sortOption
     */
    private function addSortOption(QueryBuilder $qb, ?string $sortOption): void
    {
        switch ($sortOption) {
            case 'name':
                $qb->orderBy('p.name', 'ASC');
                break;
            case 'date':
                // Assuming there's a 'date' field in your Projects entity
                $qb->orderBy('p.date', 'ASC');
                break;
            case 'popularity':
                // Assuming there's a 'popularity' measure you can sort by
                $qb->orderBy('p.popularity', 'DESC');
                break;
            default:
                // Default sorting by project ID or any default field
                $qb->orderBy('p.id', 'ASC');
                break;
        }
    }

    // Add more custom query methods here if needed
}
