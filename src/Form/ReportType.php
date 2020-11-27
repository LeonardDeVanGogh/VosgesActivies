<?php

namespace App\Form;

use App\Entity\Report;
use App\Entity\ReportReason;
use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('reason', EntityType::class, [
                'multiple'=> false,
                'class' => ReportReason::class,
                'choice_label' => 'reason',
                'label' => 'Raison',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Report::class,
        ]);
    }
}
