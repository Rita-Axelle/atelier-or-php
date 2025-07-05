<?php
require_once __DIR__ . '/../../services/security.php';
verifierRole(['vendeur', 'gestionnaire']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tableau de bord - Vendeur</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --bleu-fonce: #1A1A40;
      --beige-clair: #F5EBDD;
      --dore: #D4AF37;
      --blanc: #ffffff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      background: linear-gradient(135deg, #1A1A40, #0f3460);
      color: var(--bleu-fonce);
      height: 100vh;
      overflow: hidden;
      position: relative;
    }

    body::before, body::after {
      content: "";
      position: absolute;
      background: var(--dore);
      border-radius: 50%;
      opacity: 0.08;
      z-index: 0;
    }

    body::before {
      top: -80px;
      right: -80px;
      width: 250px;
      height: 250px;
    }

    body::after {
      bottom: -60px;
      left: -60px;
      width: 180px;
      height: 180px;
    }

    aside {
      width: 250px;
      background-color: var(--bleu-fonce);
      color: white;
      padding: 30px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      z-index: 1;
    }

    aside img {
      width: 120px;
      margin-bottom: 30px;
    }

    aside nav ul {
      list-style: none;
      width: 100%;
    }

    aside nav ul li {
      margin: 15px 0;
    }

    aside nav ul li a {
      color: white;
      text-decoration: none;
      padding: 12px 15px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: background 0.3s;
      font-weight: 500;
    }

    aside nav ul li a:hover {
      background-color: #cc7722;
    }

    main {
      flex-grow: 1;
      padding: 40px;
      overflow-y: auto;
      background-color: var(--beige-clair);
      z-index: 1;
      border-top-left-radius: 30px;
      border-bottom-left-radius: 30px;
      margin: 20px;
      box-shadow: -10px 0 30px rgba(0, 0, 0, 0.05);
    }

    h1 {
      font-size: 32px;
      margin-bottom: 40px;
      color: var(--bleu-fonce);
    }

    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
    }

    .card {
      background-color: var(--blanc);
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
      position: relative;
      z-index: 2;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 26px;
      font-weight: bold;
      color: var(--bleu-fonce);
    }

    .card i {
      font-size: 28px;
      color: var(--dore);
      margin-bottom: 15px;
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
        overflow: auto;
      }

      aside {
        width: 100%;
        flex-direction: row;
        justify-content: space-around;
        height: auto;
        padding: 10px;
      }

      aside nav ul {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
      }

      aside nav ul li {
        margin: 5px;
      }

      main {
        margin: 0;
        border-radius: 0;
      }
    }
  </style>
</head>
<body>

  <aside>
    <img src="/aiguille-or/assets/logo.png" alt="Logo de l'application">
    <nav>
      <ul>
        <li><a href="/aiguille-or/controllers/VenteController.php?action=formulaire"><i class="fas fa-plus-square"></i> Enregistrer une vente</a></li>
        <li><a href="/aiguille-or/controllers/VenteController.php?action=lister"><i class="fas fa-list-ul"></i> Lister les ventes</a></li>
        <li><a href="/aiguille-or/controllers/VenteController.php?action=lister"><i class="fas fa-search"></i> Rechercher une vente</a></li>
        <li><a href="/aiguille-or/views/security/logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
      </ul>
    </nav>
  </aside>

  <main>
    <h1>Bonjour, <?= htmlspecialchars($_SESSION['utilisateur']['prenom'] . ' ' . $_SESSION['utilisateur']['nom']) ?></h1>

    <div class="dashboard-cards">
      <div class="card">
        <i class="fas fa-chart-line"></i>
        <h3>Nombre total de ventes</h3>
        <p><?= $nbVentes ?></p>
      </div>
      <div class="card">
        <i class="fas fa-money-bill-wave"></i>
        <h3>Chiffre d'affaires</h3>
        <p><?= number_format($montantTotal, 2, ',', ' ') ?> FCFA</p>
      </div>
      <div class="card">
        <i class="fas fa-user-friends"></i>
        <h3>Nombre de clients</h3>
        <p><?= $nbClients ?></p>
      </div>
      <div class="card">
        <i class="fas fa-boxes"></i>
        <h3>Articles vendus</h3>
        <p><?= $nbArticles ?></p>
      </div>
      <div class="card">
        <i class="fas fa-calendar-check"></i>
        <h3>Dernière vente</h3>
        <p><?= $derniereVente ?? 'Aucune' ?></p>
      </div>
    </div>
  </main>

</body>
</html>
