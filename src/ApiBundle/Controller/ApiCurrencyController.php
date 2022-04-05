<?php

namespace App\ApiBundle\Controller;

use App\MainBundle\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/currency")
 */
class ApiCurrencyController extends AbstractController {
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    private function getSerializer(): Serializer{
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    public function __construct(CurrencyRepository $currencyRepository){
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @Route("/", name="api_currency_index")
     */
    public function getAllCategories() {
        $lstCategories = $this->currencyRepository->findAll();
		$serialsed = $this->getSerializer()->serialize($lstCategories, 'json');

        return new JsonResponse(
			[
				'currencies' => json_decode($serialsed, true),
			],
			Response::HTTP_OK
		);
    }
}
