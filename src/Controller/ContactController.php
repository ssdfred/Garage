<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Entity\FormulaireContact;
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
    public function contact(
        Request $request,
        MailerInterface $mailer,
        HoraireRepository $horaireRepository,
        VoitureRepository $voitureRepository,
        ManagerRegistry $doctrine,


    ): Response {
        $contact = new FormulaireContact();
    if ($this->getUser() ) {
            $contact->setNom($this->getUser()->getnom())
            ->setEmail($this->getUser()->getemail())
            ->setPrenom($this->getUser()->getprenom());
           // ->setVoiture($this->getUser()->getvoitures())
           
    } 
        $horaires = $horaireRepository->findAll();
        $voitures = $voitureRepository->findAll();


        // Créer le formulaire de contact
        $form = $this->createForm(ContactType::class, $contact);
        // Gérer la soumission du formulaire
        $form->handleRequest($request);
        $contact = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer l'entité FormulaireContact en base de données
            // $formulaireContact->setFormulaireContact($this->getUser());
            $em = $doctrine->getManager();
            $em->persist($contact);
            $em->flush();
        //Email
        $email = (new TemplatedEmail())
        ->from($contact->getEmail())
        ->to('admin@Vparrot.com')
        ->subject($contact->getSujet())
        ->htmlTemplate('email/contact.html.twig')
        ->context([
            'contact' => $contact,
        ]);
        //dd($email);
        $mailer->send($email);
        $this->addFlash('success', 'Votre message a bien été envoyé');
            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('accueil');
        }
       
        return $this->render('contact/contact.html.twig', [
            'contact' => $contact,
            'horaires' => $horaires,
            'voitures' => $voitures,
            'form' => $form->createView(),
        ]);
    }
}
