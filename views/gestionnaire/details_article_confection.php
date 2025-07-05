<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'article</title>
    <style>
        :root {
            --bleu-fonce: #1A1A40;
            --beige-clair: #F5EBDD;
            --dore: #D4AF37;
            --ocre: #CC7722;
            --blanc: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: var(--bleu-fonce);
            color: var(--blanc);
            min-height: 100vh;
            padding: 40px 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: var(--beige-clair);
            color: var(--bleu-fonce);
            padding: 30px;
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: var(--dore);
            font-size: 24px;
            margin-bottom: 25px;
        }

        .detail {
            margin-bottom: 16px;
            font-size: 16px;
        }

        .detail strong {
            display: inline-block;
            width: 160px;
            color: var(--bleu-fonce);
        }

        .photo img {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            display: block;
            margin: 20px auto 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .no-photo {
            color: #555;
            text-align: center;
            font-style: italic;
            margin-top: 10px;
        }

        .retour {
            display: block;
            text-align: center;
            margin-top: 25px;
        }

        .retour a {
            background-color: var(--dore);
            color: var(--bleu-fonce);
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .retour a:hover {
            background-color: var(--bleu-fonce);
            color: var(--beige-clair);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Détails de l'article</h2>
    <div class="details-box">
        <p class="detail"><strong>Libellé :</strong> <?= htmlspecialchars($article->getLibelle()) ?></p>
        <p class="detail"><strong>Quantité en stock :</strong> <?= $article->getQuantiteStock() ?></p>
        <p class="detail"><strong>Montant en stock :</strong> <?= number_format($article->getMontantStock(), 2) ?> FCFA</p>
        <p class="detail"><strong>Prix d'achat :</strong> <?= number_format($article->getPrixAchat(), 2) ?> FCFA</p>
        <p class="detail"><strong>Catégorie :</strong> <?= htmlspecialchars($article->getCategorie()) ?></p>
</div>

    
    <div class="photo">
        <?php if ($article->getPhoto()) : ?>
            <img src="/aiguille-or/assets/<?= htmlspecialchars($article->getPhoto()) ?>" alt="Photo de l'article">
        <?php else : ?>
            <p class="no-photo">Aucune photo disponible.</p>
        <?php endif; ?>
    </div>

    <div class="retour">
        <a href="/aiguille-or/controllers/ArticleConfectionController.php?action=lister">⬅ Retour à la liste</a>
    </div>
</div>

</body>
</html>
