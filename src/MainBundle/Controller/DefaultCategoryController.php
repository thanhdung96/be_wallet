<?php

namespace App\MainBundle\Controller;

use App\MainBundle\Entity\DefaultCategory;
use App\MainBundle\Form\DefaultCategoryType;
use App\MainBundle\Repository\DefaultCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/category/default")
 */
class DefaultCategoryController extends AbstractController
{
    /**
     * @Route("/", name="default_category_index", methods={"GET"})
     */
    public function index(DefaultCategoryRepository $defaultCategoryRepository): Response
    {
        return $this->render('default_category/index.html.twig', [
            'default_categories' => $defaultCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="default_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $defaultCategory = new DefaultCategory();
        $form = $this->createForm(DefaultCategoryType::class, $defaultCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($defaultCategory);
            $entityManager->flush();

            return $this->redirectToRoute('default_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('default_category/new.html.twig', [
            'default_category' => $defaultCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="default_category_show", methods={"GET"})
     */
    public function show(DefaultCategory $defaultCategory): Response
    {
        return $this->render('default_category/show.html.twig', [
            'default_category' => $defaultCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="default_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DefaultCategory $defaultCategory): Response
    {
        $form = $this->createForm(DefaultCategoryType::class, $defaultCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('default_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('default_category/edit.html.twig', [
            'default_category' => $defaultCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="default_category_delete", methods={"POST"})
     */
    public function delete(Request $request, DefaultCategory $defaultCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$defaultCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($defaultCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('default_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
