<?php

namespace App\MainBundle\Controller;

use \DateTime;
use App\MainBundle\Entity\Trans;
use App\MainBundle\Enums\TransferTypes;
use App\MainBundle\Form\TransType;
use App\MainBundle\Repository\CategoryRepository;
use App\MainBundle\Repository\TransRepository;
use App\MainBundle\Repository\WalletRepository;
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

        $form = $this->createForm(TransType::class, $tran);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->get('trans');
            $tran = $this->convertToTransEntity($data);
            $this->applyTransaction($tran);

            $entityManager = $this->getDoctrine()->getManager();
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
        $oldTran = clone $tran;

        if(!is_null($oldTran)){
            $currentUser = $this->getUser();
            $categories = $this->categoryRepository->findBy([
                'active' => true,
                'account' => $currentUser,
            ]);
            $wallets = $this->walletRepository->findBy([
                'active' => true,
                'account' => $currentUser,
            ]);

            $form = $this->createForm(TransType::class, $tran);

            if ($request->isMethod('POST')){
                // use form submit instead of form handle request
                // to prevent symfony to persist
                $form->submit($request->request->get($form->getName()));
                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $request->get('trans');

                    // create new transaction based on submitted data in request
                    $newTran = $this->convertToTransEntity($data);

                    // apply transaction after undoing the old one
                    $this->undoTransaction($oldTran);
                    $this->applyTransaction($newTran);

                    // then persist
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->flush();

                    return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
                }
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
    public function delete(Request $request, $id): Response
    {
        $trans = $this->transRepository->findOneBy([
            'id' => $id,
            'account' => $this->getUser(),
        ]);

        if(!is_null($trans)){
            if ($this->isCsrfTokenValid('delete'.$trans->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $this->undoTransaction($trans);
                $entityManager->remove($trans);
                $entityManager->flush();
            }
            return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);

        } else {
            return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    private function undoTransaction(Trans $trans){
        $fromWallet = $trans->getWallet();
        $toWallet = null;

        if($trans->getType() == TransferTypes::REVENUE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() - $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::EXPENSE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() + $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::TRANSFER){
            $toWallet = $trans->getTransferWallet();
            $fee = $trans->getFee();

            $fromWallet->setAmount(
                $fromWallet->getAmount() + $trans->getAmount() + $fee
            );
            $toWallet->setAmount(
                $toWallet->getAmount() - $trans->getAmount()
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fromWallet);
        if(!is_null($toWallet)){
            $entityManager->persist($toWallet);
        }
        $entityManager->flush();
    }

    private function applyTransaction(Trans $trans){
        $fromWallet = $trans->getWallet();
        $toWallet = null;

        if($trans->getType() == TransferTypes::REVENUE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() + $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::EXPENSE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() - $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::TRANSFER){
            $toWallet = $trans->getTransferWallet();
            $fee = $trans->getFee();

            $fromWallet->setAmount(
                $fromWallet->getAmount() - $trans->getAmount() - $fee
            );
            $toWallet->setAmount(
                $toWallet->getAmount() + $trans->getAmount()
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fromWallet);
        if(!is_null($toWallet)){
            $entityManager->persist($toWallet);
        }
        $entityManager->flush();
    }

    private function convertToTransEntity(array $data): ?Trans{
        $trans = new Trans();
        $currentUser = $this->getUser();

        $trans->setId($data['id']);
        $trans->setType($data['type']);
        $trans->setWallet($this->walletRepository->findOneBy([
            'id' => $data['wallet'],
            'active' => true,
            'account' => $currentUser
        ]));
        if($trans->getType() == TransferTypes::TRANSFER){
            $trans->setTransferWallet($this->walletRepository->findOneBy([
                'id' => $data['transferWallet'],
                'active' => true,
                'account' => $currentUser
            ]));
            if(isset($data['withFee'])){
                $trans->setFee((int)$data['fee']);
            }
        }
        $trans->setAmount((int)$data['amount']);
        $trans->setNote($data['note']);
        $trans->setCategory($this->categoryRepository->findOneBy([
            'id' => $data['category'],
            'active' => true,
            'account' => $currentUser
        ]));
        $dateTime = DateTime::createFromFormat('d-m-Y H:i', $data['dateTime']);
        $trans->setDateTime($dateTime);
        $trans->setAccount($currentUser);

        return $trans;
    }
}
