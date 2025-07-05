<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Articles de Vente</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #F5EBDD;
      padding: 30px;
    }

    h2 {
      text-align: center;
      color: #1A1A40;
      margin-bottom: 20px;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 25px;
    }

    .top-bar form {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .top-bar input[type="text"] {
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      width: 250px;
    }

    .top-bar button,
    .top-bar a {
      background-color: #1A1A40;
      color: white;
      border: none;
      padding: 9px 14px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .top-bar button:hover,
    .top-bar a:hover {
      background-color: #CC7722;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 25px;
    }

    .card {
      background-color:  #f3f4f6;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
    }

    .card img {
      width: 100%;
      height: 170px;
      object-fit: cover;
      background-color: #f3f4f6;
    }

    .card-content {
      padding: 5px 16px;
    }

    .card-content h3 {
      font-size: 18px;
      margin-bottom: 6px;
      color: #1A1A40;
    }

    .infos {
      font-size: 14px;
      color: #444;
      margin-bottom: 10px;
    }

    .actions {
      display: flex;
      justify-content: space-around;
      border-top: 1px solid #ddd;
      padding: 10px 0;
    }

    .actions a {
      color: #1A1A40;
      font-size: 16px;
      transition: color 0.2s;
      position: relative;
    }

    .actions a:hover {
      color: #D4AF37;
    }

    .actions a::after {
      content: attr(title);
      position: absolute;
      bottom: -22px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #1A1A40;
      color: white;
      font-size: 12px;
      padding: 4px 8px;
      border-radius: 4px;
      white-space: nowrap;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.2s;
    }

    .actions a:hover::after {
      opacity: 1;
    }

    .aucun {
      text-align: center;
      color: #999;
      font-style: italic;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <h2>Liste des articles de Vente</h2>

  <div class="top-bar">
    <form method="get" action="/aiguille-or/controllers/ArticleVenteController.php">
      <input type="hidden" name="action" value="lister">
      <input type="text" name="libelle" placeholder="Rechercher un libellé" value="<?= htmlspecialchars($_GET['libelle'] ?? '') ?>">
      <button type="submit">Rechercher</button>
      <a href="/aiguille-or/controllers/ArticleVenteController.php?action=lister">🔄 Réinitialiser</a>
    </form>

    <a href="/aiguille-or/controllers/ArticleVenteController.php?action=formulaire">➕ Ajouter un article</a>
  </div>

  <?php if (empty($articles)): ?>
    <p class="aucun">Aucun article trouvé.</p>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($articles as $a): ?>
        <div class="card">
          <img src="/aiguille-or/assets/<?= htmlspecialchars($a->getPhoto()) ?>" alt="photo">
          <div class="card-content">
            <h3><?= htmlspecialchars($a->getLibelle()) ?></h3>
            <div class="infos">
                <?= number_format($a->getPrixVente(), 0, ',', ' ') ?> F<br>
                <?= $a->getQuantiteStock() ?> en stock<br>
               Total : <?= number_format($a->getMontantVente(), 0, ',', ' ') ?> F
            </div>
          </div>
          <div class="actions">
            <a href="/aiguille-or/controllers/ArticleVenteController.php?action=formulaire&id=<?= $a->getId() ?>" title="Modifier"><i class="fas fa-pen"></i></a>
            <?php if ($a->getEtat() === 'actif'): ?>
              <a href="/aiguille-or/controllers/ArticleVenteController.php?action=archiver&id=<?= $a->getId() ?>" title="Archiver" onclick="return confirm('Archiver cet article ?')"><i class="fas fa-box-archive"></i></a>
            <?php endif; ?>
            <a href="/aiguille-or/controllers/ArticleVenteController.php?action=supprimer&id=<?= $a->getId() ?>" title="Supprimer" onclick="return confirm('Supprimer définitivement ?')"><i class="fas fa-trash"></i></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</body>
</html>
