@extends('layouts._includes.admin.body')
@section('titulo', 'Dashboard')

@section('conteudo')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="h5 page-title">Dashboard</h2>
                <p class="text-muted">Gestão de Campeonatos de Futebol</p>
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
                                        <p class="mb-0 small text-muted">Campeonatos</p>
                                        <span class="mb-0 h3">2</span>
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
                                        <p class="mb-0 small text-light">Equipas</p>
                                        <span class="mb-0 text-white h3">1</span>
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
                                <strong class="mb-0 card-title">Estatísticas de Campeonatos e Equipas</strong>
                            </div>
                            <div class="card-body">
                                <canvas id="campeonatos-equipas" width="100%" height="400"></canvas>
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
            var campeonatos = [10, 15, 20, 25, 30];
            var equipas = [45, 50, 55, 60, 65];

            var ctx = document.getElementById('campeonatos-equipas').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai'],
                    datasets: [{
                        label: 'Campeonatos',
                        borderColor: 'rgb(255, 99, 132)',
                        data: campeonatos,
                        fill: false
                    }, {
                        label: 'Equipas',
                        borderColor: 'rgb(54, 162, 235)',
                        data: equipas,
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
        });
    </script>
@endsection
