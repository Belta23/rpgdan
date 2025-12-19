<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Mapa de Calradia</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>
<script
  src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

<style>
html, body {
  height: 100%;
  margin: 0;
  background: #0f0f14;
}

#map {
  width: 100%;
  height: 100%;
}

.leaflet-control-zoom a {
  background: #1a1a24;
  color: #d4af37;
  border: 1px solid rgba(212,175,55,0.35);
}
</style>
</head>

<body>

<div id="map"></div>

<script>
  const mapWidth  = 19200;
  const mapHeight = 14400;

  const map = L.map('map', {
    crs: L.CRS.Simple,
    minZoom: 0,
    maxZoom: 6,
    zoomControl: true
  });

  const bounds = [
    [0, 0],
    [mapHeight, mapWidth]
  ];

  L.tileLayer('tiles/{z}/{x}/{y}.png', {
    minZoom: 0,
    maxZoom: 6,
    bounds: bounds,
    noWrap: true
  }).addTo(map);

  map.fitBounds(bounds);
</script>

</body>
</html>
