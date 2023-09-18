<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\FormulaireContact;
use App\Repository\HoraireRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class VoitureController extends AbstractController
{
    private VoitureRepository $voitureRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(VoitureRepository $voitureRepository, EntityManagerInterface $entityManager)
    {
        $this->voitureRepository = $voitureRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/voiture/new', name: 'voiture_new', methods: ['GET', 'POST'])]

    public function new(Request $request,
    HoraireRepository $horaireRepository,
    ManagerRegistry $doctrine,
    SluggerInterface $slugger): Response
    {
        
        $voitures = $this->voitureRepository->findAll();
        $horaires = $horaireRepository->findAll();

        $voiture = new Voiture();
        
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            $galerieImages = $form->get('galerieImages')->getData();
            if ($image && $galerieImages) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $originalFilename = pathinfo($galerieImages->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $galerieImages->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('uploads'),
                        $newFilename
                    );
                    $galerieImages->move(
                        $this->getParameter('uploads'),
                        $newFilename
                    );
                } catch (FileException $e) {
                  //  dump($e);
                }
                $voiture->setImage($newFilename);
                $voiture->setGalerieImages($newFilename);
            }
            $voiture->setUser($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($voiture);
            $em->flush();

            //return $this->redirectToRoute('accueil');
        }

        return $this->render('voiture/create.html.twig', [
            'form' => $form->createView(),
            'voitures' => $voitures,  
            'horaires' => $horaires,
        ]);
    }


    #[Route('/voiture/{id}/show', name: 'voiture_show')]
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

    #[Route("/voiture/{id}/contact", name: "voiture_contact")]
    public function voitureContact(
        VoitureRepository $voitureRepository,
        HoraireRepository $horaireRepository,

        int $id
    ): Response {
        // Récupérer la voiture correspondante
        $voiture = $voitureRepository->find($id);
    
        // Vérifier que la voiture existe
        if (!$voiture) {
            throw $this->createNotFoundException('Voiture non trouvée');
        }
     // Récupérer les informations spécifiques de la voiture
     $voitureTitre = $voiture->getTitre();
     $voitureAnnee = $voiture->getAnneeMiseCirculation();
   
        // Créer une instance du formulaire de contact
        $contact = new FormulaireContact();
   
    // Passer les informations à la vue de contact
    return $this->render('contact/contact.html.twig', [
        'horaires' => $horaireRepository->findAll(),
        'voiture' => $voiture,
        'contact' => $contact,
        
        
    ]);
}
}
