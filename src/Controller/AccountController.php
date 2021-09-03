<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use App\Form\EditAccountType;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(AccountRepository $accountRepository, UserPasswordEncoderInterface $passwordEncoder){
        $this->accountRepository = $accountRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/", name="account_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'accounts' => $this->accountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // encrypt password
            $account->setPassword(
                $this->passwordEncoder->encodePassword(
                    $account,
                    $account->getPassword()
                )
            );

            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('account/new.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="account_show", methods={"GET"})
     */
    public function show(Account $account): Response
    {
        return $this->render('account/show.html.twig', [
            'account' => $account,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Account $account): Response
    {
        $form = $this->createForm(EditAccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encrypt password
            $account->setPassword(
                $this->passwordEncoder->encodePassword(
                    $account,
                    $account->getPassword()
                )
            );

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('account/edit.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, Account $account): Response
    {
        if ($this->isCsrfTokenValid('delete'.$account->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($account);
            $entityManager->flush();
        }

        return $this->redirectToRoute('account_index', [], Response::HTTP_SEE_OTHER);
    }
}
