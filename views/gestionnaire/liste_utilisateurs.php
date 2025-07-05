<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des utilisateurs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bleu-fonce: #1A1A40;
            --beige-clair: #F5EBDD;
            --dore: #D4AF37;
            --ocre: #CC7722;
            --jaune: #facc15;
            --bleu: #60a5fa;
            --carte-bg: #fdf8f3;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bleu-fonce);
            padding: 40px;
        }

        h2 {
            margin-bottom: 20px;
            color: var(--beige-clair);
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .top-bar input[type="search"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 250px;
        }

        .ajouter-btn {
            background-color: var(--ocre);
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: var(--carte-bg);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            position: relative;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }

        .card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 3px solid var(--dore);
        }

        .card h4 {
            margin: 10px 0 5px;
            color: var(--bleu-fonce);
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .card .actions {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions form,
        .actions a {
            display: inline;
        }

        .actions button,
        .actions a {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: var(--bleu-fonce);
            position: relative;
        }

        .actions i {
            transition: color 0.3s;
        }

        .actions a:hover i,
        .actions button:hover i {
            color: var(--dore);
        }

        .actions a::after,
        .actions button::after {
            content: attr(data-title);
            position: absolute;
            bottom: -24px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.75);
            color: white;
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 4px;
            opacity: 0;
            white-space: nowrap;
            pointer-events: none;
            transition: opacity 0.2s ease-in-out;
        }

        .actions a:hover::after,
        .actions button:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body>
    <h2>Liste des Utilisateurs</h2>
    <div class="top-bar">
        <a href="/aiguille-or/controllers/GestionnaireController.php?action=formulaire" class="ajouter-btn">
            <i class="fas fa-user-plus"></i> Ajouter
        </a>
    </div>

    <div class="cards">
        <?php foreach ($utilisateurs as $user): ?>
            <div class="card">
                <?php if ($user['photo']): ?>
                    <img src="<?= $user['photo'] ?>" alt="Photo de <?= $user['prenom'] ?>">
                <?php else: ?>
                    <img src="/aiguille-or/assets/default-avatar.png" alt="Photo non disponible">
                <?php endif; ?>
                <h4><?= $user['prenom'] . ' ' . $user['nom'] ?></h4>
                <p><?= $user['role'] ?> - <?= $user['etat'] ?></p>

                <div class="actions">
                    <a href="/aiguille-or/controllers/GestionnaireController.php?action=formulaire&id=<?= $user['id'] ?>" class="modifier" data-title="Modifier">
                        <i class="fas fa-pen"></i>
                    </a>

                    <?php if ($user['etat'] === 'actif'): ?>
                        <form method="POST" action="/aiguille-or/controllers/GestionnaireController.php?action=archiver">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <button type="submit" class="archiver" data-title="Archiver" onclick="return confirm('Confirmer l\'archivage de cet utilisateur ?');">
                                <i class="fas fa-box-archive"></i>
                            </button>
                        </form>
                    <?php endif; ?>

                    <form method="POST" action="/aiguille-or/controllers/GestionnaireController.php?action=supprimer">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <button type="submit" class="supprimer" data-title="Supprimer" onclick="return confirm('Confirmer la suppression de cet utilisateur ?');">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
