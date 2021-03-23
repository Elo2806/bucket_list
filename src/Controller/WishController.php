<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wishes", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        //aller en bdd chercher tous les whishes
        $wishes = $wishRepository->findBy([], ["date_created" => "DESC"], null, 0);
        return $this->render('wish/list.html.twig', ["wishes" => $wishes]);
    }

    /**
     * @Route ("/wishes/{id}", name="wish_detail")
     */
    public function detail($id, WishRepository $wishRepository){

        //requête à la BDD pour aller chercher les infos de ce wish dont l'id est dans l'url
        $wish = $wishRepository->find($id);
        return $this->render('wish/detail.html.twig', ["wish"=>$wish]);
    }

    /**
     * @Route ("/add-wish", name="wish_add")
     */
    public function add(EntityManagerInterface $entityManager){
        $entityManager = $this->getDoctrine()->getManager();

        $wish = new Wish();
        $wish->setTitle("Aller en Australie");
        $wish->setAuthor("Gaston");
        $wish->setDateCreated(new \DateTime());
        $wish->setDescription("Voir un kangourou bla blla lbla bla bla bla, blaaaaa");

        $entityManager->persist($wish);

        $entityManager->flush();

    }
}
