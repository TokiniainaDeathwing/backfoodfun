<?php
namespace App\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Admin;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdminService
{
    private $re;
    private $session;
    public function __construct(ManagerRegistry $re,SessionInterface $session)
    {
        $this->re = $re;
        $this->session=$session;
    }
    public function connexion($user,$password){
        $admin=$this->re->getManager()->getRepository(Admin::class)->findOneBy(
            ['user'=>$user,'password'=>$password]
        );
        if($admin!=null){
            $this->session->set('admin',$admin);
        }
    }
    public function deconnexion(){
        $this->session->remove('admin');
    }
}