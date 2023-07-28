<?php
namespace App\MessageHandler;

use App\Message\SearchVoitureMessage;
use App\Repository\VoitureRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SearchVoitureMessageHandler  
{
    private $voitureRepository;

    public function __construct(VoitureRepository $voitureRepository)
    {
        $this->voitureRepository = $voitureRepository;
    }

    public function __invoke(SearchVoitureMessage $message)
    {
        // Effectuer la recherche avec les critères de filtrage
        $voitures = $this->voitureRepository->findAllByPrixRange($message->getPrixMin(), $message->getPrixMax());

        // Convertir les résultats en tableau associatif
        $results = [];
        foreach ($voitures as $voiture) {
            $results[] = [
                'titre' => $voiture->getTitre(),
                'anneeMiseCirculation' => $voiture->getAnneeMiseCirculation(),
                'image' => $voiture->getImage(),
                'description' => $voiture->getDescription(),
                'prix' => $voiture->getPrix(),
            ];
        }

        // Renvoyer les résultats de recherche
        return $results;
    }
}
