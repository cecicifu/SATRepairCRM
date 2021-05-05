<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Customer;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

final class CustomerAdmin extends AbstractAdmin
{
    protected function createNewInstance(): object
    {
        return new Customer(Uuid::uuid4());
    }

    protected function prePersist(object $object): void
    {
        $object->setCreated(new DateTimeImmutable('now'));
    }

    protected function preUpdate(object $object): void
    {
        $object->setModified(new DateTime('now'));
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('fullname')
            ->add('address')
            ->add('city')
            ->add('email')
            ->add('zipCode')
            ->add('phone')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('fullname')
            ->add('address')
            ->add('city')
            ->add('email')
            ->add('phone')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
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
            ->add('fullname')
            ->add('address', null, [
                'required' => false,
            ])
            ->add('city', null, [
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'required' => false,
            ])
            ->add('zipCode', IntegerType::class, [
                'required' => false,
            ])
            ->add('phone', IntegerType::class)
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('fullname')
            ->add('address')
            ->add('city')
            ->add('email', FieldDescriptionInterface::TYPE_EMAIL)
            ->add('zipCode')
            ->add('phone')
            ->add('modified', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
            ->add('created', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
        ;
    }
}
