<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Localizar veículos </title>
    <link rel="stylesheet" href="visualization/viewpeople.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="{{asset('home/home pictures/home.css')}}">
    <script defer src="{{asset('home/home pictures/home.js')}}"></script>
    <!-- fonte -->
    <script src="{{asset('painel/js/jquery.min.js')}}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Incluindo o CSS do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #mapa {
            height: calc(100vh - 50px); /* Altura do mapa ajustada para ocupar o restante da tela */
            width: 100%;
        }

        .menu {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000; /* Garante que o menu está sobre o mapa */
        }

        .listamenu {
            list-style-type: none;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        .listamenu li {
            float: right;
        }

        .listamenu li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .listamenu li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="menu bg-primary" style="justify-content: space-around !important">
            <a href="/" class="text-white Logo" >JIKULUMESU</a>
            <button class="group"></button>
            <ul class="listamenu">
                <li><a href="/">Voltar</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="{{ route('logout') }}"   onclick="event.preventDefault(); this.closest('form').submit();">Terminar Sessão</a>
                    </form>
                </li>
            </ul>
        </nav>
    </header>
    <div id="mapa"></div>

    <!-- simulação de um trajecto -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        var mapa;
        var pessoaMarker, carroMarker, linhaMovimento, linhaRota;

        // Iniciar o mapa com as posições iniciais
        iniciarMapa();

        // Função para iniciar o mapa e atualizar as posições
        function iniciarMapa() {
            mapa = L.map('mapa').setView([0, 0], 11); // Definir a visão inicial com valores temporários

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(mapa);

            // Obter a posição inicial da pessoa do navegador
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var minhaLatitude = position.coords.latitude;
                    var minhaLongitude = position.coords.longitude;

                    pessoaMarker = L.marker([minhaLatitude, minhaLongitude]).addTo(mapa);

                    mapa.setView([minhaLatitude, minhaLongitude], 11); // Definir a visão para a posição da pessoa

                    // Obter a posição inicial do carro
                    var carro = {!! json_encode($carro) !!};
                    var carroLatitude = parseFloat(carro.latitude);
                    var carroLongitude = parseFloat(carro.longitude);

                    carroMarker = L.marker([carroLatitude, carroLongitude]).addTo(mapa);

                    // Roteamento da pessoa ao carro
                    linhaRota =  L.Routing.control({
                        waypoints: [
                            L.latLng(minhaLatitude, minhaLongitude),
                            L.latLng(carroLatitude, carroLongitude)
                        ],
                        language: 'es', // Altere para o idioma desejado
                        lineOptions: {
                            styles: [{color: 'blue', opacity: 0.6, weight: 6}]
                        }
                    }).addTo(mapa);

                    // Linha de movimento do carro (vermelha)
                    linhaMovimento = L.polyline([carroMarker.getLatLng()], { color: 'red' }).addTo(mapa);

                    // Linha de rota da pessoa ao carro (azul)
                    linhaRota.addTo(mapa);

                    setInterval(function() {
                        $.ajax({
                            url: "{{route('admin.carro.getLocalizacao',['id'=>Auth::id()])}}",
                            success: function(result) {
                                var novaCoordenadaCarro = {
                                    latitude: result.carro['latitude'], // Simulação de mudança de coordenadas do carro
                                    longitude: result.carro['longitude']
                                };

                                var novaCoordenadaPessoa = {
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude
                                };

                                // Atualizar a posição do carro no mapa
                                carroMarker.setLatLng([novaCoordenadaCarro.latitude, novaCoordenadaCarro.longitude]);

                                // Atualizar a posição da pessoa no mapa
                                pessoaMarker.setLatLng([novaCoordenadaPessoa.latitude, novaCoordenadaPessoa.longitude]);

                                // Atualizar a linha de movimento do carro
                                linhaMovimento.addLatLng([novaCoordenadaCarro.latitude, novaCoordenadaCarro.longitude]);

                                // Atualizar a linha de rota da pessoa ao carro
                                linhaRota.setWaypoints([
                                    L.latLng(novaCoordenadaPessoa.latitude, novaCoordenadaPessoa.longitude),
                                    L.latLng(novaCoordenadaCarro.latitude, novaCoordenadaCarro.longitude)
                                ]).addTo(mapa);
                        },
                            error: function(error) {
                                console.log(error);
                            }
                        });


                    }, 10000);

                }, function(error) {
                    console.error("Erro ao obter a localização:", error);
                });
            } else {
                console.log("Geolocalização não suportada pelo navegador.");
            }
        }
    </script>
</body>
</html>
