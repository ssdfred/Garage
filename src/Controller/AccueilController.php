<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Repository\HoraireRepository;
use App\Repository\ServiceRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;


class AccueilController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'accueil')]
    public function index(Request $request, VoitureRepository $voitureRepository, HoraireRepository $horaireRepository): Response
    {

        $voitures = $voitureRepository->findAll();
        $horaires = $horaireRepository->findAll();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'voitures' => $voitures,
            'horaires' => $horaires,

        ]);
    }

    #[Route('/filter-cars', name: 'filter_cars', methods: ['POST'])]
    public function filterCars(Request $request, VoitureRepository $voitureRepository): JsonResponse
    {
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);
        $priceMin = $request->request->get('priceMin');
        $priceMax = $request->request->get('priceMax');
        $kilometersMin = $request->request->get('kilometersMin');
        $kilometersMax = $request->request->get('kilometersMax');
        $yearMin = $request->request->get('yearMin');
        $yearMax = $request->request->get('yearMax');

        $filteredCars = $voitureRepository->findByFilters(
            $priceMin,
            $priceMax,
            $kilometersMin,
            $kilometersMax,
            $yearMin,
            $yearMax
        );
        if ($data === null) {
            return new Response('Invalid JSON data', Response::HTTP_BAD_REQUEST);
        }

        $responseArray = [];
        foreach ($filteredCars as $voiture) {
            $responseArray[] = [
                'titre' => $voiture->getTitre(),
                'anneeMiseCirculation' => $voiture->getAnneeMiseCirculation()->format('d/m/Y'),
                'image' => $voiture->getImage(),
                'description' => $voiture->getDescription(),
                'prix' => $voiture->getPrix(),
            ];
        }
        $jsonContent = json_encode($responseArray); // Convertir le tableau en format JSON
        return new Response($jsonContent, Response::HTTP_OK, [
            'Content-Type' => 'application/json', // Spécifier le type de contenu JSON
        ]);
    }


    #[Route('/search', name: 'search', methods: ['POST'])]
    public function search(Request $request, VoitureRepository $voitureRepository, HoraireRepository $horaireRepository): Response
    {
        $horaires = $horaireRepository->findAll();
        $jsonData = $request->getContent();
        $data = json_decode($jsonData, true);

        // Vérifier que les données JSON sont décodées correctement
        if ($data === null) {
            return new Response('Invalid JSON data', Response::HTTP_BAD_REQUEST);
        }

        if (isset($data['prix_min']) && isset($data['prix_max'])) {
            $prixMin = (float) $data['prix_min'];
            $prixMax = (float) $data['prix_max'];

            // Effectuer la recherche avec les critères de filtrage
            $voitures = $voitureRepository->findAllByPrixRange($prixMin, $prixMax);

            $query = [];
            foreach ($voitures as $voiture) {
                $query[] = [
                    'titre' => $voiture->getTitre(),
                    'anneeMiseCirculation' => $voiture->getAnneeMiseCirculation()->format('d/m/Y'),
                    'image' => $voiture->getImage(),
                    'description' => $voiture->getDescription(),
                    'prix' => $voiture->getPrix(),
                ];
            }


            $jsonContent = json_encode($query); // Convertir le tableau en format JSON

            return new Response($jsonContent, Response::HTTP_OK, [
                'Content-Type' => 'application/json', // Spécifier le type de contenu JSON
            ]);
        }

        return new Response('Missing prix_min or prix_max', Response::HTTP_BAD_REQUEST);
    }

    #[Route('/voitures/{id}', name: 'voitures_by_id', methods: ['POST'])]
    public function voituresById(Request $request, VoitureRepository $voitureRepository): Response
    {
        $id = (int) $request->request->get('id');

        // Vérifier que l'ID est un entier
        if ($id === null) {
            return new JsonResponse(['error' => 'Invalid ID'], JsonResponse::HTTP_OK);
        }

        // Effectuer la recherche avec les critères de filtrage
        $voitures = $voitureRepository->find($id);

        // Convertir les résultats en tableau associatif
        $query = [];
        foreach ($voitures as $voiture) {
            $query[] = [
                'titre' => $voiture->getTitre(),
                'anneeMiseCirculation' => $voiture->getAnneeMiseCirculation()->format('d/m/Y'),
                'image' => $voiture->getImage(),
                'description' => $voiture->getDescription(),
                'prix' => $voiture->getPrix(),
            ];
        }

        // Renvoyer les résultats de recherche sous forme de réponse JSON
        return new JsonResponse($query, JsonResponse::HTTP_OK);
    }
    public function voituresByPrixRange(float $prixMin, float $prixMax, VoitureRepository $voitureRepository): Response
    {
        // Utiliser la méthode findByPrixRange du VoitureRepository pour récupérer les voitures
        $voitures = $voitureRepository->findByPrixRange($prixMin, $prixMax);

        // Faites ce que vous voulez avec le tableau $voitures (par exemple, le passer à un template Twig)

        return $this->render('accueil/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }
}
