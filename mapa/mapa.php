<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Calradia</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .background-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
    </style>
</head>
<body>
    <!-- Imagem de fundo -->
    <picture>
        <!-- Para telas pequenas -->
        <source media="(max-width: 768px)" srcset="mapa-mobile.jpg">
        <!-- Para telas médias -->
        <source media="(max-width: 1200px)" srcset="mapa-tablet.jpg">
        <!-- Para telas grandes (imagem original) -->
        <img src="origial/mapa_calradia.png"
             class="background-image"
             alt="Mapa de Calradia"
             loading="eager">
    </picture>

    <!-- Conteúdo principal -->
    <div class="content">
        <img src="nords.png" class="fullscreen-img" alt="Descrição">
    </div>
</body>
</html>