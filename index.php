<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Crônicas da Mesa Do Dan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg-dark: #0f0f14;
      --bg-card: #1a1a24;
      --gold: #d4af37;
      --text: #e6e6eb;
      --muted: #9aa0a6;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      background: radial-gradient(circle at top, #1c1c28, var(--bg-dark));
      color: var(--text);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
    }

    header {
      padding: 3rem 1.5rem;
      text-align: center;
      background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0));
    }

    header h1 {
      font-family: 'Cinzel', serif;
      font-size: 3rem;
      margin: 0;
      color: var(--gold);
      letter-spacing: 2px;
    }

    header p {
      margin-top: 0.75rem;
      color: var(--muted);
      font-size: 1.1rem;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1.5rem 4rem;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.5rem;
    }

    .card {
      background: var(--bg-card);
      border-radius: 16px;
      padding: 1.5rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
      border: 1px solid rgba(212,175,55,0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    }

    .card h2 {
      font-family: 'Cinzel', serif;
      margin-top: 0;
      margin-bottom: 0.5rem;
      color: var(--gold);
      font-size: 1.4rem;
    }

    .card p {
      color: var(--muted);
      line-height: 1.6;
      font-size: 0.95rem;
    }

    .card a {
      display: inline-block;
      margin-top: 1rem;
      padding: 0.5rem 1.2rem;
      border-radius: 999px;
      text-decoration: none;
      color: #000;
      background: var(--gold);
      font-weight: 600;
      font-size: 0.85rem;
    }

    .timeline {
      margin-top: 3rem;
    }

    .timeline h2 {
      font-family: 'Cinzel', serif;
      color: var(--gold);
      margin-bottom: 1.5rem;
    }

    .event {
      padding: 1rem 1.5rem;
      border-left: 3px solid var(--gold);
      margin-bottom: 1rem;
      background: rgba(255,255,255,0.02);
      border-radius: 8px;
    }

    .event span {
      display: block;
      font-size: 0.8rem;
      color: var(--muted);
      margin-bottom: 0.25rem;
    }

    footer {
      text-align: center;
      padding: 2rem 1rem;
      color: var(--muted);
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

<header>
  <h1>Crônicas da Mesa do Dan</h1>
  <p>Registros vivos das campanhas, batalhas e decisões que moldaram o mundo</p>
</header>

<div class="container">

  <section class="grid">
    <div class="card">
      <h2>📜 Campanha Atual</h2>
      <p>Acompanhe os acontecimentos mais recentes da mesa, decisões críticas e consequências que ecoam pelo reino.</p>
      <a href="campanha.php">Ver campanha</a>
    </div>

    <div class="card">
      <h2>🧙 Personagens</h2>
      <p>Heróis, vilões e figuras lendárias. Fichas, histórias e feitos memoráveis de cada personagem.</p>
      <a href="personagens.php">Explorar personagens</a>
    </div>

    <div class="card">
      <h2>🗺️ Mundo & Reinos</h2>
      <p>Mapas, cidades, facções e conflitos políticos que dão vida ao cenário da campanha.</p>
      <a href="maps.php">Conhecer o mundo</a>
    </div>

    <div class="card">
      <h2>⚔️ Batalhas & Eventos</h2>
      <p>Registros detalhados de torneios, guerras, julgamentos e momentos decisivos da história.</p>
      <a href="cards.php">Ver eventos</a>
    </div>
  </section>

  <section class="timeline">
    <h2>Últimos Eventos</h2>

    <div class="event">
      <span>Dia 17 • Arena de Sargot</span>
      O torneio reuniu guerreiros de diversos reinos. Um combate inesperado mudou o rumo da história.
    </div>

    <div class="event">
      <span>Dia 15 • Tribunal do Norte</span>
      Um julgamento político colocou alianças em risco e definiu o destino de um guerreiro exilado.
    </div>

    <div class="event">
      <span>Dia 12 • Estradas Vaegirs</span>
      A trégua entre reinos foi anunciada, trazendo um frágil período de paz.
    </div>
  </section>

</div>

<footer>
  © <?php echo date('Y'); ?> • Crônicas da Mesa — Que os dados estejam a seu favor
</footer>

</body>
</html>
