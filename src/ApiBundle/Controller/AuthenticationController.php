<?php

namespace App\ApiBundle\Controller;
// https://smoqadam.me/posts/how-to-authenticate-user-in-symfony-5-by-jwt/

use App\MainBundle\Entity\Account;
use App\MainBundle\Repository\AccountRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api/auth")
 */
class AuthenticationController extends AbstractController {
	/**
	 * @var AccountRepository
	 */
	private $accountRepository;

	public function __construct(AccountRepository $accountRepository) {
		$this->accountRepository = $accountRepository;
	}
	/**
	 * @Route("/register", name="api_register", methods={"POST"})
	 */
	public function register(Request $request, UserPasswordEncoderInterface $encoder): JsonResponse{
		// temporary code
		$password = $request->get('password');
		$email = $request->get('email');
		$user = new User();
		$user->setPassword($encoder->encodePassword($user, $password));
		$user->setEmail($email);
		$em = $this->getDoctrine()->getManager();
		$em->persist($user);
		$em->flush();
		return $this->json([
			'user' => $user->getEmail()
		]);
	}

	/**
	 * @Route("/login", name="api_login", methods={"POST"})
	 */
	public function login(Request $request, UserPasswordEncoderInterface $encoder): JsonResponse{
		$data = json_decode($request->getContent());
		$account = null;
		// user can either authenticate with email or username
		if(strpos($data->email, '@') !== false) {
			$account = $this->accountRepository->findOneBy([
                'email' => $data->email,
	        ]);
		} else {
			$account = $this->accountRepository->findOneBy([
                'name' => $data->email,
	        ]);
		}

        if (!$account || !$encoder->isPasswordValid($account, $data->password)) {
            return new JsonResponse(
				[
					'message' => 'email or password is incorrect.',
				],
				Response::HTTP_NOT_FOUND
			);
        }

		// the authentication token always has email value to authenticate in next steps
       $payload = [
           "account" => $account->getUsername(),
           "exp"  => (new \DateTime())->modify("+5 minutes")->getTimestamp(),
       ];
        $jwt = JWT::encode($payload, $this->getParameter('jwt_secret'), 'HS512');

        return new JsonResponse(
			[
				'token' => sprintf('Bearer %s', $jwt),
				'username' => $account->getName(),
			],
			Response::HTTP_OK
		);
	}
}
