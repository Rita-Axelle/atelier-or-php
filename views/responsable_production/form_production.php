<?php
require_once __DIR__ . '/../../services/security.php';
verifierRole(['responsable_production', 'gestionnaire']);

$isEdit = isset($production);
$titre = $isEdit ? "Modifier une production" : "Ajouter une production";

$dateProduction = $isEdit ? $production->getDateProduction()->format('Y-m-d') : date('Y-m-d');
$articleVenteId = $isEdit ? $production->getArticleVenteId() : '';
$quantite = $isEdit ? $production->getQuantite() : 0;
$observation = $isEdit ? $production->getObservation() : '';
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
            width: 100%;
            max-width: 550px;
            color: var(--bleu-fonce);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--bleu-fonce);
            font-size: 22px;
        }

        label {
            display: block;
            margin-top: 16px;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            background-color: #fff;
            color: #333;
            resize: vertical;
        }

        input[readonly] {
            background-color: #f3f4f6;
        }

        textarea {
            min-height: 80px;
        }

        input[type="submit"], button {
            width: 100%;
            margin-top: 30px;
            background-color: var( --ocre);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #a6531c;
        }
    </style>
</head>
<body>



<div class="container">
    <form method="post" action="/aiguille-or/controllers/ProductionController.php?action=ajouter_ou_modifier">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($production->getId()) ?>">
        <?php endif; ?>

        <h2><?= $titre ?></h2>

        <label for="date_production">Date de production :</label>
        <input type="date" id="date_production" name="date_production" value="<?= htmlspecialchars($dateProduction) ?>" required>

        <label for="article_vente_id">Article concerné :</label>
        <select id="article_vente_id" name="article_vente_id" required>
            <option value="">-- Choisir un article --</option>
            <?php foreach ($articles as $article): ?>
                <option value="<?= htmlspecialchars($article->getId()) ?>" <?= $isEdit && $article->getId() === $articleVenteId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($article->getLibelle()) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="quantite">Quantité produite :</label>
        <input type="number" id="quantite" name="quantite" min="0" value="<?= htmlspecialchars($quantite) ?>" required>

        <label for="observation">Observation (facultatif) :</label>
        <textarea id="observation" name="observation"><?= htmlspecialchars($observation) ?></textarea>

        <input type="submit" value="<?= $isEdit ? 'Mettre à jour' : 'Enregistrer' ?>">
    </form>
</div>

</body>
</html>
