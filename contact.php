<?php include 'header.php'; // Inclut le fichier d'en-tête ?>

<?php
session_start(); // Démarrer la session

//-------------------------------------------------------------------------------------------------------------------------------------->
//----------------------------------------------------VARIABLES LIÉES AUX INPUTS DU FORMULAIRE------------------------------------------>
//-------------------------------------------------------------------------------------------------------------------------------------->

// Déclaration des variables liées aux inputs du formulaire
$civilite = $_POST['civilite'] ?? ''; // Récupère le choix de civilité
$message = $_POST['message'] ?? ''; // Récupère le message soumis via le formulaire ou une chaîne vide par défaut
$email = $_POST['email'] ?? ''; // Récupère l'email soumis via le formulaire ou une chaîne vide par défaut
$raisonContact = $_POST['raison_contact'] ?? ''; // Récupère la raison de contact soumise via le formulaire ou une chaîne vide par défaut
$nom = $_POST['nom'] ?? ''; // Récupère le nom soumis via le formulaire ou une chaîne vide par défaut
$prenom = $_POST['prenom'] ?? ''; // Récupère le prénom soumis via le formulaire ou une chaîne vide par défaut

// Stocker les valeurs dans la session
$_SESSION['message'] = $message;
$_SESSION['email'] = $email;
$_SESSION['raison_contact'] = $raisonContact;
$_SESSION['nom'] = $nom;
$_SESSION['prenom'] = $prenom;

//-------------------------------------------------------------------------------------------------------------------------------------->
//----------------------------------------------------------- FONCTION DE VALIDATION---------------------------------------------------->
//-------------------------------------------------------------------------------------------------------------------------------------->

// Fonction pour vérifier si le champ message a au moins 5 lettres
function verifierMessage($message)
{
    // Supprime les espaces en début et fin de chaîne et vérifie la longueur
    if (strlen(trim($message)) >= 5) { // Si la longueur du message, une fois les espaces enlevés, est de 5 ou plus
        return true; // Retourne vrai
    } 
    return false; // Retourne faux
}

// Fonction pour vérifier si l'input email reçoit bien une valeur de type email
function verifierEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Si l'email est valide selon FILTER_VALIDATE_EMAIL
        return true; // Retourne vrai
    }
    return false; // Retourne faux
    
}

// Fonction pour vérifier si une raison est sélectionnée
function verifierRaison($raison)
{
    $raisonValide = ['support', 'ventes', 'information']; // Définit les raisons valides
    return in_array($raison, $raisonValide); // Vérifie si la raison est dans le tableau des raisons valides
}

// Fonction pour vérifier si le nom est renseigné
function verifierNom($nom)
{
    return !empty($nom); // Retourne vrai si le nom n'est pas vide
}

// Fonction pour vérifier si le prénom est renseigné
function verifierPrenom($prenom)
{
    return !empty($prenom); // Retourne vrai si le prénom n'est pas vide
}


//-------------------------------------------------------------------------------------------------------------------------------------->
//----------------------------------------------------------- TABLEAU DES MESSAGES D'ERREUR -------------------------------------------->
//-------------------------------------------------------------------------------------------------------------------------------------->

// Initialisation des erreurs
$errors = [
    'email' => '', // Message d'erreur pour l'email initialisé à une chaîne vide
    'message' => '', // Message d'erreur pour le message initialisé à une chaîne vide
    'raison_contact' => '', // Message d'erreur pour la raison de contact initialisé à une chaîne vide
    'nom' => '', // Message d'erreur pour le nom initialisé à une chaîne vide
    'prenom' => '' // Message d'erreur pour le prénom initialisé à une chaîne vide
];


