<?php

namespace App\ApiBundle\Controller;
// https://smoqadam.me/posts/how-to-authenticate-user-in-symfony-5-by-jwt/

use App\MainBundle\Entity\Account;
use App\MainBundle\Repository\AccountRepository;
use App\MainBundle\Repository\CurrencyRepository;
use App\MainBundle\Repository\DefaultCategoryRepository;
use App\MainBundle\Traits\DefaultCategoryTrait;
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
	use DefaultCategoryTrait;

	/**
	 * @var AccountRepository
	 */
	private $accountRepository;

	/**
	 * @var CurrencyRepository
	 */
	private $currencyRepository;

	/**
	 * @var DefaultCategoryRepository
	 */
	private $defaultCategoryRepository;

	public function __construct(AccountRepository $accountRepository, CurrencyRepository $currencyRepository, DefaultCategoryRepository $defaultCategoryRepository) {
		$this->accountRepository = $accountRepository;
		$this->currencyRepository = $currencyRepository;
		$this->defaultCategoryRepository = $defaultCategoryRepository;
	}
	/**
	 * @Route("/register", name="api_register", methods={"POST"})
	 */
	public function register(Request $request, UserPasswordEncoderInterface $encoder): JsonResponse{
		$data = json_decode($request->getContent());
		$account = new Account();

		// check for duplicated email
		$exisedEmailAccount = $this->accountRepository->findOneBy([
			'email' => $data->email
		]);
		if(!is_null($exisedEmailAccount)){
			return new JsonResponse(
				[
					'message' => 'email is already used',
				],
				Response::HTTP_CONFLICT
			);
		}

		$exisedUsernameAccount = $this->accountRepository->findOneBy([
			'name' => $data->username
		]);
		if(!is_null($exisedUsernameAccount)){
			return new JsonResponse(
				[
					'message' => 'username is already used',
				],
				Response::HTTP_CONFLICT
			);
		}

		$account->setEmail($data->email);
		$account->setName($data->username);
		$account->setBalance(0);
		$account->setPassword($encoder->encodePassword($account, $data->password));
		$account->setCurrency(
			$this->currencyRepository->findOneBy([
				'id' => $data->defaultCurrency
			])
		);

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($account);
		$entityManager->flush();

		$userCategories = $this->makeUserCategories(
						$account,
						$this->defaultCategoryRepository->findAll()
					);
		foreach ($userCategories as $userCategory) {
			$entityManager->persist($userCategory);
		}
		$entityManager->flush();

		return new JsonResponse(
			[
				'message' => 'ok'
			],
			Response::HTTP_OK
		);
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
