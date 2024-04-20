@extends('layouts._includes.admin.body')
@section('titulo', 'Listar Jogadores')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista dos  Jogadores
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
                    <th>DATA DE NASCIMENTO</th>
                    <th>POSIÇÃO</th>
                    <th>EQUIPA</th>
                    <th>NÚMERO DE CAMISA</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($jogadores as $jogador)
                        <tr>
                            <td>{{$jogador->id}}</td>
                            <td>{{{$jogador->nome}}}</td>
                            <td>{{{$jogador->data_nascimento}}}</td>
                            <td>{{{$jogador->posicao}}}</td>
                            <td>{{{$jogador->equipa}}}</td>
                            <td>{{{$jogador->numero}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$jogador->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.jogador.destroy',['id'=>$jogador->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.jogador.purge',['id'=>$jogador->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$jogador->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Jogador') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.jogador.update', ['id' => $jogador->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.jogadorForm.index')
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
                <h4 class="modal-title">{{ __('Adicionar Jogador') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.jogador.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $jogador = null }}
                        @include('_form.jogadorForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}
@if (session('jogador.destroy.success'))
    <script>
        Swal.fire(
            'Jogador Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogador.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Jogador!',
            '',
            'error'
        )
    </script>
@endif
@if (session('jogador.purge.success'))
    <script>
        Swal.fire(
            'Jogador Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogador.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Jogador!',
            '',
            'error'
        )
    </script>
@endif
@if (session('jogador.create.success'))
    <script>
        Swal.fire(
            'Jogador Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogador.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Jogador!',
            '',
            'error'
        )
    </script>
@endif
@if (session('jogador.update.success'))
    <script>
        Swal.fire(
            'Jogador Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('jogador.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Jogador!',
            '',
            'error'
        )
    </script>
@endif
@endsection
