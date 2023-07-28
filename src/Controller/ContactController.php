<?php

namespace App\Controller;

use App\Entity\FormulaireContact;
use App\Form\ContactType;
use App\Form\FormulaireContactType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\HoraireRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route("/contact", name: "contact")]
    public function contact(
        Request $request,
        HoraireRepository $horaireRepository,
        VoitureRepository $voitureRepository,
        ManagerRegistry $doctrine
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

            return $this->redirectToRoute('accueil');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
            'horaires' => $horaires,
            'voitures' => $voitures,
        ]);
    }
}
