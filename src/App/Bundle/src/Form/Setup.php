<?php

namespace App\Bundle\Form;

use App\Bundle\Validator\Unique;
use App\Finance\Transaction\BankAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Iban;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Setup extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_iban', TextType::class, [
                'attr' => ['placeholder' => 'Your IBAN'],
                'constraints' => [new Iban(), new Unique([
                    'field' => 'iban',
                    'normalizer' => function ($value) {
                        return strtoupper(str_replace(' ', '', $value));
                    },
                    'class' => BankAccount::class
                ])],
            ])
            ->add('user_name', TextType::class, [
                'attr' => ['placeholder' => 'Your name'],
            ])
        ;
    }
}
