<?php

namespace App\Form;

use App\Entity\Trans;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note')
            ->add('memo')
            ->add('type')
            ->add('amount')
            ->add('dateTime')
            ->add('fee')
            ->add('transAmount')
            ->add('debtId')
            ->add('debtTransId')
            ->add('created')
            ->add('modified')
            ->add('account')
            ->add('category')
            ->add('transferWallet')
            ->add('wallet')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trans::class,
        ]);
    }
}
