<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\HoraireCrudController;
use App\Entity\Horaire;
use App\Entity\Service;
use App\Entity\Temoignage;
use App\Entity\User;
use App\Entity\Voiture;

class DashboardController extends AbstractDashboardController
{
   
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ){
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(HoraireCrudController::class)
        ->generateUrl();
        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Perrot');
    }

    public function configureMenuItems(): iterable
    {
        
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::subMenu('User', 'fas fa-bars')->setSubItems([
                MenuItem::linkToCrud('Create user','fas fa-plus', User::class )->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Show user', 'fas fa-eye', User::class )
            ]);
        }
        
        yield MenuItem::section('Other');

        yield MenuItem::subMenu('Horaire', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create horaire','fas fa-plus', Horaire::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show horaires', 'fas fa-eye', Horaire::class )
        ]);


        yield MenuItem::subMenu('Voiture', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create voiture','fas fa-plus', Voiture::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show voiture', 'fas fa-eye', Voiture::class )
        ]);

        yield MenuItem::subMenu('Service', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create service','fas fa-plus', Service::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show service', 'fas fa-eye', Service::class )
        ]);
        yield MenuItem::subMenu('Temoignage', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create temoignage','fas fa-plus', Temoignage::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show temoignage', 'fas fa-eye', Temoignage::class )
        ]);
    }
}
