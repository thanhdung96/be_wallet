<?php

namespace App\Controller;

use App\Entity\Trans;
use App\Form\TransType;
use App\Repository\TransRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trans")
 */
class TransController extends AbstractController
{
    /**
     * @Route("/", name="trans_index", methods={"GET"})
     */
    public function index(TransRepository $transRepository): Response
    {
        return $this->render('trans/index.html.twig', [
            'trans' => $transRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="trans_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tran = new Trans();
        $form = $this->createForm(TransType::class, $tran);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tran);
            $entityManager->flush();

            return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trans/new.html.twig', [
            'tran' => $tran,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trans_show", methods={"GET"})
     */
    public function show(Trans $tran): Response
    {
        return $this->render('trans/show.html.twig', [
            'tran' => $tran,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="trans_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Trans $tran): Response
    {
        $form = $this->createForm(TransType::class, $tran);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trans/edit.html.twig', [
            'tran' => $tran,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trans_delete", methods={"POST"})
     */
    public function delete(Request $request, Trans $tran): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tran->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tran);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trans_index', [], Response::HTTP_SEE_OTHER);
    }
}
