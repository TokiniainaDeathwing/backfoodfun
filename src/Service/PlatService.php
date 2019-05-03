<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Plat;
class PlatService
{
    private $re;
    public function __construct(ManagerRegistry $re ){
        $this->re = $re;

    }
    //get Spécialite d'el Resto
    public function getSpecialités():? array
    {
        $product = $this->re
            ->getRepository(Plat::class)
            ->findPlatsByCategorie('specialite','1');
        return $product;


    }
    //plats random
    public function getPlatRandom():? array
    {
        $product = $this->re
            ->getRepository(Plat::class)
            ->findRandomPlat('6');
        return $product;


    }
   //find plat by Id
    public function getPlatById($id){

        $product = $this->re
            ->getRepository(Plat::class)
            ->findPlatById($id);
        return $product;

    }
//find images
    public function getImagePlat($id):? array{

        $product = $this->re
            ->getRepository(Plat::class)
            ->findImagesByIdplat($id);
        return $product;

    }
//recherche plat
    public function rechercherPlat($nom,$categorie,$limit,$offset){

        $product = $this->re
            ->getRepository(Plat::class)
            ->searchPlat($limit,$offset,$nom,$categorie,'1');
        return $product;

    }

//count recherche plat
    public function countPlat($nom,$categorie){

        $product = $this->re
            ->getRepository(Plat::class)
            ->NbrsearchPlat($nom,$categorie,'1');
        return $product;

    }


}