<?php

namespace App\Controller;
use App\Entity\CategoriePlat;
use App\Service\CategorieService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
  * Require ROLE_ADMIN for *every* controller method in this class.
  *
  * @IsGranted("ROLE_ADMIN")
  */
class CategorieController extends AbstractController
{

    public function index(SessionInterface $session)
    {
        $data =array();

        $categorieService=new CategorieService($this->getDoctrine());
        $data['categories']=$categorieService->getCategories();
        return $this->render('categorie.html.twig',$data);
    }
    public function update(Request $request){

        $type=$request->get('type');
        $nom=$request->get('nom');
        $categorieService=new CategorieService($this->getDoctrine());
        if($type=="ajout"){
            $categorieService->insererCategorie($nom);
        }else{

            $id=$request->get('id');

            $categorieService->deleteCategorie($id);
        }
        return $this->redirectToRoute('categorie');

        //return $this->render('categorie.html.twig');
    }
}
