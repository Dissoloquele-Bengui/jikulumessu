@extends('layouts._includes.admin.body')
@section('titulo', 'Lista dos Jogos')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista dos  Jogos
            </h2>
          <div class="p-3 shadow card">
            <div class="card-body">
              <div class="mb-3 toolbar row">
                <div class="ml-auto col">
                    <div class="float-right dropdown">
                      <button class="float-right ml-3 btn btn-primary"
                      class="btn botao" data-toggle="modal" data-target="#ModalCreate"
                      type="button">Adicionar +</button>

                    </div>
                  </div>

              </div>
              <!-- table -->
              <table class="table datatables" id="dataTable-1">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>EQUIPE 1</th>
                    <th>EQUIPE 2</th>
                    <th>DIA</th>
                    <th>HORÁRIO</th>
                    <th>RODADA</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($jogos as $jogo)
                        @php
                            $equipa_1 = $equipas->where('id',$jogo->id_campeonato_equipa_1)->first()->equipa;
                            $equipa_2 = $equipas->where('id',$jogo->id_campeonato_equipa_2)->first()->equipa;
                        @endphp
                        <tr>
                            <td>{{$jogo->id}}</td>
                            <td>{{$equipa_1}}</td>
                            <td>{{$equipa_2}}</td>
                            <td>{{$jogo->dia}}</td>
                            <td>{{$jogo->hora_inicio." ".$jogo->hora_termino}}</td>
                            <td>{{{$jogo->epoca}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$jogo->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.jogo.edit',['id'=>$jogo->id])}}" >{{ __('Editar Resultado') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.jogo.destroy',['id'=>$jogo->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.jogo.purge',['id'=>$jogo->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$jogo->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Jogo') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.jogo.update', ['id' => $jogo->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.jogoForm.index')
                                                <button type="submit" class="btn btn-primary w-md">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-left modal fade" id="ModalResultado{{$jogo->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Resultado do  Jogo') }}</h4>
                                        <div class="ml-auto col">
                                            <div class="float-right dropdown">
                                                <button class="float-right ml-3 btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button">
                                                    Adicionar +
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Links da lista dropdown -->
                                                    <a class="dropdown-item" href="#" onclick="add_gol_field({{$jogo->id}})">Adicionar Gols</a>
                                                    <a class="dropdown-item" href="#" onclick="add_assistencia_field({{$jogo->id}})">Adicionar Assistências</a>
                                                    <!-- Adicione mais itens conforme necessário -->
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.jogo.update_result', ['id' => $jogo->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.jogo_resultForm.index')
                                                <button type="submit" class="btn btn-primary w-md">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ModalUpdate --}}
                    @endforeach
                </tbody>
              </table>

            </div>
          </div>
        </div> <!-- customized table -->
      </div> <!-- end section -->
    </div> <!-- .col-12 -->
  </div> <!-- .row -->
