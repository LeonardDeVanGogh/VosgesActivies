<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('address')
            ->add('owner')
            ->add('latitude')
            ->add('longitude')
            ->add('category', EntityType::class, [
                'multiple'=> true,
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('indoor')
            ->add('outdoor')
            ->add('picture')
            ->add('city')
            ->add('zipcode')
            ->add('street')
            ->add('street_number')
            ->add('is_indoor')
            ->add('is_outdoor')
            ->add('animals')
            ->add('is_handicaped')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
