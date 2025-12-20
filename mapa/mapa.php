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
            user-select: none; /* Previne seleção de texto ao arrastar */
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
            -webkit-overflow-scrolling: touch; /* Scroll suave no iOS */
        }

        .map-container:active {
            cursor: grabbing;
        }

        /* Imagem do mapa */
        .map-image {
            display: block;
            min-width: 100%;
            min-height: 100%;
            max-width: none; /* Permite que a imagem exceda o contêiner */
            /* Centralizar inicialmente */
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            transition: transform 0.1s ease-out;
        }

        /* Sobreposições (bandeiras, etc.) */
        .map-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Permite clicar através da overlay */
            z-index: 2;
        }

        /* Bandeira dos Nords como exemplo */
        .nord-flag {
            position: absolute;
            width: 60px;
            height: 60px;
            background-image: url('nords.png');
            background-size: contain;
            background-repeat: no-repeat;
            pointer-events: auto; /* Permite clicar na bandeira */
            cursor: pointer;
            transform: translate(-50%, -50%);
            transition: transform 0.2s;
            z-index: 3;
        }

        .nord-flag:hover {
            transform: translate(-50%, -50%) scale(1.1);
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

        /* Estilo para scrollbar (opcional) */
        .map-container::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .map-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        .map-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Contêiner principal do mapa -->
    <div class="map-container" id="mapContainer">
        <!-- Imagem do mapa (substitua pelo seu caminho correto) -->
        <img src="origial/mapa_calradia.png"
             class="map-image"
             alt="Mapa de Calradia"
             id="mainMap"
             draggable="false">
        
        <!-- Overlay para elementos interativos -->
        <div class="map-overlay" id="mapOverlay">
            <!-- Exemplo: Bandeira dos Nords -->
            <!-- Posicione essas divs usando JavaScript ou coordenadas fixas -->
            <div class="nord-flag" style="top: 30%; left: 40%;" 
                 title="Reino dos Nords" 
                 onclick="alert('Reino dos Nords selecionado!')">
            </div>
            
            <!-- Adicione mais bandeiras/frações aqui -->
        </div>
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
        let autoScrollInterval = null;

        // Configurações
        const MIN_SCALE = 0.5;
        const MAX_SCALE = 3;
        const SCALE_STEP = 0.2;

        // Centralizar o mapa ao carregar
        window.addEventListener('load', () => {
            centerMap();
            
            // Remover hint após 5 segundos
            setTimeout(() => {
                dragHint.style.display = 'none';
            }, 5000);
        });

        // ===== FUNÇÕES DE CONTROLE =====
        
        function centerMap() {
            // Centraliza a imagem no contêiner
            mapContainer.scrollLeft = (mapImage.width - mapContainer.clientWidth) / 2;
            mapContainer.scrollTop = (mapImage.height - mapContainer.clientHeight) / 2;
            updateZoomDisplay();
        }

        function resetMap() {
            scale = 1;
            mapImage.style.transform = `translate(-50%, -50%) scale(${scale})`;
            centerMap();
        }

        function zoomIn() {
            if (scale < MAX_SCALE) {
                scale += SCALE_STEP;
                applyZoom();
            }
        }

        function zoomOut() {
            if (scale > MIN_SCALE) {
                scale -= SCALE_STEP;
                applyZoom();
            }
        }

        function applyZoom() {
            // Salva a posição atual do scroll
            const scrollCenterX = mapContainer.scrollLeft + mapContainer.clientWidth / 2;
            const scrollCenterY = mapContainer.scrollTop + mapContainer.clientHeight / 2;
            
            // Aplica o zoom
            mapImage.style.transform = `translate(-50%, -50%) scale(${scale})`;
            
            // Ajusta o scroll para manter o foco no mesmo ponto
            setTimeout(() => {
                mapContainer.scrollLeft = scrollCenterX - mapContainer.clientWidth / 2;
                mapContainer.scrollTop = scrollCenterY - mapContainer.clientHeight / 2;
            }, 10);
            
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
            const walkX = (x - startX) * 2; // Velocidade do arraste
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
        let lastTouchTime = 0;

        mapContainer.addEventListener('touchstart', (e) => {
            if (e.touches.length === 1) {
                const touch = e.touches[0];
                touchStartX = touch.pageX;
                touchStartY = touch.pageY;
                touchScrollLeft = mapContainer.scrollLeft;
                touchScrollTop = mapContainer.scrollTop;
                mapContainer.style.cursor = 'grabbing';
                
                // Detecta double tap para zoom
                const currentTime = new Date().getTime();
                if (currentTime - lastTouchTime < 300) {
                    // Double tap detected
                    if (scale < MAX_SCALE) {
                        zoomIn();
                    } else {
                        resetMap();
                    }
                }
                lastTouchTime = currentTime;
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
            
            if (e.ctrlKey) { // Ctrl + Scroll = zoom
                const zoomFactor = e.deltaY > 0 ? 0.9 : 1.1;
                const newScale = scale * zoomFactor;
                
                if (newScale >= MIN_SCALE && newScale <= MAX_SCALE) {
                    scale = newScale;
                    applyZoom();
                }
            } else {
                // Scroll normal para navegação
                mapContainer.scrollLeft += e.deltaY;
                mapContainer.scrollTop += e.deltaY;
            }
        }, { passive: false });

        // ===== AUTO-SCROLL NAS BORDAS (OPCIONAL) =====
        
        function startAutoScroll(directionX, directionY) {
            if (autoScrollInterval) clearInterval(autoScrollInterval);
            
            autoScrollInterval = setInterval(() => {
                mapContainer.scrollLeft += directionX * 20;
                mapContainer.scrollTop += directionY * 20;
            }, 16); // ~60fps
        }

        function stopAutoScroll() {
            if (autoScrollInterval) {
                clearInterval(autoScrollInterval);
                autoScrollInterval = null;
            }
        }

        // Inicializar
        centerMap();
        mapContainer.style.cursor = 'grab';

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

        // Log de informações úteis (remova em produção)
        console.log('Mapa de Calradia carregado!');
        console.log('Dica: Use mouse para arrastar, scroll para navegar, Ctrl+scroll para zoom');
    </script>
</body>
</html>