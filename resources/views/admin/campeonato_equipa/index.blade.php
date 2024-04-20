@extends('layouts._includes.admin.body')
@section('titulo', 'Listar Equipas/Campeonatos')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista dos  Equipas/Campeonatos
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
                    <th>EQUIPA</th>
                    <th>CAMPEONATO</th>
                    <th>VITORIAS</th>
                    <th>DERROTAS</th>
                    <th>EMPATES</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($campeonato_equipas as $campeonato_equipa)
                        <tr>
                            <td>{{$campeonato_equipa->id}}</td>
                            <td>{{{$campeonato_equipa->equipa}}}</td>
                            <td>{{{$campeonato_equipa->campeonato}}}</td>
                            <td>{{{$campeonato_equipa->vitorias}}}</td>
                            <td>{{{$campeonato_equipa->derrotas}}}</td>
                            <td>{{{$campeonato_equipa->empates}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$campeonato_equipa->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato_equipa.destroy',['id'=>$campeonato_equipa->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.campeonato_equipa.purge',['id'=>$campeonato_equipa->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$campeonato_equipa->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Equipa/Campeonato') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.campeonato_equipa.update', ['id' => $campeonato_equipa->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.campeonato_equipaForm.index')
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
                <h4 class="modal-title">{{ __('Adicionar Equipa/Campeonato') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.campeonato_equipa.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $campeonato_equipa = null }}
                        @include('_form.campeonato_equipaForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}
@if (session('campeonato_equipa.destroy.success'))
    <script>
        Swal.fire(
            'Equipa/Campeonato Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato_equipa.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Equipa/Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@if (session('campeonato_equipa.purge.success'))
    <script>
        Swal.fire(
            'Equipa/Campeonato Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato_equipa.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Equipa/Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@if (session('campeonato_equipa.create.success'))
    <script>
        Swal.fire(
            'Equipa/Campeonato Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato_equipa.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Equipa/Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@if (session('campeonato_equipa.update.success'))
    <script>
        Swal.fire(
            'Equipa/Campeonato Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('campeonato_equipa.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Equipa/Campeonato!',
            '',
            'error'
        )
    </script>
@endif
@endsection