</div> <!-- .container-fluid -->
<script>
    let contador = {};
    let contador_assistencia = {};
    function add_gol_field(id){

        $('#gol_jogador').append('');
        $.ajax({
            url:"{{route('admin.jogo.add_gol_field')}}",
            data:{
                id:id
            },
            method:"GET",
            success: function(response){
                if (!contador.hasOwnProperty(id)) {
                    contador[id] = 0;
                }
                console.log(response); 
                let fields = `
                    <div class="col-md-6 golJogador${contador[id]}">
                        <div class="mb-3 form-group">
                            <label for="Gol">Jogador*</label>
                            <select name="jogador_id${contador[id]}" class="select2 form-control">
                `;
                
                // Iterar sobre os jogadores e adicionar opções ao select
                response.jogadores.forEach(function(jogador) {
                    fields += `<option value="${jogador.id}">${jogador.nome} | ${jogador.equipa}</option>`;
                });

                fields += `
                            </select>
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6 golJogador${contador[id]}">
                        <div class="mb-3 form-group">
                            <label for="Gol">Quantidade de Gols*</label>
                            <input type="number" value="" name="qtd_gol[${contador[id]}]" class="form-control" required>
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-12 golJogador${contador[id]} text-right"> <a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="add_gol_field(${id})">+</a> <a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="removeGolJogador(${contador[id]})">-</a><div>
                    <hr style="color:black" class="golJogador${contador[id]}">
                `;

                // Adiciona os campos ao DOM
                $('#gol_jogador'+id).append(fields);
                $('.select2').select2();
                contador[id]=contador[id]+1;
            },

            error: function(error){
                console.error(error);
            }
        })
    }
    function add_assistencia_field(id){

        $.ajax({
            url:"{{route('admin.jogo.add_gol_field')}}",
            data:{
                id:id
            },
            method:"GET",
            success: function(response){
                console.log(response); 
                if (!contador_assistencia.hasOwnProperty(id)) {
                    contador_assistencia[id] = 0;
                }
                let fields = `
                    <div class="col-md-6 assistenciaJogador${contador_assistencia[id]}">
                        <div class="mb-3 form-group">
                            <label for="Gol">Jogador*</label>
                            <select name="assistencia_id[${contador_assistencia[id]}]" class="select2 form-control">
                `;
                response.jogadores.forEach(function(jogador) {
                    fields += `<option value="${jogador.id}">${jogador.nome} | ${jogador.equipa}</option>`;
                });

                fields += `
                            </select>
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-6 assistenciaJogador${contador_assistencia[id]}">
                        <div class="mb-3 form-group">
                            <label for="Gol">Quantidade de Gols*</label>
                            <input type="number" value="" name="qtd_assistencias[${contador_assistencia[id]}]" class="form-control" required>
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-12 assistenciaJogador${contador_assistencia[id]} text-right"> <a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="add_assistencia_field(${id})">+</a><a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="removeAssistenciaJogador(${contador_assistencia[id]})">-</a><div>
                    <hr class="assistenciaJogador${contador_assistencia[id]}" style="color:black">
                `;

                // Adiciona os campos ao DOM
                $('#assistencia_jogador'+id).append(fields);
                $('.select2').select2();
                contador_assistencia[id]+=1;
            },

            error: function(error){
                console.error(error);
            }
        })
    }
    function removeGolJogadorDB(id){
        $.ajax({
            url:"{{route('admin.jogo.remove_gol')}}",
            data:{
                id:id
            },
            method:"GET",
            success: function(response){
                $('.golJogadorDB'+id).remove();
            },

            error: function(error){
                console.error(error);
            }
        })
    }
    function removeAssistenciaJogadorDB(id){
        $.ajax({
            url:"{{route('admin.jogo.remove_assistencia')}}",
            data:{
                id:id
            },
            method:"GET",
            success: function(response){
                $('.assistenciaJogadorDB'+id).remove();
            },

            error: function(error){
                console.error(error);
            }
        })
    }
    function removeGolJogador(id){
        $('.golJogador'+id).remove();
    }
    function removeAssistenciaJogador(id){
        $('.assistenciaJogador'+id).remove();
    }
</script>
{{-- ModalCreate --}}
<div class="text-left modal fade" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Adicionar Jogo') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.jogo.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $jogo = null }}
                        @include('_form.jogoForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}

<script>
    function change_team_fields(){
        let option = $('#id_campeonato').val();
        
        // Fazer solicitação AJAX para obter os dados filtrados do servidor
        $.ajax({
            url: "{{route('admin.jogo.getDataByCampeonato')}}",
            method: 'GET',
            data:{
                id: option
            },
            success: function(response) {
                $('#id_epoca').empty();
                $('#id_campeonato_equipa_1').empty();
                $('#id_campeonato_equipa_2').empty();
                console.log(response);
                $.each(response.epocas, function(index, epoca) {
                    $('#id_epoca').append('<option value="' + epoca.id + '">' + epoca.nome + '</option>');
                });
                $.each(response.equipas, function(index, equipa) {
                    
                    $('#id_campeonato_equipa_1').append('<option value="' + equipa.id + '">' + equipa.equipa + '</option>');
                    $('#id_campeonato_equipa_2').append('<option value="' + equipa.id + '">' + equipa.equipa + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error(error," "+status+" "+xhr);
            }
        });
        
        $('.select2').select2();

    }
</script>
@if (session('jogo.destroy.success'))
    <script>
        Swal.fire(
            'Jogo Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogo.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Jogo!',
            '',
            'error'
        )
    </script>
@endif
@if (session('jogo.purge.success'))
    <script>
        Swal.fire(
            'Jogo Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogo.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Jogo!',
            '',
            'error'
        )
    </script>
@endif
@if (session('jogo.create.success'))
    <script>
        Swal.fire(
            'Jogo Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogo.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Jogo!',
            '',
            'error'
        )
    </script>
@endif
@if (session('jogo.update.success'))
    <script>
        Swal.fire(
            'Jogo Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogo.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Jogo!',
            '',
            'error'
        )
    </script>
@endif
@endsection
