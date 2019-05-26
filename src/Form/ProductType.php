<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;



class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('price',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('isDiscount', ChoiceType::class, [
                'choices' => ['Select'=>null, 'Yes' => 'Yes', 'No' => 'No'],
                'attr'=>['class'=>'form-control']
            ])
            ->add('discountType', ChoiceType::class, [
                'choices' => ['Select'=>null,'Concrete' => 'Concrete', 'Percentage' => 'Percentage'],
                'attr'=>['class'=>'form-control']
            ])
            ->add('discount',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('sku',TextType::class,[
                'attr'=>['class'=>'form-control'],
                'required'=>false
            ])
            ->add('status', ChoiceType::class, [
                'choices' => ['Active' => 'Active', 'Pending' => 'Pending'],
                'attr'=>['class'=>'form-control']
            ])
            ->add('imageType', ChoiceType::class, [
                'choices' => ['Link' => 'Link', 'Upload' => 'Upload'],
                'attr'=>['class'=>'form-control']
            ])
            ->add('image',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('description', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    //...
                'attr'=>['class'=>'form-control']
                ),
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'csrf_protection' => false,
        ]);
    }
}
