@extends('layouts._includes.admin.body')
@section('titulo','Actualizar Resultado do Jogo')

@section('conteudo')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Actualizar Resultado do Jogo</strong>
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
        </div>
        <div class="card-body">
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

@if (session('jogo.update_result.success'))
    <script>
        Swal.fire(
            'Resultado do Jogo Actualizada com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogo.update_result.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Resultado do Jogo!',
            '',
            'error'
        )
    </script>
@endif
<script>
    let contador = {};
    let contador_assistencia = {};
    function add_gol_field(id){
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
                            <select name="jogador_id[${contador[id]}]" class="select2 form-control">
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
                console.log(response);
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

@endsection
