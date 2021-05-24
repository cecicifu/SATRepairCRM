<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Customer;
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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

final class CustomerAdmin extends AbstractAdmin
{
    protected function createNewInstance(): object
    {
        return new Customer(Uuid::uuid4());
    }

    protected function prePersist(object $object): void
    {
		$object->setModified(new DateTime('now'));
        $object->setCreated(new DateTimeImmutable('now'));
    }

    protected function preUpdate(object $object): void
    {
        $object->setModified(new DateTime('now'));
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'created';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('fullname', null, [
                'global_search' => true,
            ])
            ->add('address', null, [
                'global_search' => true,
            ])
            ->add('city', null, [
                'global_search' => true,
            ])
            ->add('email', null, [
                'global_search' => true,
            ])
            ->add('zipCode', null, [
                'global_search' => true,
            ])
            ->add('phone', null, [
                'global_search' => true,
            ])
            ->add('created')
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
            ->add('fullname')
            ->add('phone', IntegerType::class)
            ->add('email', EmailType::class, [
                'required' => false,
            ])
            ->add('address', null, [
                'required' => false,
            ])
            ->add('city', null, [
                'required' => false,
            ])
            ->add('zipCode', IntegerType::class, [
                'required' => false,
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('fullname')
            ->add('phone')
            ->add('email', FieldDescriptionInterface::TYPE_EMAIL)
            ->add('address')
            ->add('city')
            ->add('zipCode')
            ->add('modified', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
            ->add('created', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
        ;
    }
}
