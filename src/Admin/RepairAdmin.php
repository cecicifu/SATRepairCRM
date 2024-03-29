<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Repair;
use App\Entity\Status;
use App\Form\RepairHasProductsType;
use App\Message\NewRepairCreated;
use App\Message\StatusHasChanged;
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
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Messenger\MessageBusInterface;

/** @extends AbstractAdmin<object> */
final class RepairAdmin extends AbstractAdmin
{
    private RepairService $repairService;
    private MessageBusInterface $messageBus;

    private const EMAIL_DISPATCHER = false;

    private object $oldObject;

    public function __construct(
        string $code,
        string $class,
        string $baseControllerName,
        RepairService $repairService,
        MessageBusInterface $messageBus
    ) {
        parent::__construct($code, $class, $baseControllerName);
        $this->repairService = $repairService;
        $this->messageBus = $messageBus;
    }

    protected function createNewInstance(): object
    {
        return new Repair(Uuid::uuid4(), 'SR-'.time(), true);
    }

    protected function alterObject(object $object): void
    {
        $this->oldObject = clone $object;
    }

    protected function prePersist(object $object): void
    {
        $object->setModified(new DateTime('now'));
        $object->setCreated(new DateTimeImmutable('now'));

        /* @var Repair $object */
        if (!$object->getProducts()->isEmpty()) {
            $this->repairService->updateRepairProductAmount($object);
        }
    }

    protected function postPersist(object $object): void
    {
        if ($object->getCustomer()->getEmail() && self::EMAIL_DISPATCHER) {
            $this->messageBus->dispatch(new NewRepairCreated($object->getCustomer()->getEmail(), $object->getCode()));
        }
    }

    protected function preUpdate(object $object): void
    {
        $object->setModified(new DateTime('now'));

        /* @var Repair $object */
        if (!$object->getProducts()->isEmpty()) {
            $this->repairService->updateRepairProductAmount($object);
        }
    }

    protected function postUpdate(object $object): void
    {
        if ($object->getCustomer()->getEmail() && ($this->oldObject->getStatus() !== $object->getStatus()) && self::EMAIL_DISPATCHER) {
            $this->messageBus->dispatch(new StatusHasChanged($object->getCustomer()->getEmail(), $object->getCode(), $object->getStatus()->getName()));
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
            ->add('code', null, [
                'global_search' => true,
            ])
            ->add('customer')
            ->add('category')
            ->add('status')
            ->add('imei', null, [
                'global_search' => true,
            ])
            ->add('pattern', null, [
                'global_search' => true,
            ])
            ->add('fault', null, [
                'global_search' => true,
            ])
            ->add('colour', null, [
                'global_search' => true,
            ])
            ->add('created')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('code', 'string', [
                'template' => 'fieldtype/list_code.html.twig',
            ])
            ->add('customer', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('category', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('fault')
            ->add('status', FieldDescriptionInterface::TYPE_MANY_TO_ONE, [
                'template' => 'fieldtype/list_status.html.twig',
            ])
            ->add('created')
            ->add('documents', 'actions', [
                'actions' => [
                    'document' => [
                        'template' => 'document/list_action.html.twig',
                    ],
                ],
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
            ->tab('repair')
                ->with('metadata', ['class' => 'col-md-3'])
                    ->add('id', TextType::class, [
                        'disabled' => true,
                    ])
                    ->add('code', TextType::class, [
                        'disabled' => true,
                    ])
                    ->add('customer', ModelAutocompleteType::class, [
                        'class' => Customer::class,
                        'property' => 'fullname',
                        'minimum_input_length' => 0,
                        'cache' => true,
                    ])
                    ->add('category', ModelAutocompleteType::class, [
                        'class' => Category::class,
                        'property' => 'name',
                        'minimum_input_length' => 0,
                        'cache' => true,
                    ])
                    ->add('status', ModelAutocompleteType::class, [
                        'class' => Status::class,
                        'property' => 'name',
                        'minimum_input_length' => 0,
                        'cache' => true,
                    ])
                    ->add('visible', CheckboxType::class, [
                        'required' => false,
                    ])
                ->end()
                ->with('info', ['class' => 'col-md-9'])
                    ->add('fault', TextareaType::class)
                    ->add('imei', IntegerType::class, [
                        'required' => false,
                    ])
                    ->add('pattern', TextType::class, [
                        'required' => false,
                    ])
                    ->add('colour', ColorType::class, [
                        'required' => false,
                    ])
                    ->add('privateComment', TextareaType::class, [
                        'required' => false,
                    ])
                    ->add('publicComment', TextareaType::class, [
                        'required' => false,
                    ])
                ->end()
            ->end()
            ->tab('extra')
                ->with('', ['class' => 'col-md-12'])
                    ->add('labourPrice', MoneyType::class, [
                        'required' => false,
                    ])
                    ->add('tax', PercentType::class, [
                        'required' => false,
                    ])
                    ->add('products', CollectionType::class, [
                        'entry_type' => RepairHasProductsType::class,
                        'entry_options' => [
                            'label' => false,
                        ],
                        'label' => 'Products',
                        'mapped' => true,
                        'by_reference' => false,
                        'required' => true,
                        'allow_add' => true,
                        'allow_delete' => true,
                    ])
                ->end()
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('code')
            ->add('visible', FieldDescriptionInterface::TYPE_BOOLEAN)
            ->add('customer', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('category', FieldDescriptionInterface::TYPE_MANY_TO_ONE)
            ->add('status', FieldDescriptionInterface::TYPE_MANY_TO_ONE, [
                'template' => 'fieldtype/show_status.html.twig',
            ])
            ->add('fault')
            ->add('imei')
            ->add('pattern')
            ->add('colour', 'string', [
                'template' => 'fieldtype/show_colour.html.twig',
            ])
            ->add('privateComment', FieldDescriptionInterface::TYPE_TEXTAREA)
            ->add('publicComment', FieldDescriptionInterface::TYPE_TEXTAREA)
            ->add('labourPrice', FieldDescriptionInterface::TYPE_CURRENCY, [
                'currency' => '€',
            ])
            ->add('tax', FieldDescriptionInterface::TYPE_PERCENT)
            ->add('products', FieldDescriptionInterface::TYPE_ONE_TO_MANY, [
                'template' => 'fieldtype/show_products.html.twig',
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
