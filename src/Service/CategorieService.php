<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Categorie;
use App\Entity\CategoriePlat;
class CategorieService
{

    private $re;

    public function __construct(ManagerRegistry $re)
    {
        $this->re = $re;
    }
    //get ALL Categories of plats
    public function getCategories():? array
    {
        $product = $this->re
            ->getRepository(Categorie::class)
            ->findAll();
        return $product;


    }
    public function deleteCategorie($id){
        $product = $this->re
            ->getRepository(Categorie::class)
            ->find($id);

        $entityManager=$this->re->getManager();
        $entityManager->remove($product);
        $entityManager->flush();
    }
    public function insererCategorie($nom){
        $product=new Categorie();
        $product->setNom($nom);
        $cat = $this->re
            ->getRepository(Categorie::class)
            ->findOneBy(['nom'=>$nom]);
        $entityManager=$this->re->getManager();
        if($cat==null) {
            $entityManager->persist($product);
        }
        $entityManager->flush();
    }
    public function deletePlatCategorie($idplat,$idcategorie){
        $product = $this->re
            ->getRepository(CategoriePlat::class)
            ->findOneBy(['idplat'=>$idplat,'idcategorie'=>$idcategorie]);
        $entityManager=$this->re->getManager();
        if($product!=null){
            $entityManager->remove($product);
        }
        $entityManager->flush();
    }
    public function insererPlatCategorie($idplat,$idcategorie){
        $product=new CategoriePlat();
        $product->setIdcategorie($idcategorie);
        $product->setIdplat($idplat);
        $catplat = $this->re
            ->getRepository(CategoriePlat::class)
            ->findOneBy(['idplat'=>$idplat,'idcategorie'=>$idcategorie]);
        $entityManager=$this->re->getManager();
        if($catplat==null) {
            $entityManager->persist($product);
        }
        $entityManager->flush();
    }
}