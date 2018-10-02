<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CustomerAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class)
            ->add('address', TextType::class)
            ->add('suburb', TextType::class)
            ->add('zipcode', TextType::class)
            ->add('city', TextType::class)
            /*->add('deliveryMan', EntityType::class, [
                'class' => \App\Entity\DeliveryMan::class
            ])
            ->add('subscriptions', EntityType::class, [
                'class' => \App\Entity\Subscription::class
            ])*/
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('address')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('name')
            ->addIdentifier('address')
            ->addIdentifier('suburb')
            ->addIdentifier('zipcode')
            ->addIdentifier('city')
            ->addIdentifier('deliveryMan')
            ->addIdentifier('subscriptions')
        ;
    }
}
