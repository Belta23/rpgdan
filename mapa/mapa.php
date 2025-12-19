<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Mapa de Calradia</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@latest/ol.css">

<style>
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
}
#map {
  width: 100%;
  height: 100vh;
}
</style>
</head>

<body>

<div id="map"></div>

<script src="https://cdn.jsdelivr.net/npm/ol@latest/ol.js"></script>

<script>
const map = new ol.Map({
  target: 'map',
  layers: [
    new ol.layer.Tile({
      source: new ol.source.XYZ({
        url: 'tiles/{z}/{x}/{y}.png',
        minZoom: 0,
        maxZoom: 6
      })
    })
  ],
  view: new ol.View({
    center: ol.proj.fromLonLat([0, 0]),
    zoom: 2
  })
});
</script>

</body>
</html>
