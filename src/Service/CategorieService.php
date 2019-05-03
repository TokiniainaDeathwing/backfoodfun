<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Categorie;
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
}