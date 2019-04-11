<?php

namespace App\Form;

use App\Entity\ConfirmVote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmVoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class)
            ->add('Description', TextareaType::class)
            ->add('Date', \Symfony\Component\Form\Extension\Core\Type\DateTimeType::class, ['years' => range(2019,2026)])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConfirmVote::class,
        ]);
    }
}
