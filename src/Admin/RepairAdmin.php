<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Repair;
use App\Entity\Status;
use App\Form\RepairHasProductsType;
use App\Service\RepairService;
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class RepairAdmin extends AbstractAdmin
{
    private RepairService $repairService;

    public function __construct(string $code, string $class, string $baseControllerName, RepairService $repairService)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->repairService = $repairService;
    }

    protected function createNewInstance(): object
    {
        return new Repair(Uuid::uuid4(), "SR-".time(), true);
    }

    /**
     * @var Repair|object|null $object
     */
    protected function prePersist(object $object): void
    {
        $object->setCreated(new DateTimeImmutable('now'));
        if (!$object->getProducts()->isEmpty())  {
            $this->repairService->updateRepairProductAmount($object);
        }
    }

    /**
     * @var Repair|object|null $object
     */
    protected function preUpdate(object $object): void
    {
        $object->setModified(new DateTime('now'));
        if(!$object->getProducts()->isEmpty()) {
            $this->repairService->updateRepairProductAmount($object);
        }
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues[DatagridInterface::SORT_ORDER] = 'DESC';
        $sortValues[DatagridInterface::SORT_BY] = 'created';
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('code')
            ->add('customer')
            ->add('category')
            ->add('status')
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
            ->add('customer', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('category', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('status', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('fault')
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
            ->with('Repair', ['class' => 'col-md-9'])
                ->add('imei', IntegerType::class, [
                    'required' => false,
                ])
                ->add('pattern', null, [
                    'required' => false,
                ])
                ->add('fault', TextareaType::class)
                ->add('colour', ColorType::class, [
                    'required' => false,
                ])
                ->add('privateComment', TextareaType::class, [
                    'required' => false,
                ])
                ->add('publicComment', TextareaType::class, [
                    'required' => false,
                ])
                ->add('labourPrice', MoneyType::class, [
                    'required' => false,
                ])
                ->add('tax', PercentType::class, [
                    'required' => false,
                ])
            ->end()
            ->with('Metadata', ['class' => 'col-md-3'])
                ->add('id', null, [
                    'disabled' => true,
                ])
                ->add('code', null, [
                    'disabled' => true,
                ])
                ->add('customer', EntityType::class, [
                    'class' => Customer::class,
                    'choice_label' => 'fullname',
                    'placeholder' => '',
                ])
                ->add('category', EntityType::class, [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'placeholder' => '',
                ])
                ->add('status', EntityType::class, [
                    'class' => Status::class,
                    'choice_label' => 'name',
                    'placeholder' => '',
                ])
                ->add('visible', CheckboxType::class, [
                    'required' => false,
                ])
            ->end()
            ->with('Products', ['class' => 'col-md-12'])
                ->add('products', CollectionType::class, [
                    'entry_type' => RepairHasProductsType::class,
                    'entry_options' => [
                        'label' => false,
                    ],
                    'label' => false,
                    'mapped' => true,
                    'by_reference' => false,
                    'required' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                ])
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('code')
            ->add('customer', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('category', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('status', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('products', FieldDescriptionInterface::TYPE_ONE_TO_MANY)
            ->add('imei')
            ->add('pattern')
            ->add('fault')
            ->add('colour', 'string', [
                'template' => 'fieldtype/show_colour.html.twig',
            ])
            ->add('privateComment', FieldDescriptionInterface::TYPE_TEXTAREA)
            ->add('publicComment', FieldDescriptionInterface::TYPE_TEXTAREA)
            ->add('labourPrice', FieldDescriptionInterface::TYPE_CURRENCY, [
                'currency' => '€',
            ])
            ->add('tax', FieldDescriptionInterface::TYPE_PERCENT)
            ->add('visible', FieldDescriptionInterface::TYPE_BOOLEAN)
            ->add('modified', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
            ->add('created', FieldDescriptionInterface::TYPE_DATETIME, [
                'timezone' => 'Europe/Madrid',
            ])
        ;
    }
}
