<?php

// Vérification de l'existence du paramètre 'page' dans l'URL
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    // Utilisation de switch case pour inclure les fichiers en fonction de 'page'
    switch ($page) {
        case 'home':
            include('home.php');
            break;
        case 'produits':
            include('produit.php');
            break;
        case 'contact':
              include('contact.php');
              break;
        default:
            // Si 'page' ne correspond à aucun cas connu, afficher une page d'erreur 
           include('404.php');
            break;
    }
} else {
    // Si le paramètre 'page' n'est pas défini, inclure une page par défaut
    include('home.php');
}

?>