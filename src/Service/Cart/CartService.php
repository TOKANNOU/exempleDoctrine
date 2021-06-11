<?php


namespace App\Service\Cart;


use App\Repository\ProductsRepository;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    /**
     * utilisation de l'interface "session" de symfony qui met à disposition un tableau permettant
     * d'ajouter/supprimer un produit d'un panier ou de voir s'il est existant
     */
    protected $session; // création d'une variable protégee $session
    protected $productsRepository; // création d'une variable protégee $productsRepository

    /**
     * création d'un constructeur qui contient les variables $session et $productsRepository afin de permettre leurs instanciations
     * @param SessionInterface $session
     * @param ProductsRepository $productsRepository
     */
    public function __construct(SessionInterface $session, ProductsRepository $productsRepository)
    {
        $this->session = $session;
        $this->productsRepository = $productsRepository;

    }

    /**
     * méthode d'ajout d'un produit dans un panier
     * @param int $id
     */
    public function add(int $id)
    {
        // récupération du panier (qui ne contient aucun produit par défaut) dans la session
        $cart = $this->session->get('cart', []);

        // à l'ajout d'un produit, si ce dernier existe déjà dans le panier
        if(!empty($cart[$id])) {
            // on incrémente le nombre de produit en fonction du nombre d'ajout
            $cart[$id]++;
        } else {
            // sinon, on ajoute simplement le produit dans le panier
            $cart[$id] = 1;
        }

        // mise à jour de la session par ajout du panier contenant un produit
        $this->session->set('cart', $cart);
    }

    /**
     * méthode de retrait d'un produit du panier
     * @param int $id
     */
    public function withdrawal(int $id)
    {
        // récupération du panier (qui ne contient aucun produit par défaut) dans la session
        $cart = $this->session->get('cart', []);

        // si le panier n'est pas vide et qu'il y a plus d'1 produit
        if (!empty($cart[$id]) && $cart[$id] > 1) {
            // retirer 1 produit
            $cart[$id]--;
        }
        // mise à jour de la quantité de produit
        $this->session->set('cart', $cart);
    }

    /**
     * méthode de suppression d'un produit du panier
     * @param int $id
     */
    public function remove(int $id)
    {
        // récupération du panier (qui ne contient aucun produit par défaut) dans la session
        $cart = $this->session->get('cart', []);

        // supprimer le produit
        unset($cart[$id]);

        // mise à jour de la session par suppression du produit enlevé du panier
        $this->session->set('cart', $cart);
    }

    /**
     * méthode d'obtention du détail des produits insérés dans le panier, ainsi que de leurs quantités
     * @return array
     */
    public function getFullCart() : array
    {
        // récupération du panier (qui ne contient aucun produit par défaut) dans la session
        $cart = $this->session->get('cart', []); // on revoie un tableau vide

        // déclaration d'un tableau pour récupérer les données des produits ajoutés
        $cartWithData = [];

        // boucle permettant de parcourir le panier pour extraire l'identifiant du produit et sa quantité
        foreach($cart as $id =>$quantity) {
            // ajout d'un tableau associatif contenant les données nécessaires dans le tableau $cartWithData
            $cartWithData[] = [
                // récupération du produit grace à son identifiant
                'product' => $this->productsRepository->find($id),
                // récupération de la quantité de produits ajoutés
                'quantity' => $quantity
            ];
        }
        return $cartWithData;
    }


    /**
     * méthode de calcul du prix total des produits du panier
     * @return float
     */
    public function getTotal() : float
    {
        // initialisation de la variable
        $total = 0;
        // pour chaque item/produit du panier (récupération du résultat de getFullCart() qui est $cartWithData)
        foreach($this->getFullCart() as $item) {
            // calcul du prix total de tous les produits
            $total += $item['product']->getUnitPrice() * $item['quantity'];
        }
        return $total;
    }

    /**
     * méthode de calcul de la quantité de produit dans le panier
     * cette fonction renvoie le nombre de produit suivi du mot "produit(s)" accordé au singulier/pluriel
     * @return int
     */
    public function getTotalQuantity() : int
    {
        // initialisation des variables
        $totalQuantity = 0;
        // pour chaque item/produit du panier (récupération du résultat de getFullCart() qui est $cartWithData)
        foreach($this->getFullCart() as $item) {
            // calcul du prix total de tous les produits
            $totalQuantity += $item['quantity'];
        }
        return $totalQuantity;
    }

}