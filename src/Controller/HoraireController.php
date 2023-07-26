<?php



namespace App\Controller;
use App\Repository\HoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class HoraireController extends AbstractController
{
  private HoraireRepository $horaireRepository;
  private EntityManagerInterface $entityManager;

  public function __construct(HoraireRepository $horaireRepository, EntityManagerInterface $entityManager)
  {
      $this->horaireRepository = $horaireRepository;
      $this->entityManager = $entityManager;
  }
    #[Route("/horaires", name: "horaires")]
    public function index() : Response
    {
        $horaires = $this->horaireRepository->findAll();
        
        return $this->render('accueil/index.html.twig', [
            'horaires' => $horaires,
        ]);
    }
}
