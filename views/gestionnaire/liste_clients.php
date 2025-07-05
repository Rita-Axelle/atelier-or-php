<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des clients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            color: var(--bleu-fonce);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .top-bar input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .top-bar a {
            padding: 10px 16px;
            background-color: var(--ocre);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .top-bar a:hover {
            background-color: #a6531c;
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

        .actions i {
            margin: 0 6px;
            cursor: pointer;
            padding: 8px;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .actions i.fa-pen:hover {
            background-color: #3b82f6;
            color: white;
        }

        .actions i.fa-box-archive:hover {
            background-color: #facc15;
            color: black;
        }

        .actions i.fa-trash:hover {
            background-color: #ef4444;
            color: white;
        }

        .aucun-resultat {
            text-align: center;
            color: #999;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                gap: 10px;
            }

            .top-bar input[type="text"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Liste des clients</h2>
    <form method="GET" action="/aiguille-or/controllers/ClientController.php">
         <input type="hidden" name="action" value="lister">
        <div class="top-bar">
            <input type="text" name="motcle" placeholder="Rechercher un client..." value="<?= htmlspecialchars($_GET['motcle'] ?? '') ?>">
            <a href="/aiguille-or/controllers/ClientController.php?action=formulaire">➕ Ajouter un client</a>
        </div>
    </form>

    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($clients)): ?>
            <tr><td colspan="5" class="aucun-resultat">Aucun client enregistré.</td></tr>
        <?php else: ?>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client->getNom()) ?></td>
                    <td><?= htmlspecialchars($client->getPrenom()) ?></td>
                    <td><?= htmlspecialchars($client->getTelephonePortable()) ?></td>
                    <td><?= htmlspecialchars($client->getAdresse()) ?></td>
                    <td class="actions">
                        <a href="/aiguille-or/controllers/ClientController.php?action=formulaire&id=<?= $client->getId() ?>" title="Modifier">
                            <i class="fas fa-pen"></i>
                        </a>
                        <?php if ($client->getEtat() === 'actif'): ?>
                            <a href="/aiguille-or/controllers/ClientController.php?action=archiver&id=<?= $client->getId() ?>" title="Archiver" onclick="return confirm('Archiver ce client ?')">
                                <i class="fas fa-box-archive"></i>
                            </a>
                        <?php endif; ?>
                        <a href="/aiguille-or/controllers/ClientController.php?action=supprimer&id=<?= $client->getId() ?>" title="Supprimer" onclick="return confirm('Supprimer définitivement ?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
