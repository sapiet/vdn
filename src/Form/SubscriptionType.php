<?php

namespace App\Form;

use App\Entity\Subscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Services\Date;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('days', ChoiceType::class, [
                'choices' => array_flip(Date::DAYS),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('product', null, [
                'choice_label' => 'designation',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
        ]);
    }
}
