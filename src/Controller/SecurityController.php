<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use App\Repository\AccountRepository;
use App\Repository\DefaultCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var DefaultCategoryRepository
     */
    private $defaultCategoryRepository;

    public function __construct(AccountRepository $accountRepository,
                                UserPasswordEncoderInterface $passwordEncoder) {
        $this->accountRepository = $accountRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @required
     */
    public function setDefaultCategoryRepository(DefaultCategoryRepository $defaultCategoryRepository){
        $this->defaultCategoryRepository = $defaultCategoryRepository;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $message = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'message' => $message,
            'message_type' => 'error'
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request): Response{
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

            // add custom user categories
            $userCategories = $this->makeUserCategories($account);
            foreach ($userCategories as $userCategory) {
                $entityManager->persist($userCategory);
            }
            $entityManager->flush();

            $lastUsername = $account->getEmail();

            $this->addFlash(
                'success',
                'Registered successfully'
            );

            return $this->redirectToRoute('app_login', [
                'last_username' => $lastUsername,
            ]);
        }

        return $this->render('security/register.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }


    private function makeUserCategories(Account $account): array{
        $defaultCategories = $this->defaultCategoryRepository->findAll();
        $userCategories = [];

        foreach ($defaultCategories as $defaultCategory) {
            $userCategory = $defaultCategory->toUserCategory();
            $userCategory->setAccount($account);

            $userCategories[] = $userCategory;
        }

        return $userCategories;
    }
}
