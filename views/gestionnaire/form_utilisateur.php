<?php
$isModification = isset($utilisateur) && $utilisateur !== null;
$titre = $isModification ? 'Modifier un utilisateur' : 'Ajouter un nouvel utilisateur';
$roles = ['gestionnaire', 'responsable_stock', 'responsable_production', 'vendeur'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title><?= $titre ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        :root {
            --bleu-fonce: #1A1A40;
            --beige-clair: #F5EBDD;
            --dore: #D4AF37;
            --ocre: #CC7722;
            --carte-bg: #ffffff;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bleu-fonce);
            color: var(--bleu-fonce);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .retour-fond {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: var(--ocre);
            color: var(--bleu-fonce);
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: background 0.3s;
        }

        .retour-fond:hover {
            background-color: #a6531c;
            color: white;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 80px 20px 40px;
            margin: 20px;
        }

        form {
            background-color: var(--carte-bg);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 520px;
            color: var(--bleu-fonce);
        }

        label {
            display: block;
            margin-top: 16px;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="password"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            background-color: #fff;
            color: #333;
        }

        input[readonly] {
            background-color: #f3f4f6;
        }

        .photo-apercu {
            max-width: 100px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 10px;
            display: block;
        }

        input[type="submit"] {
            width: 100%;
            margin-top: 30px;
            background-color: var(--ocre);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #a6531c;
        }
    </style>
</head>
<body>


<div class="container">
    <form method="POST" action="/aiguille-or/controllers/GestionnaireController.php?action=ajouter_ou_modifier" enctype="multipart/form-data">
        <!-- Message d'erreur -->
        <?php if (isset($_GET['erreur']) && $_GET['erreur'] === 'login_existe'): ?>
            <div style="color: red; font-weight: bold; margin-bottom: 10px;">
                Le login est déjà utilisé par un autre utilisateur.
            </div>
        <?php endif; ?>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required value="<?= $isModification ? htmlspecialchars($utilisateur->getNom()) : '' ?>">

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required value="<?= $isModification ? htmlspecialchars($utilisateur->getPrenom()) : '' ?>">

        <label for="telephone_portable">Téléphone :</label>
        <input type="text" id="telephone_portable" name="telephone_portable" required value="<?= $isModification ? htmlspecialchars($utilisateur->getTelephonePortable()) : '' ?>">

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required value="<?= $isModification ? htmlspecialchars($utilisateur->getAdresse()) : '' ?>">

        <label for="salaire">Salaire :</label>
        <input type="number" step="0.01" id="salaire" name="salaire" value="<?= $isModification ? htmlspecialchars($utilisateur->getSalaire()) : '' ?>">

        <label for="login">Login :</label>
        <input type="text" id="login" name="login" required value="<?= $isModification ? htmlspecialchars($utilisateur->getLogin()) : '' ?>">

        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" <?= $isModification ? '' : 'required' ?> value="">

        <label for="photo">Photo de profil :</label>
        <?php if ($isModification && $utilisateur->getPhoto()): ?>
            <img src="<?= htmlspecialchars($utilisateur->getPhoto()) ?>" alt="Photo utilisateur" class="photo-apercu" />
            <input type="hidden" name="photo_existant" value="<?= htmlspecialchars($utilisateur->getPhoto()) ?>">
        <?php endif; ?>
        <input type="file" id="photo" name="photo" accept="image/*">

        <label for="role">Rôle :</label>
        <select id="role" name="role" required>
            <option value="">-- Choisir un rôle --</option>
            <?php foreach ($roles as $r): ?>
                <option value="<?= htmlspecialchars($r) ?>" <?= $isModification && $utilisateur->getRole() === $r ? 'selected' : '' ?>>
                    <?= ucfirst(str_replace('_', ' ', $r)) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="<?= $isModification ? 'Modifier' : 'Ajouter' ?>">
    </form>
</div>

</body>
</html>
