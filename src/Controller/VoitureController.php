<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\FormulaireContact;
use App\Repository\HoraireRepository;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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

    #[Route('/voitures', name: 'voitures')]
    public function index(): Response
    {
        
        $voitures = $this->voitureRepository->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/voiture/new', name: 'voiture_new')]
    public const ACTION_DUPLICATE = 'duplicate';
    public const VOITURE_BASE_PATH = 'uploads/Voiture';
    public const VOITURE_UPLOAD_DIR = 'public/uploads/Voiture';
    public function create(Request $request, HoraireRepository $horaireRepository, ManagerRegistry $doctrine,SluggerInterface $slugger): Response
    {
        $horaires = $horaireRepository->findAll();

        $voiture = new Voiture();
dump($voiture);
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('uploads'),
                        $newFilename
                    );
                } catch (FileException $e) {
                  //  dump($e);
                }
                $voiture->setImage($newFilename);
            }
            $voiture->setUser($this->getUser());
            $voiture->$doctrine->getManager();
            $this->entityManager->persist($voiture);
            $this->entityManager->flush();

            return $this->redirectToRoute('voitures');
        }

        return $this->render('voiture/create.html.twig', [
            'form' => $form->createView(),
            'horaires' => $horaires,
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
