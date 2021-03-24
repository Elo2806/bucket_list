<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function findWishList(int $page = 1): ?array
    {
    /**    //Le DQL ressemble bcp au SQL mais fait des requêtes à nos entités plutôt qu'à des tables
        //On fait un alias w de l'entité Wish. On veut récup la totalité (avec les propriétés)
        $dql = "SELECT w 
                FROM App\Entity\Wish w
                WHERE w.is_published = true
                AND w.likes > :likesCount 
                ORDER BY w.date_created DESC";

        //On récupère l'entité Manager
        $entityManager = $this->getEntityManager();
        //On crée le requête Doctrine
        $query = $entityManager->createQuery($dql);

        //Limiter le nombre de résultats
        $query->setMaxResults(100);

        //Remplacer le paramètre mis dans la requête
        $query->setParameter(':likesCount', 100);

        //On éxécute le requête et on récup les résultats
        $results = $query->getResult();

*/

        //En query builder
        $queryBuilder = $this->createQueryBuilder('W');

        //On ajoute des clauses WHERE
        $queryBuilder
            //->andWhere('W.author = Jack') On peut mettre x WHERE à la suite
            ->andWhere('W.is_published = true');


        //On peut ajouter des morceaux de requête en fonction de variables php par exemple
        $filterLikes = true; //Pour simuler une case cochée par le user par exemple
        if ($filterLikes){
            $queryBuilder->andWhere('W.likes > :likesCount');
            //Remplacer le paramètre
            $queryBuilder->setParameter(':likesCount', 100);
        }

        //modifie le qB pour sélectionner le count
        $queryBuilder->select("COUNT(W)");
        //On éxécute...
        $countQuery = $queryBuilder->getQuery();
        //...on veut récupérer une seule donnée
        $totalResultCount = $countQuery->getSingleScalarResult();

        $queryBuilder->select("W");
        //Notre offset : à partir de quel élément on récupère
        //page1 : offset = 0
        //page2 : offset = 20
        //page3 : offset = 40
        $offset = ($page - 1) * 20;
        $queryBuilder->setFirstResult($offset);

        //Limiter le nombre de résultats
        $queryBuilder->setMaxResults(20);

        //On tri
        $queryBuilder->addOrderBy('W.date_created', 'DESC');

        //On récup l'objet Query de Doctrine
        $query = $queryBuilder->getQuery();

        //On éxécute le requête et on récup les résultats
        $results = $query->getResult();

        return ['result'=>$results, 'totalResultCount'=>$totalResultCount];
    }



    // /**
    //  * @return Wish[] Returns an array of Wish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wish
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
