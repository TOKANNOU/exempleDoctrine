<?php


namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 * @method render(string $string, array $array)
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CartService $cartService
     * @return Response
     */
    public function index(CartService $cartService) :Response
    {
        // affichage de la page d'accueil
        return $this->render('home/index.html.twig', [
            // appel de la fonction getTotalQuantity() pour le calcul du nombre total de produit dans le panier
            'total_quantity' => $cartService->getTotalQuantity()
        ]);
    }

}