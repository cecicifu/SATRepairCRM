<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Repair;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepairType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('imei', IntegerType::class, [
                'required' => false,
            ])
            ->add('pattern', TextType::class, [
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
            ->add('labourPrice', IntegerType::class, [
                'required' => false,
            ])
            ->add('tax', IntegerType::class, [
                'required' => false,
            ])
            ->add('visible', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Repair::class,
        ]);
    }
}
