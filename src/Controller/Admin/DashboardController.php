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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Horaire;
use App\Entity\Account;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\Voiture;

class DashboardController extends AbstractDashboardController
{
   // #[IsGranted('ROLE_ADMIN')]
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

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Perrot');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::subMenu('User', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create user','fas fa-plus', User::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show user', 'fas fa-eye', User::class )
        ]);

        yield MenuItem::subMenu('Horaire', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create horaire','fas fa-plus', Horaire::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show horaires', 'fas fa-eye', Horaire::class )
        ]);

       //yield MenuItem::subMenu('Utilisateur', 'fas fa-bars')->setSubItems([
       //    MenuItem::linkToCrud('Create utilisateur','fas fa-plus', User::class )->setAction(Crud::PAGE_NEW),
       //    MenuItem::linkToCrud('Show utilsateur', 'fas fa-eye', User::class )
       //]);

        yield MenuItem::subMenu('Voiture', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create voiture','fas fa-plus', Voiture::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show voiture', 'fas fa-eye', Voiture::class )
        ]);

        yield MenuItem::subMenu('Service', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create service','fas fa-plus', Service::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show service', 'fas fa-eye', Service::class )
        ]);
    }
}
