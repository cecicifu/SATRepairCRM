<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Product;
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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

final class ProductAdmin extends AbstractAdmin
{
    protected function createNewInstance(): object
    {
        return new Product(Uuid::uuid4());
    }

    protected function prePersist(object $object): void
    {
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
            ->add('name')
            ->add('amount')
            ->add('price')
            ->add('created')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
            ->add('amount')
            ->add('price', FieldDescriptionInterface::TYPE_CURRENCY, [
                'currency' => '€',
            ])
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
            ->add('name')
            ->add('amount', IntegerType::class)
            ->add('price', MoneyType::class, [
                'required' => false,
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('amount')
            ->add('price', FieldDescriptionInterface::TYPE_CURRENCY, [
                'currency' => '€',
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
