<?php

namespace App\ApiBundle\Controller;
// https://smoqadam.me/posts/how-to-authenticate-user-in-symfony-5-by-jwt/

use App\MainBundle\Entity\Account;
use App\MainBundle\Repository\AccountRepository;
use App\MainBundle\Repository\CurrencyRepository;
use App\MainBundle\Repository\DefaultCategoryRepository;
use App\MainBundle\Traits\DefaultCategoryTrait;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/auth")
 */
class AuthenticationController extends AbstractController {
	private const IGNORED_ATTRIBUTES = ['created', 'modified', 'account'];

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

	private function getSerializer(): Serializer{
		$encoders = [new JsonEncoder()];
		$normalizers = [new ObjectNormalizer()];

		return new Serializer($normalizers, $encoders);
	}

	private function serializeWalletToJson($wallet){
		$serialsed = $this->getSerializer()->serialize(
			$wallet,
			JsonEncoder::FORMAT,
			[AbstractNormalizer::IGNORED_ATTRIBUTES => $this::IGNORED_ATTRIBUTES]
		);

		return json_decode($serialsed, true);
	}

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
		$accessPayload = [
			"account" => $account->getName(),
			"exp"  => (new \DateTime())->modify("+60 minutes")->getTimestamp(),
		];
		$accessToken = JWT::encode($accessPayload, $this->getParameter('jwt_secret'), 'HS512');
		
		$refreshPayload = [
			"account" => $account->getName(),
			"exp"  => (new \DateTime())->modify("+24 hours")->getTimestamp(),
		];
		$refreshToken = JWT::encode($refreshPayload, $this->getParameter('jwt_secret'), 'HS256');

		return new JsonResponse(
			[
				'token' =>
					[
						'token' => sprintf('Bearer %s', $accessToken),
						'refreshToken' => $refreshToken,
						'username' => $account->getName(),
					],
				'setting' => $this->serializeWalletToJson($account->getSetting())
			],
			Response::HTTP_OK
		);
	}

	/**
	 * @Route("/refresh", name="api_refresh", methods={"POST"})
	 */
	public function refreshAccessToken(Request $request): JsonResponse{
		$data = json_decode($request->getContent());

		try{
			$jwt = (array)JWT::decode(
				$data->refreshToken,
				new Key(
					$this->getParameter('jwt_secret'),
					'HS256'
				)
			);

			// if the username decoded in the token is different from username sent along with the request
			// reject the request
			if($jwt['account'] != $data->username){
				return new JsonResponse(
					[
						'message' => 'Malformed token',
					],
					Response::HTTP_UNAUTHORIZED
				);
			} else {
				$accessPayload = [
					"account" => $data->username,
					"exp"  => (new \DateTime())->modify("+60 minutes")->getTimestamp(),
				];
				$accessToken = JWT::encode($accessPayload, $this->getParameter('jwt_secret'), 'HS512');

				return new JsonResponse(
					[
						'token' => sprintf('Bearer %s', $accessToken),
						'refreshToken' => $data->refreshToken,
						'username' => $data->username,
					],
					Response::HTTP_OK
				);
			}
		} catch (\Exception $exception){
			return new JsonResponse(
				[
					'message' => $exception->getMessage(),
				],
				Response::HTTP_UNAUTHORIZED
			);
		}
	}
}
