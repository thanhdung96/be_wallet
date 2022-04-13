<?php

namespace App\ApiBundle\Controller;

use App\MainBundle\Entity\Category;
use App\MainBundle\Repository\CategoryRepository;
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
 * @Route("/api/category")
 */
class ApiCategoryController extends AbstractController {
	private const IGNORED_ATTRIBUTES = ['created', 'modified', 'account'];

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    private function getSerializer(): Serializer{
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

	/**
	 * @Route("/", name="api_category_index", methods={"POST"})
	 */
	 public function getAllCategories(Request $request) {
		$lstCategories = $this->categoryRepository->findBy([
			'account' => $this->getUser(),
			'active' => true,
		]);
		$serialsed = $this->getSerializer()->serialize(
			$lstCategories,
			JsonEncoder::FORMAT,
			[AbstractNormalizer::IGNORED_ATTRIBUTES => $this::IGNORED_ATTRIBUTES]
		);

		return new JsonResponse(
			[
				'categories' => json_decode($serialsed, true)
			],
			Response::HTTP_OK
		);
    }

	/**
	 * @Route("/detail", name="api_category_detail", methods={"POST"})
	 */
	public function getCategoryDetail(Request $request){
		$data = json_decode($request->getContent());
		$category = $this->categoryRepository->findOneBy([
			'id' => $data->id,
			'account' => $this->getUser(),
			'active' => true,
		]);

		if(!is_null($category)){
			$serialsed = $this->getSerializer()->serialize(
				$category,
				JsonEncoder::FORMAT,
				[AbstractNormalizer::IGNORED_ATTRIBUTES => $this::IGNORED_ATTRIBUTES]
			);
			return new JsonResponse(
				[
					'category' => json_decode($serialsed, true),
				],
				Response::HTTP_OK
			);
		}else{
			return new JsonResponse(
				[
					'category' => '',
				],
				Response::HTTP_NOT_FOUND
			);
		}
	}

	/**
	 * @Route("/save", name="api_category_save", methods={"POST"})
	 */
	public function saveCategory(Request $request){
		$data = json_decode($request->getContent());
		$category = null;

		if ($data->id == -1) {
			$category = new Category();

			$category->setType($data->type);
			$category->setAccount($this->getUser());
		} else {
			$category = $this->categoryRepository->findOneBy([
				'id' => $data->id,
				'account' => $this->getUser(),
				'active' => true,
			]);

			if(is_null($category)){
				return new JsonResponse(
					[
						'message' => 'category not found',
					],
					Response::HTTP_NOT_FOUND
				);
			}
		}

		$category->setName($data->name);
		$category->setColor($data->colour);
		
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($category);
		$entityManager->flush();

		$serialsed = $this->getSerializer()->serialize(
			$category,
			JsonEncoder::FORMAT,
			[AbstractNormalizer::IGNORED_ATTRIBUTES => $this::IGNORED_ATTRIBUTES]
		);
		return new JsonResponse(
			[
				'category' => json_decode($serialsed, true),
			],
			Response::HTTP_OK
		);
	}
}
