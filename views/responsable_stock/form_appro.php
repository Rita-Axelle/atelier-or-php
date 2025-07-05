<?php
$isEdit = isset($appro);
$titre = $isEdit ? "Modifier un approvisionnement" : "Ajouter un approvisionnement";

$dateAppro = $isEdit ? $appro->getDateAppro()->format('Y-m-d') : date('Y-m-d');
$articleConfectionId = $isEdit ? $appro->getArticleConfectionId() : '';
$quantite = $isEdit ? $appro->getQuantite() : '';
$prix = $isEdit ? $appro->getPrix() : '';
$montant = $isEdit ? $appro->getMontant() : '';
$observation = $isEdit ? $appro->getObservation() : '';
$fournisseurId = $isEdit ? $appro->getFournisseurId() : '';
$responsableId = $isEdit ? $appro->getResponsableStockId() : ($_SESSION['utilisateur']['id'] ?? null);
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
            margin : 20px
        }

        form {
            background-color: var(--carte-bg);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 550px;
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

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #a6531c;
        }
    </style>
</head>
<body>

<div class="container">
    <form method="post" action="/aiguille-or/controllers/ApprovisionnementController.php?action=<?= $isEdit ? 'modifier&id=' . $appro->getId() : 'ajouter' ?>">

        <label for="date_appro">Date :</label>
        <input type="date" name="date_appro" id="date_appro" value="<?= $dateAppro ?>" required>

        <label for="articleConfectionId">Article de confection :</label>
        <select name="article_confection_id" required>
            <option value="">-- Sélectionner un article --</option>
            <?php foreach ($articles as $id => $libelle): ?>
                <option value="<?= $id ?>" <?= $id == $articleConfectionId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($libelle) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" id="quantite" value="<?= $quantite ?>" required>

        <label for="prix">Prix unitaire :</label>
        <input type="number" step="0.01" name="prix" id="prix" value="<?= $prix ?>" required>

        <label for="montant">Montant :</label>
        <input type="number" step="0.01" name="montant" id="montant" value="<?= $montant ?>" readonly>

        <label for="fournisseurId">Fournisseur :</label>
        <select name="fournisseur_id" required>
            <option value="">-- Sélectionner un fournisseur --</option>
            <?php foreach ($fournisseurs as $id => $nom): ?>
                <option value="<?= $id ?>" <?= $id == $fournisseurId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($nom) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="observation">Observation :</label>
        <textarea name="observation" id="observation"><?= $observation ?></textarea>

        <input type="hidden" name="responsable_stock_id" value="<?= $responsableId ?>">

        <input type="submit" value="<?= $isEdit ? 'Modifier' : 'Ajouter' ?>">
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
    // Calcul initial si valeurs déjà remplies
    updateMontant();
</script>

</body>
</html>
