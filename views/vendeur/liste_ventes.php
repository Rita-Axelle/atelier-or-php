<?php
require_once __DIR__ . '/../../services/security.php';
verifierRole(['vendeur', 'gestionnaire']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des ventes</title>
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
            padding: 30px;
            background-color: var(--beige-clair);
            color: var(--bleu-fonce);
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 30px;
            background-color: var(--carte-bg);
            border-radius: 16px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .barre-haute {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 15px;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            margin-bottom: 4px;
        }

        input[type="date"],
        select {
            padding: 6px 8px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 150px;
        }

        button,
        .reset-btn,
        .ajout-lien a {
            background-color: var(--ocre);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 7px 12px;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .reset-btn {
            background-color: #888;
        }

        button:hover,
        .reset-btn:hover,
        .ajout-lien a:hover {
            background-color: #a6531c;
        }

        .ajout-lien a {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: var(--bleu-fonce);
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .aucun-resultat {
            text-align: center;
            color: #888;
            padding: 20px;
        }

        .actions a {
            display: inline-block;
            margin-bottom: 4px;
            color: var(--bleu-fonce);
            text-decoration: none;
        }

        .actions a:hover {
            color: var(--ocre);
        }

        @media (max-width: 768px) {
            .barre-haute {
                flex-direction: column;
                align-items: stretch;
            }

            form {
                justify-content: center;
            }

            .ajout-lien {
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Liste des ventes réalisées</h2>

    <div class="barre-haute">
        <form method="get" action="/aiguille-or/controllers/VenteController.php">
            <input type="hidden" name="action" value="filtrer">

            <div class="form-group">
                <label for="date_vente">Date</label>
                <input type="date" name="date_vente" id="date_vente" value="<?= htmlspecialchars($_GET['date_vente'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="article_vente_id">Article</label>
                <select name="article_vente_id" id="article_vente_id">
                    <option value="">-- Tous --</option>
                    <?php foreach ($articles as $id => $libelle): ?>
                        <option value="<?= $id ?>" <?= (isset($_GET['article_vente_id']) && $_GET['article_vente_id'] == $id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($libelle) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="client_id">Client</label>
                <select name="client_id" id="client_id">
                    <option value="">-- Tous --</option>
                    <?php foreach ($clients as $id => $nom): ?>
                        <option value="<?= $id ?>" <?= (isset($_GET['client_id']) && $_GET['client_id'] == $id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" title="Rechercher">
                <i class="fas fa-search"></i>
            </button>

            <a href="/aiguille-or/controllers/VenteController.php?action=lister" class="reset-btn" title="Réinitialiser">
                <i class="fas fa-rotate-right"></i>
            </a>
        </form>

        <div class="ajout-lien">
            <a href="/aiguille-or/controllers/VenteController.php?action=formulaire">➕ Ajouter une vente</a>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Article</th>
            <th>Client</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Montant</th>
            <th>Observation</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($ventes)) : ?>
            <tr><td colspan="8" class="aucun-resultat">Aucune vente trouvée.</td></tr>
        <?php else : ?>
            <?php foreach ($ventes as $vente) : ?>
                <tr>
                    <td><?= $vente->getDateVente()->format('d/m/Y') ?></td>
                    <td><?= htmlspecialchars($articles[$vente->getArticleVenteId()] ?? '-') ?></td>
                    <td><?= htmlspecialchars($clients[$vente->getClientId()] ?? '-') ?></td>
                    <td><?= $vente->getQuantite() ?></td>
                    <td><?= number_format($vente->getPrix(), 2, ',', ' ') ?> F</td>
                    <td><?= number_format($vente->getMontant(), 2, ',', ' ') ?> F</td>
                    <td><?= nl2br(htmlspecialchars($vente->getObservation() ?? '')) ?></td>
                    <td class="actions">
                        <a href="/aiguille-or/controllers/VenteController.php?action=formulaire&id=<?= $vente->getId() ?>">✏ Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
