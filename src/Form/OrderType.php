<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => ['Pending' => 'Pending', 'Confirmed' => 'Confirmed', 'Delivered'=>'Delivered', 'Canceled'=>'Canceled' ],
                'attr'=>['class'=>'form-control']
            ])
            ->add('fullName',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('email',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('contactNumber',TextType::class,['attr'=>['class'=>'form-control'],'required'=>false])
            ->add('postalCode',TextType::class,['attr'=>['class'=>'form-control'],'required'=>false])
            ->add('shippingAddress',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('city',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('country',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('adminNotes',TextType::class,['attr'=>['class'=>'form-control'],'required'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
