
/* évènement d'ajout de produit au panier */
function onClickBtnAdd(event) {
    /* annulation de la redirection vers une autre page après un clic sur le bouton */
    event.preventDefault();

    /* récupération de l'url par ajax (c-a-d le lien href du bouton) */
    const url = this.href;
    /* sélection du span qui affiche la quantité de produit */
    const spanQuantity = document.getElementById('js-update-quantity');

    /* attente et stockage de la requête (utilisation de la librairie "axios" qui permet de faire des requêtes ajax) */
    axios.get(url).then(function(response) {

        /* Mise à jour de la quantité totale de produit à chaque ajout */
        spanQuantity.textContent = response.data.total_quantity;

    // gestion des erreurs
    }).catch(function(error) {
        if(error.response.status === 403) {
            window.alert("Veuillez-vous connecter pour ajouter un produit !");
        } else {
            window.alert("Une erreur s'est produite, veuillez réessayer plus tard.");
        }
    })
}

/* sélection du bouton d'ajout de produit au panier */
document.querySelectorAll('a.js-cart-add').forEach(function (link) {
    /* quand le bouton est cliqué, on appelle la fonction "onClickBtnAdd" */
    link.addEventListener('click', onClickBtnAdd)
})