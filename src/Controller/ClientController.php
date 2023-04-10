<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Entity\Commentaire;
use App\Entity\Conducteur;
use App\Repository\ConducteurRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ClientController extends AbstractController
{
  
    #[Route('/client', name: 'app_client')]
    public function Showcommentaire(ManagerRegistry $doctrine): Response
    { 
        $rep = $doctrine->getRepository(Client::class);
        $repo = $doctrine->getRepository(Conducteur::class);
        $repos = $doctrine->getRepository(Commentaire::class);
        $avisRepo = $doctrine->getRepository(Avis::class);
    
        $clients = $rep->findAll();
        $conducteurs = $repo->findAll();
        $commentaires = $repos->findAll();
        $avis = $avisRepo->findAll();
    
        $commentaireData = [];
        $avisData = [];
    
        foreach ($commentaires as $commentaire) {
            $client = $rep->find($commentaire->getIdClient());
            $commentaireData[] = [
                'client' => $client,
                'commentaire' => $commentaire,
            ];
        }
    
        foreach ($avis as $avi) {
            $client = $rep->find($avi->getIdClient());
            $conducteur = $repo->find($avi->getIdConducteur());
            $avisData[] = [
                'client' => $client,
                'conducteur' => $conducteur,
                'avis' => $avi,
            ];
        }
    
        return $this->render('client/index.html.twig', [
            'conducteurData' => $conducteurs,
            'client' => $clients,
            'avisData' => $avisData,
            'commentaireData' => $commentaireData,
        ]);
    }
    
    
}
