<?php
$isEdit = isset($client);
$titre = $isEdit ? "Modifier un client" : "Ajouter un client";
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
            --ocre: #CC7722;
            --or: #D4AF37;
            --blanc: #ffffff;
            --fond-clair: #f3f4f6;
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

        input, textarea, select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input[type="file"] {
            padding: 6px;
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


<div class="form-container">

    <form method="post" enctype="multipart/form-data" action="/aiguille-or/controllers/ClientController.php?action=ajouter_ou_modifier">
        <input type="hidden" name="id" value="<?= $client ? $client->getId() : '' ?>">
        <input type="hidden" name="photo_existe" value="<?= $client ? $client->getPhoto() : '' ?>">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required value="<?= $client ? htmlspecialchars($client->getNom()) : '' ?>">

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required value="<?= $client ? htmlspecialchars($client->getPrenom()) : '' ?>">

        <label for="telephone_portable">Téléphone :</label>
        <input type="text" id="telephone_portable" name="telephone_portable" required value="<?= $client ? htmlspecialchars($client->getTelephonePortable()) : '' ?>">

        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required value="<?= $client ? htmlspecialchars($client->getAdresse()) : '' ?>">

        <label for="photo">Photo :</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <button type="submit"><?= $isEdit ? 'Mettre à jour' : 'Enregistrer' ?></button>
    </form>
</div>

</body>
</html>
