<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Campanha Atual • Crônicas da Mesa</title>
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
      padding: 2.5rem 1.5rem;
      text-align: center;
      background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0));
    }

    header h1 {
      font-family: 'Cinzel', serif;
      font-size: 2.6rem;
      margin: 0;
      color: var(--gold);
      letter-spacing: 2px;
    }

    header p {
      margin-top: 0.75rem;
      color: var(--muted);
      font-size: 1.05rem;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 2rem 1.5rem 4rem;
    }

    .card {
      background: var(--bg-card);
      border-radius: 18px;
      padding: 2rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.45);
      border: 1px solid rgba(212,175,55,0.18);
    }

    .card h2 {
      font-family: 'Cinzel', serif;
      color: var(--gold);
      margin-top: 0;
      margin-bottom: 1rem;
      font-size: 1.6rem;
    }

    .card p {
      line-height: 1.7;
      font-size: 1rem;
      margin-bottom: 1rem;
      color: var(--text);
    }

    .highlight {
      color: var(--gold);
      font-weight: 600;
    }

    .back {
      display: inline-block;
      margin-top: 2rem;
      padding: 0.6rem 1.4rem;
      border-radius: 999px;
      text-decoration: none;
      background: var(--gold);
      color: #000;
      font-weight: 600;
      font-size: 0.9rem;
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
  <h1>Campanha Atual</h1>
  <p>O estado do mundo e o início de uma nova jornada</p>
</header>

<div class="container">
  <div class="card">
    <h2>📜 Resumo da Campanha</h2>

    <p>
      Nossos heróis viajantes — <span class="highlight">Vidar</span>, <span class="highlight">Floki</span> e <span class="highlight">Orin</span> — chegaram à grandiosa capital de <span class="highlight">Reyvadin</span>, trazendo consigo não apenas histórias de batalhas, mas também antigos inimigos.
    </p>

    <p>
      Ex-bandidos, agora aliados, foram apresentados às autoridades e incorporados como um <span class="highlight">novo destacamento do exército</span>, marcando uma tentativa ousada de redenção e reforço militar para o reino.
    </p>

    <p>
      Após se estabelecerem na cidade e oficializarem seus novos companheiros, o grupo aceitou sua <span class="highlight">primeira missão</span> por meio da guilda local: escoltar uma <span class="highlight">comerciante</span> em segurança até uma <span class="highlight">cidade recém-fundada</span>, onde os perigos das estradas ainda são desconhecidos.
    </p>

    <p>
      O mundo observa atento. Estradas perigosas, interesses ocultos e decisões difíceis aguardam os heróis em sua jornada.
    </p>

    <a class="back" href="index.php">← Voltar para a Crônica</a>
  </div>
</div>

<footer>
  © <?php echo date('Y'); ?> • Crônicas da Mesa
</footer>

</body>
</html>
