<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Plat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plat[]    findAll()
 * @method Plat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Plat::class);
    }

    // /**
    //  * @return Plat[] Returns an array of Plat objects
    //  */

    public function findPlatById($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT p.*,i.id as idimage,i.url,i.description as descriptionimage,i.type
         FROM plat p JOIN
          images i on i.idplat=p.id
          WHERE p.id = :id AND i.type=0;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll()[0];
    }
    public function findAllPlat(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT p.*,i.url,i.description as descriptionimage,i.type
         FROM plat p JOIN
          images i on i.idplat=p.id
          WHERE p.id = :id AND i.type=0;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(null);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
    public function findRandomPlat($nombre){

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT p.*,i.url,i.description as descriptionimage,i.type
         FROM plat p JOIN
          images i on i.idplat=p.id
          WHERE i.type=0
          ORDER BY RAND() LIMIT 6;
          
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['nombre'=>$nombre]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
    public function findImagesByIdplat($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM images where idplat=:id and type!=0 order by idplat limit 0,5;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
    public function findPlatsByCategorie($categorie,$type): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT p.*,c.nom as categorie,i.url,i.description as descriptionimage,i.type
         FROM plat p 
         JOIN categorieplat 
         ca on ca.idplat=p.id 
         JOIN categorie c ON c.id=ca.idcategorie JOIN
          images i on i.idplat=p.id
          WHERE c.nom = :cat AND i.type=:type;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['cat' => $categorie,'type'=>$type]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }


    public function searchPlat($limit,$offset,$nom,$categorie,$typeimage): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT p.*,c.nom as categorie,i.url,i.description as descriptionimage,i.type
         FROM plat p 
         JOIN categorieplat 
         ca on ca.idplat=p.id 
         JOIN categorie c ON c.id=ca.idcategorie JOIN
          images i on i.idplat=p.id WHERE 1<2 and i.type=:type
        ';
        if($nom!=""){
            $sql=$sql." and( p.nom like '%".$nom."%' or p.descriptioncourte like '%".$nom."%' or p.descriptionlongue like '%".$nom."%' )";
        }
        if($categorie!=""){
            $sql=$sql." and c.nom='".$categorie."'";
        }
        $sql=$sql." order by p.id limit ".$offset.",".$limit;
        $sql=$sql.";";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['type'=>$typeimage]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
    public function NbrsearchPlat($nom,$categorie,$typeimage)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT count(*) as nombre
         FROM plat p 
         JOIN categorieplat 
         ca on ca.idplat=p.id 
         JOIN categorie c ON c.id=ca.idcategorie JOIN
          images i on i.idplat=p.id WHERE 1<2 and i.type=:type
        ';
        if($nom!=""){
            $sql=$sql." and( p.nom like '%".$nom."%' or p.descriptioncourte like '%".$nom."%' or p.descriptionlongue like '%".$nom."%' )";
        }
        if($categorie!=""){
            $sql=$sql." and c.nom='".$categorie."'";
        }
        $sql=$sql.";";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['type'=>$typeimage]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll()[0]['nombre'];
    }

    public function getCategoriesPlat($id):array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT c.id,c.nom from categorie c JOIN categorieplat cp on cp.idcategorie=c.id 
        JOIN plat p ON  p.id=cp.idplat where p.id=:id;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

    }
    public function getPlat($id):array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
        SELECT c.id,c.nom from categorie c JOIN categorieplat cp on cp.idcategorie=c.id 
        JOIN plat p ON  p.id=cp.idplat where p.id=:id;
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

    }
    /*
    public function findOneBySomeField($value): ?Plat
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


}
