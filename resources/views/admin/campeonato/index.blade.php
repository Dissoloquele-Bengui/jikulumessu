@extends('layouts._includes.admin.body')
@section('titulo', 'Listar Campeonatos')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista dos  Campeonatos
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
                    <th>NOME</th>
                    <th>TIPO</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($campeonatos as $campeonato)
                        <tr>
                            <td>{{$campeonato->id}}</td>
                            <td>{{{$campeonato->nome}}}</td>
                            <td>{{{$campeonato->tipo}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$campeonato->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato.classificacao',['id'=>$campeonato->id])}}">{{ __('Classificação') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato.calendario',['id'=>$campeonato->id])}}">{{ __('Calendário') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato.resultado',['id'=>$campeonato->id])}}">{{ __('Resultados') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato.gols',['id'=>$campeonato->id])}}">{{ __('Melhores Marcadores') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato.assistencias',['id'=>$campeonato->id])}}">{{ __('Melhores Assistentes') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato.destroy',['id'=>$campeonato->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato.purge',['id'=>$campeonato->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$campeonato->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Campeonato') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.campeonato.update', ['id' => $campeonato->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.campeonatoForm.index')
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

{{-- ModalCreate --}}
<div class="text-left modal fade" id="ModalCreate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Adicionar Campeonato') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.campeonato.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $campeonato = null }}
                        @include('_form.campeonatoForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}
<script>
    const field = `    <div class="col-md-12">
            <div class="mb-3 form-group">
            <label for="number">Numero de Fases*</label>
            <input type="number"   name="numero" class="form-control"  required>
        </div>
    </div> <!-- /.col -->`; 
    function add_number_phase_field(){

        let option = $('#tipo').val();
        if(option == "Liga" || option == "Mista"){
            $('#phase_container').append(field);
        }else{
            $('#phase_container').html('');
            
        }
    }
    function add_number_phase_field_update(){

        let option = $('#tipo').val();
        if(option == "Liga" || option == "Mista"){
            $('#phase_container').append(field);
        }else{
            $('#phase_container').html('');
            
        }
    }
</script>
@if (session('campeonato.destroy.success'))
    <script>
        Swal.fire(
            'Campeonato Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@if (session('campeonato.purge.success'))
    <script>
        Swal.fire(
            'Campeonato Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@if (session('campeonato.create.success'))
    <script>
        Swal.fire(
            'Campeonato Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@if (session('campeonato.update.success'))
    <script>
        Swal.fire(
            'Campeonato Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@endsection
