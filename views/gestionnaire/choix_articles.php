<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Choix Gestion des Articles</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --bleu-fonce: #1A1A40;
      --beige-clair: #F5EBDD;
      --dore: #D4AF37;
      --ocre: #CC7722;
      --blanc: #ffffff;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, var(--beige-clair), #fffaf0);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      color: var(--bleu-fonce);
      position: relative;
      overflow: hidden;
      animation: fadeIn 0.8s ease-out both;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      font-size: 28px;
      margin-bottom: 40px;
      text-align: center;
      color: var(--bleu-fonce);
      z-index: 2;
    }

    .choix-container {
      display: flex;
      flex-direction: column;
      gap: 25px;
      width: 100%;
      max-width: 500px;
      z-index: 2;
    }

    .choix-container a {
      background-color: var(--bleu-fonce);
      color: white;
      padding: 16px 30px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: background-color 0.3s, transform 0.2s;
    }

    .choix-container a:hover {
      background-color: var(--ocre);
      transform: translateY(-3px);
    }

    .circle {
      position: absolute;
      border-radius: 50%;
      background-color: var(--ocre);
      opacity: 0.08;
      z-index: 0;
      animation: floatCircle 20s linear infinite alternate;
    }

    .circle.one {
      width: 300px;
      height: 300px;
      top: -100px;
      left: -100px;
    }

    .circle.two {
      width: 400px;
      height: 400px;
      bottom: -150px;
      right: -150px;
    }

    @keyframes floatCircle {
      0% { transform: translateY(0) rotate(0deg); }
      100% { transform: translateY(20px) rotate(360deg); }
    }

    @media (min-width: 768px) {
      .choix-container {
        flex-direction: row;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
  <div class="circle one"></div>
  <div class="circle two"></div>

  <h2>Choisissez le type d'articles à gérer</h2>
  <div class="choix-container">
    <a href="/aiguille-or/controllers/GestionnaireController.php?action=menuArticlesConfection">
      Gérer les articles de confections
    </a>
    <a href="/aiguille-or/controllers/GestionnaireController.php?action=menuArticlesVente">
      Gérer les articles de ventes
    </a>
  </div>
</body>
</html>
