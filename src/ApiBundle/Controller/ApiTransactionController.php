<?php

namespace App\ApiBundle\Controller;

use App\MainBundle\Repository\CategoryRepository;
use App\MainBundle\Repository\TransRepository;
use App\MainBundle\Repository\WalletRepository;
use App\MainBundle\Traits\ApplyTransTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/transaction")
 */
class ApiTransactionController extends AbstractController{
	use ApplyTransTrait;

	private const IGNORED_ATTRIBUTES = ['created', 'modified', 'account'];

	/**
	 * @var TransRepository
	 */
	private $transRepository;

	/**
	 * @var CategoryRepository
	 */
	private $categoryRepository;

	/**
	 * @var WalletRepository
	 */
	private $walletRepository;
	
	private function getSerializer(): Serializer{
		$encoders = [new JsonEncoder()];
		$normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];

		return new Serializer($normalizers, $encoders);
	}

	private function serializeTransactionToJson($transaction){
		$serialsed = $this->getSerializer()->serialize(
			$transaction,
			JsonEncoder::FORMAT,
			[
				AbstractNormalizer::IGNORED_ATTRIBUTES => $this::IGNORED_ATTRIBUTES,
				DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'
			]
		);

		return json_decode($serialsed, true);
	}

	public function __construct(TransRepository $transRepository){
		$this->transRepository = $transRepository;
	}

	/**
	 * @required
	 */
	public function setCategoryRepository(CategoryRepository $categoryRepository) {
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * @required
	 */
	public function setWalletRepository(WalletRepository $walletRepository) {
		$this->walletRepository = $walletRepository;
	}

	/**
	 * @Route("/", name="api_trans_index", methods={"POST"})
	 */
	public function getAllTrans(): JsonResponse{
		$lstTrans = $this->transRepository->findBy(
			[
				'account' => $this->getUser(),
			],
			[
				'dateTime' => 'DESC',
			]
		);
		
		return new JsonResponse(
			[
				'transactions' => $this->serializeTransactionToJson($lstTrans)
			],
			Response::HTTP_OK
		);
	}

	/**
	 * @Route("/detail", name="api_trans_detail", methods={"POST"})
	 */
	public function getTransDetail(Request $request): JsonResponse{
		$data = json_decode($request->getContent());
		$transaction = $this->transRepository->findOneBy([
			'id' => $data->id,
			'account' => $this->getUser()
		]);

		if(is_null($transaction)){
			return new JsonResponse(
				[
					'message' => 'Transaction not found.'
				],
				Response::HTTP_NOT_FOUND
			);
		}

		return new JsonResponse(
			[
				'transaction' => $this->serializeTransactionToJson($transaction)
			],
			Response::HTTP_OK
		);
	}

	/**
	 * @Route("/save", name="api_trans_save", methods={"POST"})
	 */
	public function saveTransaction(Request $request): JsonResponse{
		$repositories = [
			'walletRepo' => $this->walletRepository,
			'cateRepo' => $this->categoryRepository,
		];

		$decodedData = json_decode($request->getContent());
		$data = $decodedData->transaction;
		$isNew = $decodedData->isNew;
		$transaction = $this->convertToTransEntity((array)$data, $repositories);
		$entityManager = $this->getDoctrine()->getManager();

		// if this transaction is a new one
		if($isNew) {
			$this->applyTransaction($transaction, $entityManager);
			$transaction->setAccount($this->getUser());
			$entityManager->persist($transaction);
			$entityManager->flush();
		} else {
			$oldTransaction = $this->transRepository->findOneBy([
				'id' => $transaction->getId(),
				'account' => $this->getUser(),
			]);

			if(is_null($oldTransaction)){
				return new JsonResponse(
					[
						'message' => 'Transaction not found.'
					],
					Response::HTTP_NOT_FOUND
				);
			} else {
				$this->undoTransaction($oldTransaction, $entityManager);
				$this->applyTransaction($transaction, $entityManager);
				$transaction->setAccount($this->getUser());

				$entityManager->remove($oldTransaction);
				$entityManager->persist($transaction);
				$entityManager->flush();
			}
		}

		return new JsonResponse(
			[
				'message' => 'Transaction saved successfully.'
			],
			Response::HTTP_OK
		);
	}
}
