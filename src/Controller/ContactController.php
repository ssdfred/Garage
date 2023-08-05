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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport\Smtp\Auth\XOAuth2Authenticator;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class ContactController extends AbstractController
{
    #[Route("/contact", name: "contact")]
    public function contact(
        Request $request,
        HoraireRepository $horaireRepository,
        VoitureRepository $voitureRepository,
        ManagerRegistry $doctrine,
        EsmtpTransport $transport,
        MailerInterface $mailer
        
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
           
           /* $email = (new Email())
            ->from($formulaireContact->getEmail())
            ->to('admin@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($formulaireContact->getSujet())
            //->text($formulaireContact->getMessage())
            ->html($formulaireContact->getMessage());

        $mailer->send($email);
        $transport = new EsmtpTransport(
            host: 'oauth-smtp.domain.tld',
            authenticators: [new XOAuth2Authenticator()]
        );*/
            return $this->redirectToRoute('accueil');
        }

        return $this->render('contact/contact.html.twig', [
            'horaires' => $horaires,
            'voitures' => $voitures,
            'form' => $form->createView(),
        ]);
    }
}
