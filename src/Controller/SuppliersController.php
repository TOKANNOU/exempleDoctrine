<?php

namespace App\Controller;

use App\Entity\Suppliers;
use App\Form\SuppliersType;
use App\Repository\SuppliersRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/suppliers")
 */
class SuppliersController extends AbstractController
{
    /**
     * @Route("/", name="suppliers_index", methods={"GET"})
     * @param SuppliersRepository $suppliersRepository
     * @param CartService $cartService
     * @return Response
     */
    public function index(SuppliersRepository $suppliersRepository, CartService $cartService): Response
    {
        return $this->render('suppliers/index.html.twig', [
            'suppliers' => $suppliersRepository->findAll(),
            // appel de la fonction getTotal() de la CartService pour calculer le prix total des produits du panier
            'total' => $cartService->getTotal(),
            // appel de la fonction getTotalQuantity() pour le calcul du nombre total de produit dans le panier
            'total_quantity' => $cartService->getTotalQuantity()
        ]);
    }

    /**
     * @Route("/new", name="suppliers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $supplier = new Suppliers();
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplier);
            $entityManager->flush();

            return $this->redirectToRoute('suppliers_index');
        }

        return $this->render('suppliers/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="suppliers_show", methods={"GET"})
     */
    public function show(Suppliers $supplier): Response
    {
        return $this->render('suppliers/show.html.twig', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="suppliers_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Suppliers $supplier
     * @param CartService $cartService
     * @return Response
     */
    public function edit(Request $request, Suppliers $supplier, CartService $cartService): Response
    {
        $form = $this->createForm(SuppliersType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('suppliers_index');
        }

        return $this->render('suppliers/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form->createView(),
            // appel de la fonction getTotalQuantity() pour le calcul du nombre total de produit dans le panier
            'total_quantity' => $cartService->getTotalQuantity()
        ]);
    }

    /**
     * @Route("/{id}", name="suppliers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Suppliers $supplier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($supplier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('suppliers_index');
    }
}
