<?php
require_once __DIR__ . '/../../services/security.php';
verifierRole(['vendeur', 'gestionnaire']);

$estModification = isset($vente);
$titre = $estModification ? "Modification d'une vente" : "Nouvelle vente";
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
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
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
        }

        input[readonly] {
            background-color: #f3f4f6;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            margin-top: 25px;
            background-color: var(--ocre);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #a6531c;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" action="/aiguille-or/controllers/VenteController.php?action=ajouter_ou_modifier">

        <input type="hidden" name="id" value="<?= $vente?->getId() ?>">

        <label for="date_vente">Date de vente</label>
        <input type="date" id="date_vente" name="date_vente" value="<?= $vente?->getDateVente()->format('Y-m-d') ?? date('Y-m-d') ?>" required>

        <label for="article_vente_id">Article vendu</label>
        <select name="article_vente_id" id="article_vente_id" required>
            <option value="">-- Choisir un article --</option>
            <?php foreach ($articles as $article): ?>
                <option value="<?= $article->getId() ?>" <?= $estModification && $vente->getArticleVenteId() === $article->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($article->getLibelle()) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="quantite">Quantité</label>
        <input type="number" id="quantite" name="quantite" value="<?= $vente?->getQuantite() ?>" min="1" required>

        <label for="prix">Prix unitaire</label>
        <input type="number" step="0.01" id="prix" name="prix" value="<?= $estModification ? $vente->getPrix() : '' ?>" required>

        <label for="montant">Montant total</label>
        <input type="number" step="0.01" id="montant" name="montant" value="<?= $vente?->getMontant() ?? 0 ?>" readonly>

        <label for="client_id">Client</label>
        <select name="client_id" id="client_id" required>
            <option value="">-- Choisir un client --</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client->getId() ?>" <?= $estModification && $vente->getClientId() === $client->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($client->getPrenom() . ' ' . $client->getNom()) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="observation">Observation (facultatif)</label>
        <textarea id="observation" name="observation"><?= $estModification ? htmlspecialchars($vente->getObservation()) : '' ?></textarea>

        <button type="submit"><?= $estModification ? 'Mettre à jour' : 'Enregistrer' ?></button>
    </form>
</div>

<script>
    const prix = document.getElementById('prix');
    const quantite = document.getElementById('quantite');
    const montant = document.getElementById('montant');

    function updateMontant() {
        const q = parseFloat(quantite.value) || 0;
        const p = parseFloat(prix.value) || 0;
        montant.value = (q * p).toFixed(2);
    }

    quantite.addEventListener('input', updateMontant);
    prix.addEventListener('input', updateMontant);
    updateMontant(); // Initial update
</script>

</body>
</html>
