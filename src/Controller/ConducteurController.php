<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\Commentaire;
use App\Entity\Conducteur;
use App\Repository\ConducteurRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class ConducteurController extends AbstractController
{
    #[Route('/conducteur', name: 'app_conducteur')]
    public function ShowConducteur(ManagerRegistry $doctrine): Response
    { 
        $repo = $doctrine->getRepository(conducteur::class);
     
        $conducteur = $repo->findAll();

        return $this->render('conducteur/avisconducteur.html.twig', [
            'conducteur' => $conducteur,
       
        ]);
    }

    #[Route('/conducteurcommentaire', name: 'commentaire_conducteur')]
    public function Showcommentaire(ManagerRegistry $doctrine): Response
    { 
        $repo = $doctrine->getRepository(conducteur::class);
     
        $conducteur = $repo->findAll();

        return $this->render('conducteur/commentaireconducteur.html.twig', [
            'conducteur' => $conducteur,
       
        ]);
    }
    
}
