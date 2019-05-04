<?php
namespace App\Service;

use App\Entity\CategoriePlat;
use App\Entity\Images;
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
    public function getCategoriesPlatById($id){

        $product = $this->re
            ->getRepository(Plat::class)
            ->getCategoriesPlat($id);
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

    public function insererPlat($nom,$descriptioncourte,$descriptionlongue,$prix){
        $product=new Plat();
        $product->setNom($nom);
        $product->setDescriptioncourte($descriptioncourte);
        $product->setDescriptionlongue($descriptionlongue);
        $product->setPrix($prix);
        $entityManager=$this->re->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        //var_dump($product);
        $imageService=new ImageService($this->re);
        $imageService->insererPlatImage($product->getId(),"","insérer l'image principale",0);
        return $product->getId();
    }
    public function deletePlat($id){
        $product = $this->re
            ->getRepository(Plat::class)
            ->find($id);
        $entityManager=$this->re->getManager();
        if($product!=null){
            $entityManager->remove($product);
        }
        $entityManager->flush();
    }
    public function updatePlat($id,$nom,$descriptioncourte,$descriptionlongue,$prix){
        $entityManager=$this->re->getManager();
        $product=$product = $entityManager->getRepository(Plat::class)->find($id);
        $product->setNom($nom);
        $product->setDescriptioncourte($descriptioncourte);
        $product->setDescriptionlongue($descriptionlongue);
        $product->setPrix($prix);
        $entityManager->flush();
    }



}