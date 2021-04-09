<?php

namespace App\Form;

use App\Entity\ReportReason;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportReasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', TextType::class, [
                'attr'=> [
                    'placeholder' => 'Type de signalement',
                    'class' => 'col-lg-8 mx-auto',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReportReason::class,
        ]);
    }
}
