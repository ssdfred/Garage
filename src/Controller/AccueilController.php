<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use App\Repository\ServiceRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AccueilController extends AbstractController 
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
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
    public function search(Request $request,VoitureRepository $voitureRepository, HoraireRepository $horaireRepository): JsonResponse
    {
        $horaires = $horaireRepository->findAll();
       // $horaires = $horaireRepository->findAll();
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
            //$prixMax = floatval($prixMax);
            $voitures = $voitureRepository->findAllByPrixRange($prixMin,$prixMax);
            
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
           //return $this->render('accueil/index.html.twig', [
           //    'results' => $query,
           //    'voitures' => $voitures,
           //    
           //]);
//
        }

        return new JsonResponse(['error' => 'Missing required parameters'], JsonResponse::HTTP_BAD_REQUEST);
    }
//    public function searchAjax(float $prixMin, float $prixMax): Response
//    {
//                // Si $prixMin n'est pas fourni, on utilise une valeur par défaut
//                if ($prixMin === null) {
//                    $prixMin = 0; // ou toute autre valeur par défaut que vous souhaitez utiliser
//                }
//        // Récupérer l'EntityManager à partir du conteneur de services
//        $voitureRepository = $this->entityManager->getRepository(Voiture::class);
//
//
//        // Requête pour récupérer les voitures dont le prix est compris entre $prixMin et $prixMax
//        $query = $voitureRepository->createQueryBuilder('v')
//            ->where('v.prix >= :prixMin')
//            ->andWhere('v.prix <= :prixMax')
//            ->setParameter('prixMin', $prixMin)
//            ->setParameter('prixMax', $prixMax)
//            ->orderBy('v.prix', 'ASC')
//            ->getQuery();
//
//        $voitures = $query->getResult();
//
//        // Afficher les résultats de recherche dans une vue Twig partielle
//        return $this->render('partials/resultats_recherche.html.twig', [
//            'voitures' => $voitures
//        ]);
//    }
#[Route('/voitures/{id}', name: 'voitures_by_id', methods: ['GET'])]
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