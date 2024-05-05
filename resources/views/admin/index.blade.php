@extends('layouts._includes.admin.body')
@section('titulo', 'Dashboard')

@section('conteudo')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">Dashboard</h2>
                <p class="text-muted">Geolocalização de Veiculos e Pessoas</p>
                <div class="row">
                    <div class="mb-4 col-md-6 col-xl-3">
                        <div class="shadow card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="text-center col-3">
                                        <span class="circle circle-sm bg-primary">
                                            <i class="mb-0 text-white fe fe-16 fe-file-text"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <p class="mb-0 small text-muted">Clientes Singulares</p>
                                        <span class="mb-0 h3" id="total-clientes-singulares">{{$clientes}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 col-md-6 col-xl-3">
                        <div class="text-white shadow card bg-primary">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="text-center col-3">
                                        <span class="circle circle-sm bg-primary-light">
                                            <i class="mb-0 text-white fe bi bi-building"></i>
                                        </span>
                                    </div>
                                    <div class="pr-0 col">
                                        <p class="mb-0 small text-light">Veículos</p>
                                        <span class="mb-0 text-white h3" id="total-veiculos">{{$veiculos}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-4 col-md-12">
                        <div class="shadow card">
                            <div class="card-header">
                                <strong class="mb-0 card-title">Estatísticas de Clientes e Veículos</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="clientes-veiculos" width="100%" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Dados fictícios
            var clientes = {!! json_encode($total_clientes) !!};
            var meses = {!! json_encode($meses) !!};

            var ctx = document.getElementById('clientes-veiculos').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{
                        label: 'Clientes',
                        borderColor: 'rgb(255, 99, 132)',
                        data: clientes,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Mês'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Quantidade'
                            }
                        }
                    }
                }
            });

            // Atualizar dados do dashboard
            /*function atualizarDashboard() {
                // Aqui você deve fazer uma requisição AJAX para obter os dados atualizados
                var totalClientesSingulares = 50; // Substitua pelo valor real
                var totalVeiculos = 30; // Substitua pelo valor real

                $('#total-clientes-singulares').text(totalClientesSingulares);
                $('#total-veiculos').text(totalVeiculos);
            }

            // Atualizar dashboard a cada 3 minutos
            setInterval(atualizarDashboard, 180000);*/ // 3 minutos
        });
    </script>
@endsection
