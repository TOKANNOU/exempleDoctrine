<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="products_index", methods={"GET"})
     * @param ProductsRepository $productsRepository
     * @param CartService $cartService
     * @return Response
     */
    public function index(ProductsRepository $productsRepository, CartService $cartService): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
            // appel de la fonction getTotalQuantity() pour le calcul du nombre total de produit dans le panier
            'total_quantity' => $cartService->getTotalQuantity()
        ]);
    }

    /**
     * @Route("/new", name="products_new", methods={"POST", "GET"})
     *  @param Request $request
     *  @return Response
     */
    public function new(Request $request): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        // si le formualaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // envoi/récupération des objets dans la bdd avec EntityManager de Doctrine
            $entityManager = $this->getDoctrine()->getManager();
            // préparation de l'entité "Products" à la sauvegarde des données
            $entityManager->persist($product);
            // envoi des données dans la bdd
            $entityManager->flush();

            // récupération de la saisie sur l'upload
            $pictureFile = $form['picture2']->getData();
            // vérification s'il y a un upload photo
            if ($pictureFile) {
                // récupération de l'id du produit
                $idProduct = $product->getId();
                // renommage du fichier
                // nom du fichier + extension
                $newPicture = $idProduct . '.' . $pictureFile->guessExtension();
                // assignation de la valeur à la propriété picture à l'aide du setter
                $product->setPicture($newPicture);
                try {
                    // déplacement du fichier vers le répertoire de destination sur le serveur
                    $pictureFile->move(
                        $this->getParameter('photo_directory'),
                        $newPicture
                    );
                } catch (FileException $e) {
                    // gestion de l'erreur si le déplacement ne s'est pas effectué
                }
                // transfert/ mise à jour de l'image dans la bdd
                $this->getDoctrine()->getManager()->flush();
            }

            // message de validation
            $this->addFlash(
                'success',
                'Produit ajouté avec succès !!'
            );
            // redirection à la liste des produits
            return $this->redirectToRoute('products_index');
        }

        return $this->render('products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="products_show", methods={"GET"})
     * @param Products $product
     * @param CartService $cartService
     * @return Response
     */
    public function show(Products $product, CartService $cartService): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
            // appel de la fonction getTotalQuantity() pour le calcul du nombre total de produit dans le panier
            'total_quantity' => $cartService->getTotalQuantity()
        ]);
    }



    /**
     * @Route("/{id}/edit", name="products_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Products $product
     * @return Response
     */

    // injectons de l'objet Products à la méthode edit
    public function edit(Request $request, Products $product): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // récupération de la saisie sur l'upload
            $pictureFile = $form['picture2']->getData();
            // vérification s'il y a un upload photo
            if ($pictureFile) {
                // récupération de l'id du produit
                $idProduct = $product->getId();
                // renommage du fichier
                // nom du fichier + extension
                $newPicture = $idProduct . '.' . $pictureFile->guessExtension();
                // assignation de la valeur à la propriété picture à l'aide du setter
                $product->setPicture($newPicture);
                try {
                    // déplacement du fichier vers le répertoire de destination sur le serveur
                    $pictureFile->move(
                        $this->getParameter('photo_directory'),
                        $newPicture
                    );
                } catch (FileException $e) {
                    // gestion de l'erreur si le déplacement ne s'est pas effectué
                }
            }
            // transfert/ mise à jour d de l'image dans la bdd
            $this->getDoctrine()->getManager()->flush();

            // message de validation
            $this->addFlash(
                'success',
                'Produit modifié avec succès !!'
            );

            // redirection
            return $this->redirectToRoute('products_index');
        }

        return $this->render('products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="products_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Products $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('products_index');
    }
}
