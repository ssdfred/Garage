<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\FormulaireContact;
use App\Entity\Voiture;
use App\Repository\HoraireRepository;
use App\Repository\VoitureRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;



class ContactController extends AbstractController
{
    #[Route("/contact", name: "contact")]
    public function Contact(
        VoitureRepository $voitureRepository,
        HoraireRepository $horaireRepository,
        Request $request,
        MailerInterface $mailer,
        ManagerRegistry $doctrine,
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
     $content = '<input id="contact_sujet">Titre de la voiture sélectionnée : ' . $voitureTitre . '</input>';
     $content .= '<input id="anneeMiseCirculation">Année de mise en circulation : ' . $voitureAnnee->format('d/m/Y') . '</input>';
        // Créer une instance du formulaire de contact
        $contact = new FormulaireContact();
       
    
        // Créer le formulaire de contact et le gérer
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer l'entité FormulaireContact en base de données
            $em = $doctrine->getManager();
            $em->persist($contact);
            $em->flush();
    
            // Envoyer l'email
        $email = (new TemplatedEmail())
        ->from($contact->getEmail())
        ->to('admin@Vparrot.com')
        ->subject($contact->getSujet())
        ->htmlTemplate('email/contact.html.twig')
        ->context([
            'contact' => $contact,
            'voitureTitre' => $voiture->getTitre(),
            'voitureAnnee' => $voiture->getAnneeMiseCirculation(),
        ]);
        //dd($email);
        $mailer->send($email);
        $this->addFlash('success', 'Votre message a bien été envoyé');

        return $this->redirectToRoute('accueil');
    }

    // Passer les informations à la vue de contact
    return $this->render('contact/contact.html.twig', [
        'horaires' => $horaireRepository->findAll(),
        'voiture' => $voiture,
        'content' => $content,
        'contact' => $contact,
        'voitureTitre' => $voiture->getTitre(),
        'voitureAnnee' => $voiture->getAnneeMiseCirculation(),
        'form' => $form->createView(),
    ]);
}
}
