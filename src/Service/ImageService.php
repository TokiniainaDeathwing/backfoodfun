<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Images;
class ImageService
{

    private $re;

    public function __construct(ManagerRegistry $re)
    {
        $this->re = $re;
    }

    public function deleteImage($id){
        $product = $this->re
            ->getRepository(Images::class)
            ->find($id);


        $entityManager=$this->re->getManager();
        if($product!=null){
            $entityManager->remove($product);

        }
        $entityManager->flush();
    }
    public function insererPlatImage($idplat,$url,$description,$type){
        $product=new Images();
        $product->setUrl($url);
        $product->setIdplat($idplat);
        $product->setDescription($description);
        $product->setType($type);
        $entityManager=$this->re->getManager();
        if($type==0||$type=='0'){
            $ancienpricipale=$this->re
                ->getRepository(Images::class)
                ->findOneBy(['idplat'=>$idplat,'type'=>'0']);
            if($ancienpricipale!=null){
                $entityManager.remove($ancienpricipale);
            }
        }

        $entityManager->persist($product);
        $entityManager->flush();
    }
}