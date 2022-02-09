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

class NewWalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('color', ColorType::class)
            ->add('initialAmount')
            ->add('icon')
            /*->add('account', EntityType::class, [
                'class' => Account::class,
                'choice_label' => 'name',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wallet::class,
            'allow_extra_fields' => true,
        ]);
    }
}
