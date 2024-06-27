<?php include 'header.php'; ?>

<main>
  <div class="container mt-5">
    <h1>Bienvenue sur notre site e-commerce</h1>
    <p>Explorez nos produits et profitez de nos offres spéciales.</p>
    <?php
    
    
    // ******************* Mes images afficher en boucle avec un Foreach ******************** //

    // stock tout les images qui finissent par .webp dans la variable $images
    $images = glob('img/*.webp');
    // Boucle sur la variable $images qui est un tableau en déclarant que $image et une ligne du tableau
    foreach ($images as $image){
      // Pour chaque ligne du tableau affiche une image du dossier
      echo '<img src="'.$image.'"alt="Image">';
    }
    


    // ************** Mes images afficher en boucle avec un For ************************* //

    // stock tout les images qui finissent par .webp dans la variable $imageWebp
    $imageWebp = glob('img/*.webp');
    // Compte le nombre d'image stocker dans la variable $imageWebp
    $totalImages = count($imageWebp);

    // Boucle sur le nombre d'image stocker dans la variable $totalImages
    for ($i=0; $i<$totalImages; $i++ ){
      // A chaque tour de boucle (itération) affiche une image du dossier 
        echo '<img src="'.$imageWebp[$i].'"alt="Image">';      
    }
    
    ?>


  
  </div>
</main>

<?php include 'footer.php'; ?>