<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Localizar Individuos </title>
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
        var pessoaMarker, individuoMarker, linhaMovimento, linhaRota;
        var pessoaCoordenadas = []; // Array para armazenar as coordenadas da pessoa
        var individuoCoordenadas = []; // Array para armazenar as coordenadas do indivíduo

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
                    pessoaMarker.bindTooltip('EU').openTooltip(); // Adicionar label "EU" ao
                    mapa.setView([minhaLatitude, minhaLongitude], 11); // Definir a visão para a posição da pessoa

                    // Obter a posição inicial do indivíduo
                    var individuo = {!! json_encode($individuo) !!};
                    console.log(individuo);
                    var individuoLatitude = parseFloat(individuo.latitude);
                    var individuoLongitude = parseFloat(individuo.longitude);
                    var individuoNome = individuo.nome;
                    individuoMarker = L.marker([individuoLatitude, individuoLongitude]).addTo(mapa);
                    individuoMarker.bindTooltip(individuoNome).openTooltip(); // Adicionar label "EU" ao
                    // Roteamento da pessoa ao indivíduo
                    linhaRota =  L.Routing.control({
                        waypoints: [
                            L.latLng(minhaLatitude, minhaLongitude),
                            L.latLng(individuoLatitude, individuoLongitude)
                        ],
                        language: 'es', // Altere para o idioma desejado
                        lineOptions: {
                            styles: [{color: 'blue', opacity: 0.6, weight: 6}]
                        }
                    }).addTo(mapa);

                    // Linha de movimento do indivíduo (vermelha)
                    linhaMovimento = L.polyline([individuoMarker.getLatLng()], { color: 'red' }).addTo(mapa);

                    // Linha de rota da pessoa ao indivíduo (azul)
                    linhaRota.addTo(mapa);

                    setInterval(function() {
                        $.ajax({
                            url: "{{route('admin.people.getLocalizacao',['id'=>Auth::id()])}}",
                            success: function(result) {
                                var novaCoordenadaIndividuo = {
                                    latitude: result.individuo['latitude'], // Simulação de mudança de coordenadas do indivíduo
                                    longitude: result.individuo['longitude']
                                };

                                var novaCoordenadaPessoa = {
                                    latitude: position.coords.latitude,
                                    longitude: position.coords.longitude
                                };

                                // Adicionar novas coordenadas aos arrays
                                pessoaCoordenadas.push([novaCoordenadaPessoa.latitude, novaCoordenadaPessoa.longitude]);
                                individuoCoordenadas.push([novaCoordenadaIndividuo.latitude, novaCoordenadaIndividuo.longitude]);

                                // Atualizar a posição do indivíduo no mapa
                                individuoMarker.setLatLng([novaCoordenadaIndividuo.latitude, novaCoordenadaIndividuo.longitude]);

                                // Atualizar a posição da pessoa no mapa
                                pessoaMarker.setLatLng([novaCoordenadaPessoa.latitude, novaCoordenadaPessoa.longitude]);

                                // Atualizar a linha de movimento do indivíduo
                                linhaMovimento.setLatLngs(individuoCoordenadas);

                                // Atualizar a linha de rota da pessoa ao indivíduo
                                linhaRota.setWaypoints([
                                    L.latLng(novaCoordenadaPessoa.latitude, novaCoordenadaPessoa.longitude),
                                    L.latLng(novaCoordenadaIndividuo.latitude, novaCoordenadaIndividuo.longitude)
                                ]);
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
