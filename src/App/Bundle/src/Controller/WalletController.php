<?php

namespace App\Bundle\Controller;

use App\Bundle\Form\CreateWalletForm;
use App\Finance\Wallet\Command\CreateWallet;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class WalletController extends Controller
{
    /** @Route("/wallet/add", name="create_wallet") */
    public function create(Request $request)
    {
        $form = $this->createForm(CreateWalletForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateWallet(Uuid::uuid4(), $form['name']->getData(), $form['owner']->getData() ? 'ours' : 'theirs');

            $this->get('command_bus')->handle($command);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('wallet/create.twig', ['form' => $form->createView()]);
    }
}
