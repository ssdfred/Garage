<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\FormulaireContact;
use App\Repository\HoraireRepository;
use App\Repository\VoitureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ContactController extends AbstractController
{
    #[Route("/contact", name: "contact")]
    public function contact(
        Request $request,
        HoraireRepository $horaireRepository,
        VoitureRepository $voitureRepository,
        ManagerRegistry $doctrine,


    ): Response {
        $horaires = $horaireRepository->findAll();
        $voitures = $voitureRepository->findAll();

        // Créer une instance de l'entité FormulaireContact
        $formulaireContact = new FormulaireContact();

        // Créer le formulaire de contact
        $form = $this->createForm(ContactType::class, $formulaireContact);
        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer l'entité FormulaireContact en base de données
            // $formulaireContact->setFormulaireContact($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($formulaireContact);
            $em->flush();


            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('accueil');
        }
        return $this->render('contact/contact.html.twig', [
            'horaires' => $horaires,
            'voitures' => $voitures,
            'form' => $form->createView(),
        ]);
    }
}
