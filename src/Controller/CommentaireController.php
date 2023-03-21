<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CommentaireRepository;
use App\Entity\Commentaire;
use App\Entity\Avis;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function ShowCommentaire(ManagerRegistry $doctrine): Response
    { 
        $repo = $doctrine->getRepository(commentaire::class);
     
        $commentaire = $repo->findAll();

        return $this->render('commentaire/commentaire.html.twig', [
            'commentaire' => $commentaire,
       
        ]);
    }
    


    #[Route('/commentaireclient', name: 'app_commentaire_client')]
    public function index(): Response
    {
        return $this->render('commentaire/commentaireclient.html.twig', [
        
        ]);
    }






    #[Route('/commentaire/delete/{id}', name: 'app_commentaire_delete')]
    public function deleteCommentaire($id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $commentaire = $entityManager->getRepository(commentaire::class)->find($id);
    
        if (!$commentaire) {
            throw $this->createNotFoundException('Commentaire non trouvé');
        }
    
        $entityManager->remove($commentaire);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_commentaire');
    }

   
    
    
}
