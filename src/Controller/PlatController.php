<?php
// src/Controller/AdvertController.php

namespace App\Controller;


use App\Service\CategorieService;
use App\Service\ImageService;
use App\Service\PlatService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;

class PlatController extends  AbstractController
{
    // home page
    private $servicePlat;
    public function index(Environment $twig,Request $request,SessionInterface $session)
    {
        $admin="hello mi amigo";
        $session->set('admin',$admin);


        $this->servicePlat = new PlatService($this->getDoctrine());
        $serviceCategorie=new CategorieService($this->getDoctrine());
        $query=$request->query->get('query');
        $categorie=$request->query->get('categorie');
        $limit=$request->query->get('limit');
        $offset=$request->query->get('offset');
        if($limit==""){
            $limit=6;
        }
        if($offset==""){
            $offset=0;
        }
        if($query==null){
            $query="";
        }
        if($categorie==null){
            $categorie="";
        }
        $page=$offset/$limit +1;
        $data=array();
        $data['nombre']=$this->servicePlat->countPlat($query,$categorie);
        $data['categories']=$serviceCategorie->getCategories();
        $data['results']=$this->servicePlat->rechercherPlat($query,$categorie,$limit,$offset);
        $data['limit']=$limit;
        $data['offset']=$offset;
        $data['query']=$query;
        $data['page_max']=(int)($data['nombre']/$limit)+1;
        $data['page']=$page;
        $data['categorie']=$categorie;
        //var_dump($data);
        $content = $twig->render('listeplat.html.twig',$data);
        return new Response($content);

    }

    public function fiche_plat(Environment $twig,Request $request)
    {

        $this->servicePlat = new PlatService($this->getDoctrine());
        $id=$request->query->get('id');
        $serviceCategorie=new CategorieService($this->getDoctrine());
        $data=array();

        $data['plat']=$this->servicePlat->getPlatById($id);
        $data['images_plat']=$this->servicePlat->getImagePlat($id);
        $data['categories']=$serviceCategorie->getCategories();
        $data['categories_plat']=$this->servicePlat->getCategoriesPlatById($id);
        $content = $twig->render('fiche.html.twig',$data);

        return new Response($content);
    }
    public function categorie_plat(Environment $twig,Request $request)
    {
        $idplat=$request->query->get('idplat');

            $type=$request->query->get('type');
            $idcategorie=$request->query->get('idcategorie');
            $categorieservice=new CategorieService($this->getDoctrine());

            if($type=="ajout"){
                $categorieservice->insererPlatCategorie($idplat,$idcategorie);

            }else{
                $categorieservice->deletePlatCategorie($idplat,$idcategorie);
            }
        return $this->redirectToRoute('fiche', [
            'id' => $idplat
        ]);
    }
    public function update_plat(Environment $twig,Request $request)
    {
        $idplat=$request->query->get('idplat');
        $type=$request->query->get('type');
        $prix=$request->query->get('prix');
        $nom=$request->query->get('nom');
        $descriptioncourte=$request->query->get('descriptioncourte');
        $descriptionlongue=$request->query->get('descriptionlongue');

        $platservice=new PlatService($this->getDoctrine());

        if($type=="ajout"){
           $idplat= $platservice->insererPlat($nom,$descriptioncourte,$descriptionlongue,$prix);
        }else if($type=="suppression"){

            $platservice->deletePlat($idplat);

            return $this->redirectToRoute('index', [

            ]);
        }else{
            $platservice->updatePlat($idplat,$nom,$descriptioncourte,$descriptionlongue,$prix);

        }
        return $this->redirectToRoute('fiche', [
            'id' => $idplat
        ]);
    }
    public function image_plat(Environment $twig,Request $request,string $uploadDir,string $host)
    {

        $idplat=$request->get('idplat');
        $type=$request->get('type');
        $idimage= $request->get('idimage');
        $description= $request->get('description');
        $typeimage= $request->get('typeimage');
        $imageservice=new ImageService(($this->getDoctrine()));
       // echo "Image plat:".$type;
        if($type=="ajout"){
            $file=$request->files->get('fichier');

            if (empty($file))
            {
                return new Response("No file specified",
                    Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
            }
            $filename = $file->getClientOriginalName();
            $file->move($uploadDir, $filename);
            $url=$host."images/".$filename;
            //echo $url;
            $imageservice->insererPlatImage($idplat,$url,$description,$typeimage);

        }else if($type=="suppression"){

            $imageservice->deleteImage($idimage);
        }else{

        }
        return $this->redirectToRoute('fiche', [
            'id' => $idplat
        ]);
    }


}
