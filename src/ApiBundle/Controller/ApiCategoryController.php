<?php

namespace App\ApiBundle\Controller;

use App\MainBundle\Entity\Category;
use App\MainBundle\Form\CategoryType;
use App\MainBundle\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/category")
 */
class ApiCategoryController extends AbstractController {
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
     * @Route("/", name="api_category_index")
     */
    public function getAllCategories() {
        $lstCategories = $this->categoryRepository->findBy([
            'account' => $this->getUser(),
            'active' => true,
        ]);

        return $this->json(
            $this->getSerializer()->serialize($this->getUser(), 'json'),
            empty($lstCategories) ? Response::HTTP_NOT_FOUND : Response::HTTP_OK,
            [
                "Content-Type" => "application/json"
            ]
        );
    }
}
