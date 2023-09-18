<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TemoignageRepository;
use App\Form\TemoignageType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Temoignage;
use App\Repository\HoraireRepository;
use App\Repository\UserRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;


class TemoignageController extends AbstractController
{

    #[Route('/temoignage/new', name: 'temoignage_new')]
    public function new(Request $request, UserRepository $user, EntityManagerInterface $entityManager, VoitureRepository $voitureRepository, HoraireRepository $horaireRepository, TemoignageRepository $temoignageRepository): Response
    {
        $voitures = $voitureRepository->findAll();
        $horaires = $horaireRepository->findAll();
         // Récupérer l'utilisateur connecté (ou null s'il n'est pas connecté)
      
        //$user = $this->getUser();


        // Créez une instance de Temoignage et configurez le formulaire
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
    
        // Traitez la soumission du formulaire
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $note = $request->request->get('note');
    
            // s'assurer que la note est valide
            if ($note >= 1 && $note <= 5) {
                $temoignage->setNote($note);
    
                // Enregistrez le témoignage dans la base de données
                $temoignage->setUser($this->getUser($user));
                $temoignage->setcreatedAt(new \DateTime());
                $entityManager->persist($temoignage);
                $entityManager->flush();
    
                // Redirigez vers la page des témoignages
                return $this->redirectToRoute('accueil');
            } else {
                // Affichez un message d'erreur
                $this->addFlash('error', 'La note doit être comprise entre 1 et 5');
            }
        }
    
        // Affichez le formulaire
        return $this->render('temoignage/create.html.twig', [
            'form' => $form->createView(),
            'temoignages' => $temoignageRepository->findAll(),
            'horaires' => $horaires,
            'voitures' => $voitures,
            
        ]);
    }
    #[Route('/temoignage', name: 'temoignage_show')]
    public function show(VoitureRepository $voitureRepository, HoraireRepository $horaireRepository, TemoignageRepository $temoignageRepository): Response
    {
        $voitures = $voitureRepository->findAll();
        $horaires = $horaireRepository->findAll();
        $temoignages = $temoignageRepository->findAll();
        return $this->render('temoignage/index.html.twig', [
            'temoignages' => $temoignages,
            'horaires' => $horaires,
            'voitures' => $voitures,
        ]);
    }
}