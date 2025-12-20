<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Calradia - Navegável</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #1a1a1a;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        /* Contêiner principal do mapa */
        .map-container {
            width: 100vw;
            height: 100vh;
            overflow: auto;
            cursor: grab;
            position: relative;
            -webkit-overflow-scrolling: touch;
        }

        .map-container:active {
            cursor: grabbing;
        }

        /* Imagem do mapa */
        .map-image {
            display: block;
            /* A imagem terá seu tamanho original, mas podemos ajustar o zoom por transform ou width/height */
            position: absolute;
            top: 0;
            left: 0;
            transform-origin: 0 0; /* Para zoom a partir do canto superior esquerdo */
            transition: transform 0.1s ease-out;
        }

        /* Indicador de arrastar */
        .drag-hint {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            z-index: 100;
            animation: fadeOut 3s forwards;
            animation-delay: 3s;
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; display: none; }
        }

        /* Controles de navegação */
        .controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 100;
        }

        .control-btn {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .control-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        /* Barra de zoom */
        .zoom-control {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
        }

        .zoom-control button {
            width: 30px;
            height: 30px;
            background: #444;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .zoom-control button:hover {
            background: #666;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .controls {
                bottom: 10px;
                right: 10px;
            }
            
            .zoom-control {
                bottom: 10px;
                left: 10px;
            }
            
            .drag-hint {
                font-size: 12px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Contêiner principal do mapa -->
    <div class="map-container" id="mapContainer">
        <!-- Imagem do mapa -->
        <img src="nords.png"
             class="map-image"
             alt="Mapa de Calradia"
             id="mainMap"
             draggable="false">
    </div>

    <!-- Indicador para arrastar -->
    <div class="drag-hint" id="dragHint">
        🖱️ Arraste para navegar no mapa | 🔍 Use scroll para zoom
    </div>

    <!-- Controles -->
    <div class="controls">
        <button class="control-btn" onclick="centerMap()" title="Centralizar mapa">⌖</button>
        <button class="control-btn" onclick="resetMap()" title="Resetar visualização">⟲</button>
    </div>

    <!-- Controle de zoom -->
    <div class="zoom-control">
        <button onclick="zoomOut()">-</button>
        <span id="zoomLevel" style="color: white; min-width: 40px; text-align: center;">100%</span>
        <button onclick="zoomIn()">+</button>
    </div>

    <script>
        // Elementos principais
        const mapContainer = document.getElementById('mapContainer');
        const mapImage = document.getElementById('mainMap');
        const dragHint = document.getElementById('dragHint');
        const zoomLevel = document.getElementById('zoomLevel');

        // Variáveis para controle
        let scale = 1;
        let isDragging = false;
        let startX, startY, scrollLeft, scrollTop;

        // Configurações
        const MIN_SCALE = 0.5;
        const MAX_SCALE = 3;
        const SCALE_STEP = 0.2;

        // Tamanho original da imagem (vamos obter quando carregar)
        let imgOriginalWidth = 0;
        let imgOriginalHeight = 0;

        // Quando a imagem carregar, configurar o tamanho original e centralizar
        mapImage.onload = function() {
            imgOriginalWidth = mapImage.naturalWidth;
            imgOriginalHeight = mapImage.naturalHeight;
            
            // Inicialmente, ajustar a imagem para caber na tela (scale apropriado)
            fitToScreen();
            updateZoomDisplay();
            
            // Remover hint após 5 segundos
            setTimeout(() => {
                dragHint.style.display = 'none';
            }, 5000);
        };

        // Ajustar a imagem para caber na tela (fit to screen)
        function fitToScreen() {
            const containerWidth = mapContainer.clientWidth;
            const containerHeight = mapContainer.clientHeight;
            
            // Calcular a escala para caber na tela (fit)
            const scaleX = containerWidth / imgOriginalWidth;
            const scaleY = containerHeight / imgOriginalHeight;
            scale = Math.min(scaleX, scaleY);
            
            // Aplicar a escala
            applyScale();
            
            // Centralizar
            centerMap();
        }

        // Aplicar a escala atual à imagem
        function applyScale() {
            mapImage.style.width = (imgOriginalWidth * scale) + 'px';
            mapImage.style.height = (imgOriginalHeight * scale) + 'px';
        }

        // Centralizar o mapa
        function centerMap() {
            const containerWidth = mapContainer.clientWidth;
            const containerHeight = mapContainer.clientHeight;
            const imageWidth = imgOriginalWidth * scale;
            const imageHeight = imgOriginalHeight * scale;
            
            mapContainer.scrollLeft = (imageWidth - containerWidth) / 2;
            mapContainer.scrollTop = (imageHeight - containerHeight) / 2;
        }

        // Resetar o zoom para caber na tela
        function resetMap() {
            fitToScreen();
        }

        function zoomIn() {
            if (scale < MAX_SCALE) {
                // Aumentar o zoom mantendo o centro da tela
                zoomAtCenter(SCALE_STEP);
            }
        }

        function zoomOut() {
            if (scale > MIN_SCALE) {
                // Diminuir o zoom mantendo o centro da tela
                zoomAtCenter(-SCALE_STEP);
            }
        }

        // Zoom mantendo o centro da tela
        function zoomAtCenter(step) {
            const containerWidth = mapContainer.clientWidth;
            const containerHeight = mapContainer.clientHeight;
            
            // Posição do centro relativa à imagem antes do zoom
            const centerX = mapContainer.scrollLeft + containerWidth / 2;
            const centerY = mapContainer.scrollTop + containerHeight / 2;
            
            // Aplicar o novo zoom
            scale += step;
            scale = Math.max(MIN_SCALE, Math.min(MAX_SCALE, scale));
            applyScale();
            
            // Ajustar a posição do scroll para manter o centro
            const newCenterX = centerX * (1 + step / scale); // Aproximação
            const newCenterY = centerY * (1 + step / scale);
            
            mapContainer.scrollLeft = newCenterX - containerWidth / 2;
            mapContainer.scrollTop = newCenterY - containerHeight / 2;
            
            updateZoomDisplay();
        }

        function updateZoomDisplay() {
            zoomLevel.textContent = `${Math.round(scale * 100)}%`;
        }

        // ===== CONTROLE DE ARRASTE COM MOUSE =====
        
        mapContainer.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - mapContainer.offsetLeft;
            startY = e.pageY - mapContainer.offsetTop;
            scrollLeft = mapContainer.scrollLeft;
            scrollTop = mapContainer.scrollTop;
            mapContainer.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            
            e.preventDefault();
            const x = e.pageX - mapContainer.offsetLeft;
            const y = e.pageY - mapContainer.offsetTop;
            const walkX = (x - startX) * 2;
            const walkY = (y - startY) * 2;
            
            mapContainer.scrollLeft = scrollLeft - walkX;
            mapContainer.scrollTop = scrollTop - walkY;
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
            mapContainer.style.cursor = 'grab';
        });

        // ===== CONTROLE DE TOUCH (MOBILE) =====
        
        let touchStartX, touchStartY, touchScrollLeft, touchScrollTop;

        mapContainer.addEventListener('touchstart', (e) => {
            if (e.touches.length === 1) {
                const touch = e.touches[0];
                touchStartX = touch.pageX;
                touchStartY = touch.pageY;
                touchScrollLeft = mapContainer.scrollLeft;
                touchScrollTop = mapContainer.scrollTop;
                mapContainer.style.cursor = 'grabbing';
            }
        }, { passive: true });

        mapContainer.addEventListener('touchmove', (e) => {
            if (e.touches.length === 1) {
                e.preventDefault();
                const touch = e.touches[0];
                const walkX = (touch.pageX - touchStartX) * 1.5;
                const walkY = (touch.pageY - touchStartY) * 1.5;
                mapContainer.scrollLeft = touchScrollLeft - walkX;
                mapContainer.scrollTop = touchScrollTop - walkY;
            }
        }, { passive: false });

        // ===== ZOOM COM SCROLL DO MOUSE =====
        
        mapContainer.addEventListener('wheel', (e) => {
            e.preventDefault();
            
            if (e.ctrlKey) {
                const zoomFactor = e.deltaY > 0 ? 0.9 : 1.1;
                const newScale = scale * zoomFactor;
                
                if (newScale >= MIN_SCALE && newScale <= MAX_SCALE) {
                    // Zoom no ponto do mouse
                    zoomAtPoint(e.deltaY > 0 ? -SCALE_STEP : SCALE_STEP, e.clientX, e.clientY);
                }
            } else {
                // Scroll normal
                mapContainer.scrollLeft += e.deltaY;
                mapContainer.scrollTop += e.deltaY;
            }
        }, { passive: false });

        // Função para zoom em um ponto específico (mouse)
        function zoomAtPoint(step, clientX, clientY) {
            const containerRect = mapContainer.getBoundingClientRect();
            const x = clientX - containerRect.left;
            const y = clientY - containerRect.top;
            
            // Posição relativa ao contêiner
            const relX = x + mapContainer.scrollLeft;
            const relY = y + mapContainer.scrollTop;
            
            // Novo scale
            scale += step;
            scale = Math.max(MIN_SCALE, Math.min(MAX_SCALE, scale));
            applyScale();
            
            // Ajustar o scroll para manter o ponto sob o mouse
            mapContainer.scrollLeft = relX * (scale / (scale - step)) - x;
            mapContainer.scrollTop = relY * (scale / (scale - step)) - y;
            
            updateZoomDisplay();
        }

        // Atalhos de teclado
        document.addEventListener('keydown', (e) => {
            switch(e.key) {
                case '+':
                case '=':
                    if (e.ctrlKey) zoomIn();
                    break;
                case '-':
                    if (e.ctrlKey) zoomOut();
                    break;
                case '0':
                    if (e.ctrlKey) resetMap();
                    break;
                case 'Home':
                    centerMap();
                    break;
            }
        });

        // Redimensionar a janela
        window.addEventListener('resize', () => {
            // Se estiver com zoom mínimo (fit to screen), reajustar ao redimensionar
            if (scale <= MIN_SCALE + 0.01) { // Considerando margem de erro
                fitToScreen();
            }
        });
    </script>
</body>
</html>