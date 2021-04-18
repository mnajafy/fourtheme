<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Security\Voter\UserVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCrudController extends AbstractCrudController
{
    private $adminUrlGenerator;
    private $encoder;
    private $security;

    public function __construct(AdminUrlGenerator $adminUrlGenerator, UserPasswordEncoderInterface $encoder, Security $security)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->encoder = $encoder;
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            EmailField::new('email'),
            TelephoneField::new('phoneNumber')
            // TextEditorField::new('description'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $edit = Action::new('editProfile', null, 'fas fa-edit')
            ->linkToCrudAction('edit')
            ->displayIf(fn (User $user) => $this->security->isGranted(UserVoter::EDIT, $user));
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $edit)
            ->add(Crud::PAGE_DETAIL, $edit);
    }

    public function editPassword(AdminContext $adminContext, Request $request): Response
    {
        $user = $adminContext->getEntity()->getInstance();
        $form = $this->createFormBuilder($user)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'New Password'],
                'second_options' => ['label' => 'Repeat New Password'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            $this->getDoctrine()->getManager()->flush();

            $url = $this->adminUrlGenerator
                // ->unsetAll()
                ->setAction(Action::DETAIL)
                ->setEntityId($user->getId())
                ->generateUrl();

            $this->addFlash('success', 'Updated Password');
            return $this->redirect($url);
        }
        return $this->render('admin/user/editUsername.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
