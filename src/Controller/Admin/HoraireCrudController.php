<?php

namespace App\Controller\Admin;

use App\Entity\Horaire;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HoraireCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'duplicate';
    public static function getEntityFqcn(): string
    {
        return Horaire::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new(self::ACTION_DUPLICATE)
            ->linkToCrudAction('duplicateMenu')
            ->setCssClass('btn btn-info');

        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate);
    }

    public function duplicateMenu(AdminContext $context, EntityManagerInterface $em, AdminUrlGenerator $adminUrlGenerator): RedirectResponse
    {
        $voiture = $context->getEntity()->getInstance();
        $duplicateVoiture = clone $voiture;


        parent::persistEntity($em, $duplicateVoiture);

        $url = $adminUrlGenerator->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($duplicateVoiture->getId())
            ->generateUrl();

        return $this->redirect($url);
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
