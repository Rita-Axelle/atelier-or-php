<?php
require_once __DIR__ . '/../../services/security.php';
verifierRole(['gestionnaire']);

$isModification = isset($fournisseur) && $fournisseur->getId() !== null;
$titre = $isModification ? "Modifier un fournisseur" : "Ajouter un fournisseur";

if (!isset($fournisseur) || !$fournisseur instanceof Fournisseur) {
    $fournisseur = new Fournisseur([
        'nom' => '',
        'prenom' => '',
        'telephone_portable' => '',
        'telephone_fixe' => '',
        'adresse' => '',
        'photo' => '',
        'etat' => 'actif'
    ]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $titre ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bleu-fonce: #1A1A40;
            --or: #D4AF37;
            --ocre: #CC7722;
            --blanc: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bleu-fonce);
            color: var(--blanc);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .retour-fond {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: var(--ocre);
            color: var(--blanc);
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
        }

        .form-container {
            background-color: #fff;
            color: #333;
            max-width: 550px;
            width: 90%;
            margin: 100px auto 30px;
            padding: 25px 20px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 18px;
            font-size: 22px;
            color: var(--bleu-fonce);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        label {
            font-weight: bold;
            color: var(--bleu-fonce);
        }

        input, select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input[type="file"] {
            padding: 6px;
        }

        .photo-apercu {
            max-width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        button {
            background-color: var(--ocre);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #a6531c;
        }

        .retour {
            margin-top: 16px;
            text-align: center;
        }

        .retour a {
            color: var(--bleu-fonce);
            text-decoration: none;
            font-weight: bold;
        }

        .retour a:hover {
            color: var(--or);
        }
    </style>
</head>
<body>

<!-- Bouton retour -->
<a href="/aiguille-or/controllers/FournisseurController.php?action=lister" class="retour-fond">
    <i class="fas fa-arrow-left"></i>
</a>

<div class="form-container">

    <form action="/aiguille-or/controllers/FournisseurController.php?action=ajouter_ou_modifier" method="POST" enctype="multipart/form-data">
        <?php if ($isModification): ?>
            <input type="hidden" name="id" value="<?= $fournisseur->getId() ?>">
        <?php endif; ?>

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required value="<?= htmlspecialchars($fournisseur->getNom()) ?>">

        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" required value="<?= htmlspecialchars($fournisseur->getPrenom()) ?>">

        <label for="telephone_portable">Téléphone portable</label>
        <input type="text" name="telephone_portable" id="telephone_portable" required value="<?= htmlspecialchars($fournisseur->getTelephonePortable()) ?>">

        <label for="telephone_fixe">Téléphone fixe</label>
        <input type="text" name="telephone_fixe" id="telephone_fixe" required value="<?= htmlspecialchars($fournisseur->getTelephoneFixe()) ?>">

        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" required value="<?= htmlspecialchars($fournisseur->getAdresse()) ?>">

        <label for="photo">Photo</label>
        <?php if (!empty($fournisseur->getPhoto())): ?>
            <img src="/aiguille-or/assets/<?= htmlspecialchars($fournisseur->getPhoto()) ?>" alt="Photo actuelle" class="photo-apercu">
            <input type="hidden" name="photo_existante" value="<?= htmlspecialchars($fournisseur->getPhoto()) ?>">
        <?php endif; ?>
        <input type="file" name="photo" id="photo" accept="image/*">

        <label for="etat">État</label>
        <select name="etat" id="etat">
            <option value="actif" <?= $fournisseur->getEtat() === 'actif' ? 'selected' : '' ?>>Actif</option>
            <option value="archive" <?= $fournisseur->getEtat() === 'archive' ? 'selected' : '' ?>>Archivé</option>
        </select>

        <button type="submit"><i class="fas fa-save"></i> <?= $isModification ? "Modifier" : "Ajouter" ?></button>
    </form>
</div>

</body>
</html>
