<?php

namespace App\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class CreateWalletForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['placeholder' => 'Name']])
            ->add('owner', CheckboxType::class, [
                'label'    => 'Is this your own wallet?',
                'required' => false,
            ])
        ;
    }
}
