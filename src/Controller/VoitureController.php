<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;

class VoitureController extends AbstractController
{
    private VoitureRepository $voitureRepository;
    private EntityManagerInterface $entityManager;
   

    public function __construct(VoitureRepository $voitureRepository, EntityManagerInterface $entityManager)
    {
        $this->voitureRepository = $voitureRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/voitures', name: 'voitures')]
    public function index(): Response
    {
        $voitures = $this->voitureRepository->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/voiture/new', name: 'voiture_new')]
    public function create(Request $request): Response
    {
                // Retrieve the form data
                $formData = $request->request->all();
        
                // Suppose the restaurant name is in $formData['restaurantName']
        
                // Retrieve the corresponding Restaurant entity from the database
                $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $formData['user_id']]);
        $voiture = new Voiture();

        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($voiture);
            $this->entityManager->flush();

            return $this->redirectToRoute('voitures');
        }

        return $this->render('voiture/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/voiture/{id}', name: 'voiture_show')]
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/voiture/{id}/edit', name: 'voiture_edit')]
    public function edit(Request $request, Voiture $voiture): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('voitures');
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/voiture/{id}/delete', name: 'voiture_delete')]
    public function delete(Request $request, Voiture $voiture): Response
    {
        if ($request->isMethod('POST')) {
            $this->entityManager->remove($voiture);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('voitures');
    }
    
     #[Route("/voiture/{id}/contact", name:"voiture_contact")]
     
    public function contact(Voiture $voiture, Request $request): Response
    {
        // Récupérer les informations spécifiques de la voiture
        $voitureTitre = $voiture->getTitre();
        $voitureAnnee = $voiture->getAnneeMiseCirculation();

        // Passer les informations à l'action de contact
        return $this->redirectToRoute('contact', [
            'voitureTitre' => $voitureTitre,
            'voitureAnnee' => $voitureAnnee,
        ]);
    }
}
