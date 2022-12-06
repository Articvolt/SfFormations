<?php

namespace App\Repository;

use App\Entity\SessionFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SessionFormation>
 *
 * @method SessionFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionFormation[]    findAll()
 * @method SessionFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionFormation::class);
    }

    public function add(SessionFormation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SessionFormation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SessionFormation[] Returns an array of SessionFormation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SessionFormation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// FONCTION QUI RECUPERE LES SESSIONS AUX DATES ANTERIEURES
    public function showSessionPast() {

        //date actuelle
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
                    ->andWhere('s.dateFin < :val')
                    ->setParameter('val' , $now)
                    ->orderBy('s.dateDebut', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

// FONCTION QUI RECUPERE LES SESSIONS AUX DATES ACTUELLES
    public function showSessionNow() {

        //date actuelle
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
                    ->andWhere('s.dateDebut <= :val ' , ':val < s.dateFin ')
                    ->setParameter('val' , $now)
                    ->orderBy('s.dateDebut', 'ASC')
                    ->getQuery()
                    ->getResult();
    }


// FONCTION QUI RECUPERE LES SESSIONS AUX DATES POSTERIEURES
    public function showSessionPost() {

        //date actuelle
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
                    // quand la date de debut est au dessus de la date actuelle
                    ->andWhere('s.dateDebut > :val')
                    //execute
                    ->setParameter('val' , $now)
                    ->orderBy('s.dateDebut', 'ASC')
                    ->getQuery()
                    ->getResult();
    }


// FONCTION QUI AFFICHE LES STAGIAIRES NON INSCRITS 

    public function findNonInscrits($session_id) {
        $em = $this->getEntityManager();
        $nonInscrit = $em->createQueryBuilder();

        // Requête SQL
        $sql = $nonInscrit;
        $sql->select('s')
           ->from('App\Entity\Stagiaire','s')
           ->leftJoin('s.sessions', 'se')
           ->where('se.id = :id');

        // Interaction avec l'entité Stagiaire
        $nonInscrit = $em->createQueryBuilder();
        $nonInscrit->select('st')
            ->from('App\Entity\Stagiaire', 'st')
            ->where($nonInscrit->expr()->notIn('st.id', $sql->getDQL()))
            ->setParameter('id', $session_id)
            ->orderBy('st.nom');

        $query = $nonInscrit->getQuery();
        return $query->getResult();

    }
}
