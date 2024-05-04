<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Localizar veículos </title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <link rel="stylesheet" href="visualization/viewpeople.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

  <!-- Incluindo o CSS do Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #mapa {
           height: 80vh;
           width: 100%;
        }
    </style>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.movingmarker/L.MovingMarker.js"></script>
<!-- fonte -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body>
    <div class="dados">
        <div class="veiculos"></div>
        <div class="veiculos"></div>
        <div class="veiculos"></div>
        <div class="veiculos"></div>
    </div>

    <div class="geral">
        <div id="mapa"></div>
<div class="coordenadas">

</div>
    </div>

    <!-- simulação de um trajecto -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        var mapa = L.map('mapa').setView([-8.835, 13.27], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
        }).addTo(mapa);

        var marcadorFILDA = L.marker([-8.8505, 13.2884]).addTo(mapa);
        marcadorFILDA.bindPopup("<b>FILDA</b>");

        var marcadorITEL = L.marker([-8.8189, 13.2671]).addTo(mapa);
        marcadorITEL.bindPopup("<b>ITEL</b>");

        // Inicializar a linha tracejada
        var polyline = L.polyline([], { color: 'red', dashArray: '10,10' }).addTo(mapa);

        // Função para atualizar a posição do marcador e adicionar ao caminho percorrido
        function atualizarPosicao(lat, lng) {
          marcadorFILDA.setLatLng([lat, lng]);
          marcadorFILDA.getPopup().setContent("<b>Coordenadas:</b> " + lat + ", " + lng);

          // Adicionar a nova posição à linha tracejada
          polyline.addLatLng([lat, lng]);
        }

        // Exemplo de atualização de posição a cada segundo (1000ms)
        setInterval(function() {
          // Aqui você pode obter as coordenadas do corpo em movimento
          // Vou usar coordenadas aleatórias para demonstração
          var novaLat = -8.8505 + (Math.random() - 0.5) * 0.01;
          var novaLng = 13.2884 + (Math.random() - 0.5) * 0.01;
          atualizarPosicao(novaLat, novaLng);
        }, 1000);

      </script>

      </body>

</html>
