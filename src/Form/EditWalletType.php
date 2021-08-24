<?php

namespace App\Form;

use App\Entity\Wallet;
use App\Entity\Account;
use App\Entity\Currency;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditWalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('color', ColorType::class)
            ->add('icon')
            ->add('account', EntityType::class, [
                'class' => Account::class,
                'choice_label' => 'name',
            ])
            ->add('currency', EntityType::class, [
                'class' => Currency::class,
                'choice_label' => 'currencyName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wallet::class,
        ]);
    }
}
