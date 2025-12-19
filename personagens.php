<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Personagens • Crônicas da Mesa</title>
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
      text-align: center;
    }
    header {
      padding: 2.5rem 1.5rem;
    }
    header h1 {
      font-family: 'Cinzel', serif;
      color: var(--gold);
      margin: 0;
      font-size: 2.5rem;
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
      border: 1px solid rgba(212,175,55,0.18);
      box-shadow: 0 10px 30px rgba(0,0,0,0.45);
    }
    .choices, .players {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      flex-wrap: wrap;
      margin-top: 2rem;
    }
    button {
      background: var(--gold);
      border: none;
      padding: 0.8rem 1.6rem;
      border-radius: 999px;
      font-weight: 600;
      cursor: pointer;
      color: #000;
      font-size: 0.95rem;
    }
    .icon-btn {
      width: 120px;
      height: 120px;
      border-radius: 16px;
      background: var(--bg-card);
      border: 1px solid rgba(212,175,55,0.25);
      color: var(--gold);
      font-family: 'Cinzel', serif;
      font-size: 1rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
    }
    .icon {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }
    .hidden { display: none; }
    input[type=password] {
      padding: 0.6rem 1rem;
      border-radius: 8px;
      border: none;
      margin-top: 1rem;
      width: 220px;
    }
    footer {
      color: var(--muted);
      font-size: 0.85rem;
      padding: 2rem 1rem;
    }
  </style>
</head>
<body>

<header>
  <h1>Personagens</h1>
</header>

<div class="container">
  <div class="card">

    <!-- Escolha inicial -->
    <div id="step-choice">
      <p>Deseja visualizar personagens jogáveis ou NPCs?</p>
      <div class="choices">
        <button onclick="showPlayers()">Players</button>
        <button onclick="showNPCs()">NPCs</button>
      </div>
    </div>

    <div id="step-npcs" class="hidden">

  <p>Área restrita. Insira suas credenciais:</p>
  <!--login mestre -->
  <form method="post" action="admin/index.php">
    <input type="text" name="usuario" placeholder="Usuário" required />
    <br><br>
    <input type="password" name="senha" placeholder="Senha" required />
    <br><br>
    <button type="submit">Acessar NPCs</button>
  </form>
</div>

    <!-- Players -->
    <div id="step-players" class="hidden">
      <p>Escolha um personagem:</p>
      <div class="players">

        <form method="get" action="player.php">
          <input type="hidden" name="id" value="1">
          <button class="icon-btn">
            <div class="icon">☀️</div>
            Vidar
          </button>
        </form>

        <form method="get" action="player.php">
          <input type="hidden" name="id" value="4">
          <button class="icon-btn">
            <div class="icon">🐐</div>
            Orin
          </button>
        </form>

        <form method="get" action="player.php">
          <input type="hidden" name="id" value="3">
          <button class="icon-btn">
            <div class="icon">🪓</div>
            Floki
          </button>
        </form>

        <form method="get" action="player.php">
          <input type="hidden" name="id" value="2">
          <button class="icon-btn">
            <div class="icon">💰</div>
            Lan Ling
          </button>
        </form>

      </div>
    </div>

  </div>
</div>

<footer>
  © <?php echo date('Y'); ?> • Crônicas da Mesa
</footer>

<script>
  function showPlayers() {
    document.getElementById('step-choice').classList.add('hidden');
    document.getElementById('step-players').classList.remove('hidden');
  }
  function showNPCs() {
    document.getElementById('step-choice').classList.add('hidden');
    document.getElementById('step-npcs').classList.remove('hidden');
  }
</script>

</body>
</html>
