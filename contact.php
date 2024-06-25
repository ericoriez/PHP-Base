<?php include 'header.php'; ?>
<main>
    <div class="container mt-4">
        <h2>Formulaire de Contact</h2>
        <form action="index.php?page=contact" method="POST">
            <div class="form-group">
                <label for="civilite">Civilité :</label>
                <select class="form-control" id="civilite" name="civilite">
                    <option value="M">Monsieur</option>
                    <option value="Mme">Madame</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom">
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="raison_contact">Raison de contact :</label>
                <select id="raison_contact" name="raison_contact">
                    <option value="">--Sélectionnez une raison--</option>
                    <option value="support">Support</option>
                    <option value="ventes">Ventes</option>
                    <option value="information">Information</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message :</label>
                <textarea class="form-control" id="message" name="message" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</main>
<?php

// Déclaration des variables lier au input du formulaire
$message = $_POST['message'] ?? ''; 
$email = $_POST['email'] ?? '';
$raisonContact = $_POST['raison_contact'] ?? '';
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';


// Fonction pour vérifier si le champ message a au moins 5 lettres
function verifierMessage($message)
{
    // Supprime les espaces en début et fin de chaîne et vérifie la longueur
    if (strlen(trim($message)) >= 5) {
        return true;
    } else {
        return false;
    }
}

// Fonction pour verifier si l'input email recoit bien une valeur de type email
function verifierEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        return true;
    } else {
        return false;
    }
}

// Fonction pour vérifier si une raison et sélectionner
function verifierRaison($raison){

    $raisonValide = ['support', 'ventes', 'information'];
    return in_array($raison, $raisonValide);
    
}

function verifierNom($nom){
    return !empty($nom);
}

function verifierPrenom($prenom){
    return !empty($prenom);
}


// Condition pour afficher les messages
if (verifierEmail($email)) {

    echo ("le mail est valide<br>");
} else {
    echo ("le mail n'est pas valide<br>");
}



if (verifierMessage($message)) {
    echo "Le message est valide.<br>";
} else {
    echo "Le message doit contenir au moins 5 lettres.<br>";
}


if (verifierRaison($raisonContact)){

    echo "Raison sélectionner<br>";
    
}else {
    echo "Sélectionner une raison<br>";
}


if (verifierNom($nom)){
    echo "Nom : $nom<br>";
}else{
    echo "le champ Nom doit être rempli<br>";
}


if (verifierPrenom($prenom)){
    echo "Prenom : $prenom<br>";
}else{
    echo "le champ Prenom doit être rempli<br>";
}

?>



<?php include 'footer.php'; ?>
</body>




