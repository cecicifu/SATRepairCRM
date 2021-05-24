<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserAdmin extends AbstractAdmin
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(string $code, string $class, string $baseControllerName, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function createNewInstance(): object
    {
        return new User(Uuid::uuid4());
    }

    /**
     * @var User|object|null
     */
    protected function prePersist(object $object): void
    {
        $object->setModified(new DateTime('now'));
        $object->setCreated(new DateTimeImmutable('now'));
        $object->setPassword(
            $this->passwordEncoder->encodePassword(
                $object,
                $object->getPassword()
            )
        );
    }

    /**
     * @var User|object|null
     */
    protected function preUpdate(object $object): void
    {
        $object->setModified(new DateTime('now'));
        $object->setPassword(
            $this->passwordEncoder->encodePassword(
                $object,
                $object->getPassword()
            )
        );
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'created';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('username', null, [
                'global_search' => true,
            ])
            ->add('email', null, [
                'global_search' => true,
            ])
            ->add('lastSession')
            ->add('created')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('username')
            ->add('email', FieldDescriptionInterface::TYPE_EMAIL)
            ->add('roles', FieldDescriptionInterface::TYPE_ARRAY, [
                'display' => 'values',
            ])
            ->add('lastSession', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'buttons' => [
                        'template' => 'fieldtype/list_action.html.twig',
                    ],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('id', null, [
                'disabled' => true,
            ])
            ->add('username')
            ->add('email', EmailType::class, [
                'required' => false,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'mapped' => true,
                'first_options' => ['label' => 'New password'],
                'second_options' => ['label' => 'Confirm new password'],
                'invalid_message' => 'The password fields must match.',
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('username')
            ->add('email', FieldDescriptionInterface::TYPE_EMAIL)
            ->add('roles', FieldDescriptionInterface::TYPE_ARRAY, [
                'display' => 'values',
            ])
            ->add('lastSession', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
            ->add('modified', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
            ->add('created', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
        ;
    }
}
