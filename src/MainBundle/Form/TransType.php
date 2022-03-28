<?php

namespace App\MainBundle\Form;

use App\MainBundle\Entity\Category;
use App\MainBundle\Entity\Trans;
use App\MainBundle\Entity\Wallet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', TextareaType::class)
            ->add('amount')
            ->add('dateTime', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy HH:mm',
            ))
            ->add('fee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trans::class,
            'allow_extra_fields' => true,
        ]);
    }
}
