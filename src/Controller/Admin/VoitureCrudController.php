<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Voiture;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\Date;

class VoitureCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'duplicate';
    public const VOITURE_BASE_PATH = 'uploads/Voiture';
    public const VOITURE_UPLOAD_DIR = 'public/uploads/Voiture';

    public static function getEntityFqcn(): string
    {
        return Voiture::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new(self::ACTION_DUPLICATE)
            ->linkToCrudAction('duplicateMenu')
            ->setCssClass('btn btn-info');

        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user'),
            TextField::new('titre'),
            TextareaField::new('description'),
            MoneyField::new('prix')->setCurrency('EUR'),
            ImageField::new('image')->setBasePath(self::VOITURE_BASE_PATH)
                ->setUploadDir(self::VOITURE_UPLOAD_DIR),
            DateField::new('anneeMiseCirculation'),
            NumberField::new('kilometrage'),
            ImageField::new('galerieImages')->setBasePath(self::VOITURE_BASE_PATH)
                ->setUploadDir(self::VOITURE_UPLOAD_DIR),
            TextField::new('caracteristiques'),
            TextField::new('equipementsOptions'),
        ];
    }

    
private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }






   

    public function duplicateMenu(AdminContext $context, EntityManagerInterface $em, AdminUrlGenerator $adminUrlGenerator): RedirectResponse
    {
        $voiture = $context->getEntity()->getInstance();
        $duplicateVoiture = clone $voiture;

        // Définir l'utilisateur associé
        $duplicateVoiture->setUser($this->getUser());

        parent::persistEntity($em, $duplicateVoiture);

        $url = $adminUrlGenerator->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($duplicateVoiture->getId())
            ->generateUrl();

        return $this->redirect($url);
    }

}