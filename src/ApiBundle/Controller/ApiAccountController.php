<?php

namespace App\ApiBundle\Controller;

use App\MainBundle\Entity\Account;
use App\MainBundle\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/account")
 */
class ApiAccountController extends AbstractController {
	private const IGNORED_ATTRIBUTES = [
		'password', 'setting',
		'salt', 'created',
		'modified'
	];

	/**
	 * @var AccountRepository
	 */
	private $accountRepository;

	private function getSerializer(): Serializer{
		$encoders = [new JsonEncoder()];
		$normalizers = [new ObjectNormalizer()];

		return new Serializer($normalizers, $encoders);
	}

	private function serializeWalletToJson($data){
		$serialsed = $this->getSerializer()->serialize(
			$data,
			JsonEncoder::FORMAT,
			[AbstractNormalizer::IGNORED_ATTRIBUTES => $this::IGNORED_ATTRIBUTES]
		);

		return json_decode($serialsed, true);
	}

	public function __construct(AccountRepository $accountRepository) {
		$this->accountRepository = $accountRepository;
	}

	/**
	 * @Route("/", name="api_get_account", methods={"POST"})
	 */
	public function getAccount(): JsonResponse{
		return new JsonResponse(
			[
				'account' => $this->serializeWalletToJson(
								$this->getUser()
							)
			],
			Response::HTTP_OK
		);
	}

	/**
	 * @Route("/save", name="api_save_account", methods={"POST"})
	 */
	public function saveAccount(Request $request): JsonResponse{
		$data = json_decode($request->getContent());
		$account = $this->accountRepository->findOneBy([
			'name' => $data->username,
		]);

		if(is_null($account)){
			return new JsonResponse(
				[
					'message' => 'Account not found'
				],
				Response::HTTP_NOT_FOUND
			);
		}

		$account->setEmail($data->email);
		$account->setFirstName($data->firstName);
		$account->setLastName($data->lastName);
		$account->setAddress($data->address->address);
		$account->setCity($data->address->city);
		$account->setCountry($data->address->country);
		$account->setPostal($data->address->postal);
		$account->setAbout($data->about);

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($account);
		$entityManager->flush();

		return new JsonResponse(
			[
				'message' => 'Profile saved successfully'
			],
			Response::HTTP_OK
		);
	}
}
