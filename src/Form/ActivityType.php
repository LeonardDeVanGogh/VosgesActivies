<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\NumberType;




class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('latitude')
            ->add('longitude')
            ->add('picture', FileType::class, [
                'label'=>'image au format .jpeg',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                        'mimeTypes' => [
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Merci d\'enregistrer une image au format .jpeg',
                    ])
                ],
            ])
            ->add('city')
            ->add('zipcode', NumberType::class)
            ->add('street')
            ->add('street_number')
            ->add('category', EntityType::class, [
                'multiple'=> true,
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->andWhere('a.deleted_at is NULL');
                },
            ])
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
