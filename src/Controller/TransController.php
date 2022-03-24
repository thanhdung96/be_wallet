<?php

namespace App\Controller;

use App\Entity\Trans;
use App\Enums\TransferTypes;
use App\Form\TransType;
use App\Repository\CategoryRepository;
use App\Repository\TransRepository;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/trans")
 */
class TransController extends AbstractController
{
    /**
     * @var WalletRepository
     */
    private $walletRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var TransRepository
     */
    private $transRepository;

    public function __construct(WalletRepository $walletRepository,
                                CategoryRepository $categoryRepository,
                                TransRepository $transRepository){
        $this->walletRepository = $walletRepository;
        $this->categoryRepository = $categoryRepository;
        $this->transRepository = $transRepository;
    }

    /**
     * @Route("/", name="trans_index", methods={"GET"})
     */
    public function index(): Response
    {
        $lstTrans = $this->transRepository->findBy([
                        'account' => $this->getUser(),
                    ]);

        return $this->render('trans/index.html.twig', [
            'trans' => $lstTrans,
        ]);
    }

    /**
     * @Route("/new", name="trans_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tran = new Trans();
        $currentUser = $this->getUser();
        $categories = $this->categoryRepository->findBy([
            'active' => true,
            'account' => $currentUser,
        ]);
        $wallets = $this->walletRepository->findBy([
            'active' => true,
            'account' => $currentUser,
        ]);
        $fromWallet = null;
        $toWallet = null;

        $form = $this->createForm(TransType::class, $tran);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->get('trans');

            if($data['type'] == TransferTypes::EXPENSE){
                $fromWallet = $this->walletRepository->findOneBy([
                    'active' => true,
                    'account' => $currentUser,
                    'id' => $data['wallet']
                ]);
                $fromWallet->setAmount(
                    $fromWallet->getAmount() - $data['amount']
                );
            } else if ($data['type'] == TransferTypes::REVENUE){
                $fromWallet = $this->walletRepository->findOneBy([
                    'active' => true,
                    'account' => $currentUser,
                    'id' => $data['wallet']
                ]);
                $fromWallet->setAmount(
                    $fromWallet->getAmount() + $data['amount']
                );
            } else {
                $fromWallet = $this->walletRepository->findOneBy([
                    'active' => true,
                    'account' => $currentUser,
                    'id' => $data['wallet']
                ]);
                $toWallet = $this->walletRepository->findOneBy([
                    'active' => true,
                    'account' => $currentUser,
                    'id' => $data['transferWallet']
                ]);

                $amount = (int)$data['amount'];
                $fee = 0;
                if(isset($data['withFee'])){
                    $fee = (int)$data['withFee'];
                }

                $fromWallet->setAmount(
                    $fromWallet->getAmount() - $amount - $fee
                );
                $toWallet->setAmount(
                    $toWallet->getAmount() + $amount
                );
            }

            $tran->setAccount($currentUser);
            $tran->setType($data['type']);
            $tran->setCategory($this->categoryRepository->findOneBy([
                'id' => $data['category'],
                'account' => $currentUser,
                'active' => true
            ]));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fromWallet);
            if(!is_null($toWallet)){
                $entityManager->persist($toWallet);
            }
            $entityManager->persist($tran);
            $entityManager->flush();

            return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trans/new.html.twig', [
            'tran' => $tran,
            'wallets' => $wallets,
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trans_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $tran = $this->transRepository->findOneBy([
            'id' => $id,
            'account' => $this->getUser(),
        ]);

        if(is_null($tran)){
            return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('trans/show.html.twig', [
                'tran' => $tran,
                'account' => $this->getUser(),
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="trans_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $tran = $this->transRepository->findOneBy([
            'id' => $id,
            'account' => $this->getUser(),
        ]);

        if(!is_null($tran)){
            $currentUser = $this->getUser();
            $categories = $this->categoryRepository->findBy([
                'active' => true,
                'account' => $currentUser,
            ]);
            $wallets = $this->walletRepository->findBy([
                'active' => true,
                'account' => $currentUser,
            ]);
            $fromWallet = null;
            $toWallet = null;

            $form = $this->createForm(TransType::class, $tran);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('trans/edit.html.twig', [
                'tran' => $tran,
                'wallets' => $wallets,
                'categories' => $categories,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}", name="trans_delete", methods={"POST"})
     */
    public function delete(Request $request, Trans $tran): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tran->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tran);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
    }

    private function undoTransaction(Trans $trans){
        
    }

    private function applyTransaction(Trans $trans){

    }
}
