<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Status;
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
use Symfony\Component\Form\Extension\Core\Type\ColorType;

/** @extends AbstractAdmin<object> */
final class StatusAdmin extends AbstractAdmin
{
    protected function createNewInstance(): object
    {
        return new Status(Uuid::uuid4());
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
            ->add('name', null, [
                'global_search' => true,
            ])
            ->add('colour')
            ->add('created')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('name')
            ->add('colour', 'string', [
                'template' => 'fieldtype/list_colour.html.twig',
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
            ->add('name')
            ->add('colour', ColorType::class)
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('name')
            ->add('colour', 'string', [
                'template' => 'fieldtype/show_colour.html.twig',
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
