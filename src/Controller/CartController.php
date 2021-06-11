<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * affichage des détails des produits ajoutés dans le panier
     * @Route("/panier", name="cart_index")
     * l'index prend en paramètre la class "CartService" qui contient les méthodes nécessaires
     * pour accéder aux détails des produits insérés dans le panier
     * @param CartService $cartService
     * @return Response
     */
    public function index(CartService $cartService)
    {
        // affichage de la liste des produits ajoutés et du prix total de tous les produits
        return $this->render('cart/index.html.twig', [
            // appel de la fonction getFullCart() (une méthode de la CartService) pour récupérer le détail des produits du panier
            'items' => $cartService->getFullCart(),
            // appel de la fonction getTotal() de la CartService pour calculer le prix total des produits du panier
            'total' => $cartService->getTotal(),
            // appel de la fonction getTotalQuantity() pour le calcul du nombre total de produit dans le panier
            'total_quantity' => $cartService->getTotalQuantity()
        ]);
    }

    /**
     * ajout d'un produit dans le panier (gestion via json et ajax)
     * @Route("/panier/addWithJson/{id}", name="json_cart_add")
     * la fonction d'ajout prend en paramètres l'id et la class "CartService" qui contient la méthode d'ajout de produits
     * @param $id
     * @param CartService $cartService
     * @return JsonResponse
     */
    public function addWithJson($id, CartService $cartService)
    {
        // appel de la fonction add() (une méthode de la CartService) pour l'ajout de produits
        $cartService->add($id);

        // retour des données sous forme "json"
        return $this->json([
            'total_quantity' => $cartService->getTotalQuantity()
        ], 200);
    }

    /**
     * ajout d'un produit dans le panier suivant son identifiant
     * @Route("/panier/add/{id}", name="cart_add")
     * la fonction d'ajout prend en paramètres l'id et la class "CartService" qui contient la méthode d'ajout de produits
     * @param $id
     * @param CartService $cartService
     * @return RedirectResponse
     */
    public function add($id, CartService $cartService)
    {
        // appel de la fonction add() (une méthode de la CartService) pour l'ajout de produits
        $cartService->add($id);

        // redirection vers le panier
        return $this->redirectToRoute("cart_index");
    }

    /**
     * retrait d'un produit du panier suivant son identifiant
     * @Route("/panier/withdrawal/{id}", name="cart_withdrawal")
     * la fonction de retrait prend en paramètres l'id et la class "CartService" qui contient la méthode de retrait de produits
     * @param $id
     * @param CartService $cartService
     * @return RedirectResponse
     */
    public function withdrawal($id, CartService $cartService)
    {
        // appel de la fonction withdrawal() (une méthode de la CartService) pour le retrait de produits
        $cartService->withdrawal($id);

        // redirection vers le panier
        return $this->redirectToRoute("cart_index");
    }

    /**
     * suppression d'un produit du panier suivant son identifiant
     * @Route("/panier/remove/{id}", name="cart_remove")
     * la fonction de suppression prend en paramètres l'id et la class "CartService" qui contient la méthode de suppression de produits
     * @param $id
     * @param CartService $cartService
     * @return RedirectResponse
     */
    public function remove($id, CartService $cartService)
    {
        // appel de la fonction remove() (une méthode de la CartService) pour la suppression de produits
        $cartService->remove($id);

        // redirection vers le panier
        return $this->redirectToRoute("cart_index");
    }
}