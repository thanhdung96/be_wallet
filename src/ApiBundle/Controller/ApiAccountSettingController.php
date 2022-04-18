<?php

namespace App\ApiBundle\Controller;

use App\MainBundle\Entity\AccountSetting;
use App\MainBundle\Repository\AccountSettingRepository;
use App\MainBundle\Repository\CurrencyRepository;
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
 * @Route("/api/setting")
 */
class ApiAccountSettingController extends AbstractController {
	private const IGNORED_ATTRIBUTES = ['created', 'modified', 'account'];

	/**
	 * @var AccountSettingRepository
	 */
	private $accountSettingRepository;

	/**
	 * @var CurrencyRepository
	 */
	private $currencyRepository;

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

	/**
	 * @required
	 */
	public function setCurrencyRepository(CurrencyRepository $currencyRepository) {
		$this->currencyRepository = $currencyRepository;
	}

	public function __construct(AccountSettingRepository $accountSettingRepository) {
		$this->accountSettingRepository = $accountSettingRepository;
	}

	/**
	 * @Route("/", name="api_get_setting", methods={"POST"})
	 */
	public function getAccountSetting(): JsonResponse{
		$setting = $this->accountSettingRepository->findOneBy([
			'account' => $this->getUser()
		]);

		if(is_null($setting)){
			$setting = new AccountSetting();
		}

		return new JsonResponse(
			[
				'setting' => $this->serializeWalletToJson($setting)
			],
			Response::HTTP_OK
		);
	}

	/**
	 * @Route("/save", name="api_save_setting", methods={"POST"})
	 */
	public function saveAccountSetting(Request $request): JsonResponse{
		$data = json_decode($request->getContent());
		$accountSetting = null;

		if($data->id == -1){
			$accountSetting = new AccountSetting();

			$accountSetting->setAccount($this->getUser());
		} else {
			$accountSetting = $this->accountSettingRepository->findOneBy([
				'id' => $data->id,
				'account' => $this->getUser()
			]);

			if(is_null($accountSetting)){
				return new JsonResponse(
					[
						'message' => 'Account setting not found'
					],
					Response::HTTP_NOT_FOUND
				);
			}
		}

		$accountSetting->setDarkMode($data->darkMode);
		$accountSetting->setLanguage($data->language);
		$accountSetting->setCurrency(
			$this->currencyRepository->findOneBy([
				'id' => $data->currency
			])
		);

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($accountSetting);
		$entityManager->flush();

		return new JsonResponse(
			[
				'message' => 'Setting saved successfully',
			],
			Response::HTTP_OK
		);
	}
}
