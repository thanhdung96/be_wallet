<?php

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\EditWalletType;
use App\Form\NewWalletType;
use App\Form\WalletType;
use App\Repository\CurrencyRepository;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/wallet")
 */
class WalletController extends AbstractController
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    /**
     * @var WalletRepository
     */
    private $walletRepository;

    public function __construct(CurrencyRepository $currencyRepository, WalletRepository $walletRepository) {
        $this->currencyRepository = $currencyRepository;
        $this->walletRepository = $walletRepository;
    }

    /**
     * @Route("/", name="wallet_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('wallet/index.html.twig', [
            'wallets' => $this->walletRepository->findBy([
                'account' => $this->getUser(),
                'active' => true,
            ]),
        ]);
    }

    /**
     * @Route("/new", name="wallet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // get all supported currency
        $currencies = $this->currencyRepository->findAll();

        $wallet = new Wallet();
        $form = $this->createForm(NewWalletType::class, $wallet);
        $form->handleRequest($request);

        // make current balance equals to initial balance
        $wallet->setAmount($wallet->getInitialAmount());

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCurrency = $this->currencyRepository->find(
                                    $request->request->get('new_wallet')['currency']
                                );
            $wallet->setCurrency($selectedCurrency);
            $wallet->setAccount($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wallet);
            $entityManager->flush();

            return $this->redirectToRoute('wallet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wallet/new.html.twig', [
            'wallet' => $wallet,
            'currencies' => $currencies,
            'defaultCurrency' => $this->getUser()->getCurrency(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wallet_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $wallet = $this->walletRepository->findOneBy([
                'account' => $this->getUser(),
                'id' => $id,
                'active' => true,
            ]);

        if(!empty($wallet)){
            return $this->render('wallet/show.html.twig', [
                'wallet' => $wallet,
            ]);
        } else {
            return $this->redirectToRoute('wallet_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/edit", name="wallet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $wallet = $this->walletRepository->findOneBy([
                'account' => $this->getUser(),
                'id' => $id,
                'active' => true,
            ]);

        $form = $this->createForm(EditWalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wallet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wallet/edit.html.twig', [
            'wallet' => $wallet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wallet_delete", methods={"POST"})
     */
    public function delete(Request $request, $id): Response
    {
        $wallet = $this->walletRepository->findOneBy([
                'account' => $this->getUser(),
                'id' => $id,
                'active' => true,
            ]);

        if(!is_null($wallet)){
            if ($this->isCsrfTokenValid('delete'.$wallet->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $wallet->setActive(false);
                $entityManager->persist($wallet);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Wallet removed successfully.'
                );
                return $this->redirectToRoute('wallet_index', [], Response::HTTP_SEE_OTHER);
            }
        } else {
            return $this->redirectToRoute('wallet_index', [], Response::HTTP_SEE_OTHER);
        }

    }
}
