<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AvisRepository;
use App\Entity\Avis;
use App\Entity\Commentaire;
use App\Entity\Conducteur;
use App\Repository\ConducteurRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class AvisController extends AbstractController
{


    
    #[Route('/avis', name: 'app_avis')]
    public function ShowAvis(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(avis::class);
        $avis = $repo->findAll();

        return $this->render('avis/avis.html.twig', [
            'avis' => $avis,
        ]);
    }

    #[Route('/avisclient', name: 'app_avis_client')]
    public function index(): Response
    {
        return $this->render('avis/avisclient.html.twig', [
        
        ]);
    }




    #[Route('/avis/delete/{id}', name: 'app_avis_delete')]
    public function deleteAvis($id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $avis = $entityManager->getRepository(avis::class)->find($id);
    
        if (!$avis) {
            throw $this->createNotFoundException('Avis non trouvé');
        }
    
        $entityManager->remove($avis);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_avis');
    }

    #[Route('/conducteur', name: 'app_conducteur_avis')]
    public function ShowConducteur(ManagerRegistry $doctrine): Response
    { 
        $repo = $doctrine->getRepository(conducteur::class);
     
        $conducteur = $repo->findAll();

        return $this->render('conducteur/avisconducteur.html.twig', [
            'conducteur' => $conducteur,
       
        ]);
    }
    #[Route('/addavis', name: 'add_avis')]
    public function addavis(Request $request, ManagerRegistry $doctrine)
    {    
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $doctrine->getRepository(conducteur::class);
        
        // Get the values from the form
        $id_client = $request->request->get('id_client');
        $id_conducteur = $request->request->get('id_conducteur');
        $rating = $request->request->get('rating');
    
        // Check if the input values are empty
        if($rating == 0) {
            // Display an alert message
            echo "<script>alert('Please fill in all fields');</script>";
            // Redirect the user back to the conducteur page
            return $this->render('conducteur/avisconducteur.html.twig', [
                'conducteur' => $conducteur,
            ]);
        }
    
        // Find the conducteur object
        $conducteur = $repo->find($id_conducteur);
    
        // Create a new Avis object and set its properties
        $avis = new Avis();
        $avis->setIdClient('13');
        $avis->setIdConducteur($id_conducteur);
        $avis->setRating($rating);
    
        // Save the Avis object to the database
        $entityManager->persist($avis);
        $entityManager->flush();
        return $this->redirectToRoute('app_conducteur_avis');
    
        // Redirect the user back to the conducteur page
        return $this->render('conducteur/avisconducteur.html.twig', [
            'conducteur' => $conducteur,
       
        ]);
    }
    



#[Route('/updateavis/{id}', name: 'app_avis_update')]
public function updateCommentaire(Request $request, ManagerRegistry $doctrine, int $id): Response
{
    $avis = $doctrine->getRepository(Avis::class)->find($id);

    $form = $this->createFormBuilder($avis)
        ->add('id_conducteur', TextType::class)
        ->add('id_client', TextType::class)
        ->add('rating', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Update Avis'])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $doctrine->getManager()->flush();

        // Render the table row with the updated comment data
        return $this->redirectToRoute('app_avis');

        return new Response($html);
    }

    // Render the update form HTML
    $html = $this->renderView('avis/avisclient.html.twig', [
        'form' => $form->createView(),
        'avis' => $avis,
    ]);

    return new Response($html);
}
}


