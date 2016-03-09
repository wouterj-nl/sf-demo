<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Bundle\Form;

use App\Finance\Wallet\WalletRepository;
use App\Finance\Wallet\Wallet;
use App\Finance\Wallet\WalletId;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class BookTransactionForm extends AbstractType
{
    /** @var WalletRepository */
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', EntityType::class, [
                'class'        => Wallet::class,
                'choice_label' => 'name',
            ])
            ->add('to', EntityType::class, [
                'class'        => Wallet::class,
                'choice_label' => 'name',
            ])
            ->add('money', MoneyType::class)
            ->add('date', DateType::class)
            ->add('description', TextType::class)
        ;

        $builder->get('from')->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            if (!$data instanceof WalletId) {
                return;
            }

            $event->setData($this->walletRepository->oneById($data));
        });
    }
}
