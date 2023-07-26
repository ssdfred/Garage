<?php

namespace App\Controller;

use App\Message\SearchVoitureMessagehandler;
use App\Repository\HoraireRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\Messenger\MessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(Request $request, VoitureRepository $voitureRepository,HoraireRepository $horaireRepository): Response
    {
        $voitures = $voitureRepository->findAll();
        $horaires = $horaireRepository->findAll();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'voitures' => $voitures,
            'horaires' => $horaires,
        ]);
    }

    #[Route('/search', name: 'search', methods: ['POST'])]
    public function search(Request $request, MessageBusInterface $messageBus, VoitureRepository $voitureRepository): JsonResponse
    {
        $prixMin = (float) $request->request->get('prix_min');
        $prixMax = (float) $request->request->get('prix_max');
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        // Vérifier que les données JSON sont décodées correctement
        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON data'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (isset($data['prix_min']) && isset($data['prix_max'])) {
            $prixMin = $data['prix_min'];
            $prixMax = $data['prix_max'];

            // Effectuer la recherche avec les critères de filtrage
            $voitures = $voitureRepository->findAllByPrixRange($prixMin, $prixMax);

            // Convertir les résultats en tableau associatif
            $results = [];
            foreach ($voitures as $voiture) {
                $results[] = [
                    'titre' => $voiture->getTitre(),
                    'anneeMiseCirculation' => $voiture->getAnneeMiseCirculation()->format('d/m/Y'),
                    'image' => $voiture->getImage(),
                    'description' => $voiture->getDescription(),
                    'prix' => $voiture->getPrix(),
                ];
            }

            // Renvoyer les résultats de recherche sous forme de réponse JSON
            return new JsonResponse($results);
        }

        return new JsonResponse(['error' => 'Missing required parameters'], JsonResponse::HTTP_BAD_REQUEST);
    }

}