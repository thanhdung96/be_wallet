<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountPasswordType;
use App\Form\EditAccountType;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class ProfileController extends AbstractController
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
     * @Route("/profile", name="account_profile", methods={"GET","POST"})
     */
    public function profile(Request $request) :Response{
        $account = $this->getUser();

        $form = $this->createForm(EditAccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('account/edit.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/password", name="account_password", methods={"GET","POST"})
     */
    public function changePassword(Request $request): Response{
        $account = $this->getUser();
        $data = $request->request->get('account_password');
        $form = $this->createForm(AccountPasswordType::class, $account);

        if(!is_null($data)){
            if($this->passwordEncoder->isPasswordValid($account, $data['old_password'])){
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    // encrypt password
                    $account->setPassword(
                        $this->passwordEncoder->encodePassword(
                            $account,
                            $data['password']
                        )
                    );

                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
                }
            } else {
                $this->addFlash(
                    'failure',
                    'Incorrect password'
                );
            }
        }

        return $this->render('account/change_password.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }
}
