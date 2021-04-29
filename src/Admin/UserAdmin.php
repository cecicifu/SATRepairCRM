<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
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

    protected function prePersist(object $object): void
    {
        $user = $object->setCreated(new DateTimeImmutable('now'));
        $encoded = $this->passwordEncoder->encodePassword($user, $object->getPassword());
        $object->setPassword($encoded);
    }

    protected function preUpdate(object $object): void
    {
        $user = $object->setModified(new DateTime('now'));
        $encoded = $this->passwordEncoder->encodePassword($user, $object->getPassword());
        $object->setPassword($encoded);
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('username')
            ->add('email')
            ->add('lastSession')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('username')
            ->add('email')
            ->add('lastSession')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('id', null, ['disabled' => true])
            ->add('username')
            ->add('email')
            ->add('password', RepeatedType::class, [
                'type'              => PasswordType::class,
                'required'          => true,
                'mapped'            => true,
                'first_options'     => ['label' => 'New password'],
                'second_options'    => ['label' => 'Confirm new password'],
                'invalid_message' => 'The password fields must match.'
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('username')
            ->add('email')
            ->add('lastSession')
            ->add('modified')
            ->add('created')
        ;
    }
}
