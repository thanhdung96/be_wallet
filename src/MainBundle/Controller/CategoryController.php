<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\Category;
use App\MainBundle\Form\CategoryType;
use App\MainBundle\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/", name="category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $this->categoryRepository->findBy([
                'account' => $this->getUser(),
                'active' => true,
            ]),
        ]);
    }

    /**
     * @Route("/new", name="category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $category->setType((int)$request->request->get('category')['type']);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $category->setAccount($this->getUser());

                $entityManager->persist($category);
                $entityManager->flush();

                return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $category = $this->categoryRepository->findOneBy([
            'account' => $this->getUser(),
            'active' => true,
            'id' => $id,
        ]);

        if(!empty($category)){
            return $this->render('category/show.html.twig', [
                'category' => $category,
            ]);
        } else {
            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}/edit", name="category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id): Response
    {
        $category = $this->categoryRepository->findOneBy([
            'account' => $this->getUser(),
            'active' => true,
            'id' => $id,
        ]);

        if(!is_null($category)){
            $form = $this->createForm(CategoryType::class, $category);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('category/edit.html.twig', [
                'category' => $category,
                'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"POST"})
     */
    public function delete(Request $request, $id): Response
    {
        $category = $this->categoryRepository->findOneBy([
            'account' => $this->getUser(),
            'active' => true,
            'id' => $id,
        ]);

        if(!is_null($category)){
            if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $category->setActive(false);

                $entityManager->persist($category);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Wallet removed successfully.'
                );
            }
        }

        return $this->redirectToRoute('category_index', [], Response::HTTP_SEE_OTHER);
    }
}