//-------------------------------------------------------------------------------------------------------------------------------------->
//-----------------------------------------------------------CONDITION MESSAGE ERREURS ------------------------------------------------->
//-------------------------------------------------------------------------------------------------------------------------------------->

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si la méthode de requête est POST

    // Valide l'email
    if (!verifierEmail($email)) { // Si l'email n'est pas valide
        $errors['email'] = "L'email n'est pas valide."; // Définit le message d'erreur pour l'email
    }

    // Valide le message
    if (!verifierMessage($message)) { // Si le message n'est pas valide
        $errors['message'] = "Le message doit contenir au moins 5 lettres."; // Définit le message d'erreur pour le message
    }

    // Valide la raison de contact
    if (!verifierRaison($raisonContact)) { // Si la raison de contact n'est pas valide
        $errors['raison_contact'] = "Sélectionnez une raison valide."; // Définit le message d'erreur pour la raison de contact
    }

    // Valide le nom
    if (!verifierNom($nom)) { // Si le nom n'est pas renseigné
        $errors['nom'] = "Le champ Nom doit être rempli."; // Définit le message d'erreur pour le nom
    }

    // Valide le prénom
    if (!verifierPrenom($prenom)) { // Si le prénom n'est pas renseigné
        $errors['prenom'] = "Le champ Prénom doit être rempli."; // Définit le message d'erreur pour le prénom
    }

    // Si pas d'erreurs, afficher un message de succès
    if (empty(array_filter($errors))) { // Si le tableau des erreurs est vide après filtrage des valeurs vides
        echo "<div class='alert alert-success'>Le formulaire a été soumis avec succès.</div>"; // Affiche un message de succès

       //-------------------------------------------------------------------------------------------------------------------------------------->
       //-----------------------------------------------------------ENVOIE DONNEES SUR FICHIER TXT -------------------------------------------->
       //-------------------------------------------------------------------------------------------------------------------------------------->

        // Formatage des données pour l'enregistrement exemple "Nom: valeur de l'input nom" puis retour a la ligne
        $data = "Civilité: $civilite\n";         // Concatène la civilité avec une nouvelle ligne
        $data .= "Nom: $nom\n";                  // Concatène le nom avec une nouvelle ligne
        $data .= "Prénom: $prenom\n";            // Concatène le prénom avec une nouvelle ligne
        $data .= "Email: $email\n";              // Concatène l'email avec une nouvelle ligne
        $data .= "Raison de contact: $raisonContact\n";  // Concatène la raison de contact avec une nouvelle ligne
        $data .= "Message:\n$message\n\n";      // Concatène le message avec deux nouvelles lignes pour séparer les enregistrements

        // Chemin du fichier où enregistrer les données
        $filename = 'donnees_formulaire.txt';   // Définit le chemin et le nom du fichier de sortie

        // Écriture des données dans le fichier
        if (
            file_put_contents( // Cette fonction PHP est utilisée pour écrire les données contenues dans la variable $data dans le fichier spécifié par $filename.
                $filename, // C'est le chemin et le nom du fichier dans lequel on souhaite écrire les données.
                $data, // C'est la chaîne de caractères contenant les données formatées à écrire dans le fichier.
                FILE_APPEND |  //Cette option indique que les données doivent être ajoutées à la fin du fichier existant, plutôt que de remplacer son contenu.
                LOCK_EX // Cette option permet de verrouiller le fichier en exclusivité pendant l'écriture, évitant ainsi les accès concurrents qui pourraient provoquer des problèmes de corruption des données.
            ) !== false
        ) { //Si file_put_contents retourne une valeur différente de false, cela signifie que l'écriture a réussi.
            echo "Les données ont été enregistrées avec succès dans $filename.";  // Affiche un message de succès avec le nom du fichier
        } else {
            echo "Une erreur s'est produite lors de l'enregistrement des données.";  // Affiche un message d'erreur en cas d'échec d'enregistrement
        }

        // Réinitialiser les valeurs des sessions après la soumission réussie
        $_SESSION['message'] = '';
        $_SESSION['email'] = '';
        $_SESSION['raison_contact'] = '';
        $_SESSION['nom'] = '';
        $_SESSION['prenom'] = '';
    }
}

?>

<!-------------------------------------------------------------------------------------------------------------------------------------->
<!----------------------------------------------------FORMULAIRE HTML AVEC INTÉGRATION PHP --------------------------------------------->
<!-------------------------------------------------------------------------------------------------------------------------------------->

<main>
    <div class="container mt-4">
        <h2>Formulaire de Contact</h2>
        <form action="index.php?page=contact" method="POST">
            <div class="form-group">
                <label for="civilite">Civilité :</label>
                <select class="form-control" id="civilite" name="civilite">
                    <option value="M" <?= $_SESSION['civilite'] == 'M' ? 'selected' : '' ?>>Monsieur</option>
                    <option value="Mme" <?= $_SESSION['civilite'] == 'Mme' ? 'selected' : '' ?>>Madame</option>
                    <option value="Autre" <?= $_SESSION['civilite'] == 'Autre' ? 'selected' : '' ?>>Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom"
                    value="<?= htmlspecialchars($_SESSION['nom']) ?>">
                <?php if ($errors['nom']): ?>
                    <div class="text-danger"><?= $errors['nom'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom"
                    value="<?= htmlspecialchars($_SESSION['prenom']) ?>">
                <?php if ($errors['prenom']): ?>
                    <div class="text-danger"><?= $errors['prenom'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= htmlspecialchars($_SESSION['email']) ?>">
                <?php if ($errors['email']): ?>
                    <div class="text-danger"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="raison_contact">Raison de contact :</label>
                <select class="form-control" id="raison_contact" name="raison_contact">
                    <option value="">--Sélectionnez une raison--</option>
                    <option value="support" <?= $_SESSION['raison_contact'] == 'support' ? 'selected' : '' ?>>Support
                    </option>
                    <option value="ventes" <?= $_SESSION['raison_contact'] == 'ventes' ? 'selected' : '' ?>>Ventes</option>
                    <option value="information" <?= $_SESSION['raison_contact'] == 'information' ? 'selected' : '' ?>>
                        Information</option>
                </select>
                <?php if ($errors['raison_contact']): ?>
                    <div class="text-danger"><?= $errors['raison_contact'] ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="message">Message :</label>
                <textarea class="form-control" id="message" name="message"
                    rows="5"><?= htmlspecialchars($_SESSION['message']) ?></textarea>
                <?php if ($errors['message']): ?>
                    <div class="text-danger"><?= $errors['message'] ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>