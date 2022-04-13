<?php

namespace App\ApiBundle\Controller;

use App\MainBundle\Entity\Wallet;
use App\MainBundle\Repository\CurrencyRepository;
use App\MainBundle\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/wallet")
 */
class ApiWalletController extends AbstractController{
	private const IGNORED_ATTRIBUTES = ['created', 'modified', 'account'];

	/**
	 * @var WalletRepository
	 */
	private $walletRepository;

	/**
	 * @var CurrencyRepository
	 */
	private $currencyRepository;

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

	public function __construct(WalletRepository $walletRepository){
		$this->walletRepository = $walletRepository;
	}

	/**
	 * @required
	 */
	public function setCurrencyRepository(CurrencyRepository $currencyRepository){
		$this->currencyRepository = $currencyRepository;
	}

	/**
	 * @Route("/", name="api_wallet_index", methods={"POST"})
	 */
	public function getAllWallets(): JsonResponse{
		$lstWallets = $this->walletRepository->findBy([
			'account' => $this->getUser(),
			'active' => true
		]);
		
		return new JsonResponse(
			[
				'wallets' => $this->serializeWalletToJson($lstWallets)
			],
			Response::HTTP_OK
		);
	}

	/**
	 * @Route("/detail", name="api_wallet_detail", methods={"POST"})
	 */
	public function getWalletDetail(Request $request): JsonResponse{
		$data = json_decode($request->getContent());
		$wallet = $this->walletRepository->findOneBy([
			'id' => $data->id,
			'account' => $this->getUser(),
			'active' => true,
		]);

		if(!is_null($wallet)){
			return new JsonResponse(
				[
					'wallet' => $this->serializeWalletToJson($wallet)
				],
				Response::HTTP_OK
			);
		}else{
			return new JsonResponse(
				[
					'wallet' => '',
				],
				Response::HTTP_NOT_FOUND
			);
		}

	}

	/**
	 * @Route("/save", name="api_wallet_save", methods={"POST"})
	 */
	public function saveWallet(Request $request): JsonResponse{
		$data = json_decode($request->getContent());
		$wallet = null;

		if ($data->id == -1) {
			$wallet = new Wallet();

			$wallet->setAccount($this->getUser());
		} else {
			$wallet = $this->walletRepository->findOneBy([
				'id' => $data->id,
				'account' => $this->getUser(),
				'active' => true,
			]);

			if(is_null($wallet)){
				return new JsonResponse(
					[
						'message' => 'wallet not found',
					],
					Response::HTTP_NOT_FOUND
				);
			}
		}

		$wallet->setName($data->name);
		$wallet->setAmount($data->amount);
		$wallet->setIcon($data->amount);
		$wallet->setColor($data->color);
		$wallet->setCurrency(
			$this->currencyRepository->findOneBy([
				'id' => $data->currency
			])
		);

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($wallet);
		$entityManager->flush();

		return new JsonResponse(
			[
				'wallet' => $this->serializeWalletToJson($wallet),
			],
			Response::HTTP_OK
		);
	}
}
