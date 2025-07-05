<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $article ? "Modifier" : "Ajouter" ?> un article de vente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bleu-fonce: #1A1A40;
            --or: #D4AF37;
            --ocre: #CC7722;
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

        .container {
            background: white;
            color: #333;
            max-width: 550px;
            width: 90%;
            margin: 100px auto 30px auto;
            padding: 25px 20px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--bleu-fonce);
            font-size: 22px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        label {
            font-weight: bold;
            color: var(--bleu-fonce);
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        input[readonly] {
            background-color: var(--fond-clair);
        }

        textarea {
            resize: vertical;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        .photo-apercu {
            max-width: 100%;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        button {
            background-color: var(--ocre);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #a6531c;
        }
    </style>
</head>
<body>


<div class="container">

    <form method="post" action="/aiguille-or/controllers/ArticleVenteController.php?action=ajouter_ou_modifier" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $article ? $article->getId() : '' ?>">

        <label for="libelle">Libellé</label>
        <input type="text" name="libelle" id="libelle" required value="<?= $article ? htmlspecialchars($article->getLibelle()) : '' ?>">

        <label for="prix_vente">Prix de vente</label>
        <input type="number" step="0.01" name="prix_vente" id="prix_vente" required value="<?= $article ? $article->getPrixVente() : '' ?>">

        <label for="quantite_stock">Quantité en stock</label>
        <input type="number" name="quantite_stock" id="quantite_stock" required value="<?= $article ? $article->getQuantiteStock() : '' ?>">

        <label for="montant_vente">Montant de vente</label>
        <input type="number" step="0.01" name="montant_vente" id="montant_vente" value="<?= $article ? $article->getMontantVente() : '' ?>" readonly>

        <label for="photo">Photo</label>
        <?php if ($article && $article->getPhoto()): ?>
            <img src="../../assets/<?= htmlspecialchars($article->getPhoto()) ?>" alt="Photo actuelle" class="photo-apercu">
        <?php endif; ?>
        <input type="file" name="photo" id="photo" accept="image/*">

        <label for="etat">État</label>
        <select name="etat" id="etat">
            <option value="actif" <?= $article && $article->getEtat() === 'actif' ? 'selected' : '' ?>>Actif</option>
            <option value="archive" <?= $article && $article->getEtat() === 'archive' ? 'selected' : '' ?>>Archivé</option>
        </select>

        <button type="submit"><i class="fas fa-save"></i> <?= $article ? "Modifier" : "Ajouter" ?></button>
    </form>
</div>

<script>
    const prix = document.getElementById('prix_vente');
    const quantite = document.getElementById('quantite_stock');
    const montant = document.getElementById('montant_vente');

    function updateMontant() {
        const p = parseFloat(prix.value) || 0;
        const q = parseFloat(quantite.value) || 0;
        montant.value = (p * q).toFixed(2);
    }

    prix.addEventListener('input', updateMontant);
    quantite.addEventListener('input', updateMontant);
    updateMontant();
</script>

</body>
</html>
