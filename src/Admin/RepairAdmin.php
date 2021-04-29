<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Repair;
use DateTime;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

final class RepairAdmin extends AbstractAdmin
{
    protected function createNewInstance(): object
    {
        return new Repair(Uuid::uuid4(), "SR-".time(), true);
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
            ->add('code')
            ->add('imei')
            ->add('pattern')
            ->add('fault')
            ->add('colour')
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('code')
            ->add('imei')
            ->add('pattern')
            ->add('fault')
            ->add('colour')
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
            ->add('code', null, ['disabled' => true])
            ->add('imei')
            ->add('pattern')
            ->add('fault')
            ->add('colour', ColorType::class)
            ->add('privateComment')
            ->add('publicComment')
            ->add('labourPrice')
            ->add('tax')
            ->add('visible', CheckboxType::class)
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('code')
            ->add('imei')
            ->add('pattern')
            ->add('fault')
            ->add('colour')
            ->add('privateComment')
            ->add('publicComment')
            ->add('labourPrice')
            ->add('tax')
            ->add('visible')
            ->add('modified')
            ->add('created')
            ;
    }
}
