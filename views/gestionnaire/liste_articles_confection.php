<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Articles de vente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --bleu-fonce: #1A1A40;
      --beige-clair: #F5EBDD;
      --dore: #D4AF37;
      --ocre: #CC7722;
      --blanc: #ffffff;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--beige-clair);
      color: var(--bleu-fonce);
      padding: 30px 15px;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    .barre-haute {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
      max-width: 1200px;
      margin: auto;
      margin-bottom: 30px;
    }

    .barre-haute form {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .barre-haute input[type="text"] {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .barre-haute button,
    .barre-haute a {
      background-color: var(--bleu-fonce);
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .barre-haute button:hover,
    .barre-haute a:hover {
      background-color: var(--ocre);
    }

    .grille-cartes {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 25px;
      max-width: 1200px;
      margin: auto;
    }

    .carte {
      background-color: #f3f4f6;;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s;
    }

    .carte:hover {
      transform: translateY(-5px);
    }

    .carte img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      display: block;
      margin-bottom: -20px; /* réduit l’espace entre photo et texte */
    }

    .contenu {
      padding: 12px 15px 15px 15px; /* réduit le padding en haut */
    }

    .contenu h4 {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .contenu .infos {
      font-size: 14px;
      color: #444;
    }

    .actions {
      margin-top: 15px;
      display: flex;
      justify-content: space-around;
      padding-top: 10px;
      border-top: 1px solid #eee;
    }

    .actions a {
      color: var(--dore);
      font-size: 16px;
    }

    .actions a:hover {
      color: var(--bleu-fonce);
    }

    @media (max-width: 600px) {
      .barre-haute {
        flex-direction: column;
        align-items: stretch;
      }

      .barre-haute form {
        justify-content: center;
      }
    }
  </style>
</head>
<body>

<h2>Liste des articles de confection</h2>

<div class="barre-haute">
  <form method="get" action="/aiguille-or/controllers/ArticleConfectionController.php">
    <input type="hidden" name="action" value="lister">
    <input type="text" name="libelle" placeholder="Rechercher par libellé"
           value="<?= htmlspecialchars($_GET['libelle'] ?? '') ?>">
    <button type="submit">Rechercher</button>
    <a href="/aiguille-or/controllers/ArticleConfectionController.php?action=lister">Réinitialiser</a>
  </form>
  <a href="/aiguille-or/controllers/ArticleConfectionController.php?action=formulaire">➕ Ajouter un article</a>
</div>

<div class="grille-cartes">
  <?php if (empty($articles)): ?>
    <p style="grid-column: 1/-1; text-align: center;">Aucun article trouvé.</p>
  <?php else: ?>
    <?php foreach ($articles as $a): ?>
      <div class="carte">
        <img src="/aiguille-or/assets/<?= htmlspecialchars($a->getPhoto()) ?>" alt="photo article">
        <div class="contenu">
          <h4>
            <a href="/aiguille-or/controllers/ArticleConfectionController.php?action=details&id=<?= $a->getId() ?>" style="text-decoration: none; color: inherit;">
                <?= htmlspecialchars($a->getLibelle()) ?>
            </a>
            </h4>

          <div class="infos">
            <?= $a->getQuantiteStock() ?> en stock<br>
            <?= number_format($a->getMontantStock(), 0, ',', ' ') ?> F
          </div>
          <div class="actions">
            <a href="/aiguille-or/controllers/ArticleConfectionController.php?action=formulaire&id=<?= $a->getId() ?>" title="Modifier"><i class="fas fa-pen"></i></a>
            <?php if ($a->getEtat() === 'actif'): ?>
              <a href="/aiguille-or/controllers/ArticleConfectionController.php?action=archiver&id=<?= $a->getId() ?>" title="Archiver" onclick="return confirm('Archiver cet article ?')"><i class="fas fa-box-archive"></i></a>
            <?php endif; ?>
            <a href="/aiguille-or/controllers/ArticleConfectionController.php?action=supprimer&id=<?= $a->getId() ?>" title="Supprimer" onclick="return confirm('Supprimer cet article ?')"><i class="fas fa-trash"></i></a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

</body>
</html>
