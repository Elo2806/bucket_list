<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wishes/{page}", name="wish_list", requirements={"page": "\d+"})
     */
    public function list(WishRepository $wishRepository, $page = 1): Response
    {
        //aller en bdd chercher tous les whishes
        //$wishes = $wishRepository->findBy(["is_published" => true], ["date_created" => "DESC"], 20, 0);
        $result = $wishRepository->findWishList($page);
        $wishes = $result['result'];

        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes,
            "totalResultCount" => $result['totalResultCount'],
            "currentPage" => $page
        ]);
    }

    /**
     * @Route ("/wishes/detail/{id}", name="wish_detail")
     */
    public function detail($id, WishRepository $wishRepository){

        //requête à la BDD pour aller chercher les infos de ce wish dont l'id est dans l'url
        $wish = $wishRepository->find($id);
        return $this->render('wish/detail.html.twig', ["wish"=>$wish]);
    }

    /**
     * @Route ("/wishes/create", name="wish_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager){
        $wish = new Wish();

        //Créer une instance de la classe formulaire et y associer $wish pour automatiser
        //les mises à jour des getters/setters
        $wishForm = $this->createForm(WishType::class, $wish);

        //On prend les données du formulaire et on les injectes dans $wish
        $wishForm->handleRequest($request);

        //Si le formulaire est soumis...
        if ($wishForm->isSubmitted() && $wishForm->isValid()){
            //Hydrater les propriétés encore à null (qui ne sont pas dans le formulaire)
            $wish->setDateCreated(new \DateTime());
            $wish->setIsPublished(true);
            $wish->setLikes(0);

            //On sauvegarde
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', "Idea sucessfully added - Souhait enregistré, il sera peut-être exaucé !");

            //Redirection
            return $this->redirectToRoute("wish_detail", ['id' => $wish->getId()]);

        }

        return $this->render("create.html.twig", [
            //Passe l'instance à twig pour l'affichage
            'wishForm' => $wishForm->createView()
        ]);
    }

}
