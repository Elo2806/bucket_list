<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wishes", name="wish_list")
     */
    public function list(): Response
    {
        //todo : aller en bdd chercher tous les whishes
        return $this->render('wish/list.html.twig');
    }

    /**
     * @Route ("/wishes/{id}", name="wish_detail")
     */
    public function detail($id){

        //todo : requête à la BDD pour aller chercher les infos de ce wish dont l'id est dans l'url
        return $this->render('wish/detail.html.twig', ["id"=>$id]);
    }
}
