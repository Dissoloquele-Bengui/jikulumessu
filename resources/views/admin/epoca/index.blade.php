@extends('layouts._includes.admin.body')
@section('titulo', 'Listar Épocas')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista das  Épocas
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
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($epocas as $epoca)
                        <tr>
                            <td>{{$epoca->id}}</td>
                            <td>{{{$epoca->nome}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$epoca->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.epoca.destroy',['id'=>$epoca->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.epoca.purge',['id'=>$epoca->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$epoca->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Época') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.epoca.update', ['id' => $epoca->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.epocaForm.index')
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Adicionar Época') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.epoca.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $epoca = null }}
                        @include('_form.epocaForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}
@if (session('epoca.destroy.success'))
    <script>
        Swal.fire(
            'Época Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('epoca.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Época!',
            '',
            'error'
        )
    </script>
@endif
@if (session('epoca.purge.success'))
    <script>
        Swal.fire(
            'Época Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('epoca.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Época!',
            '',
            'error'
        )
    </script>
@endif
@if (session('epoca.create.success'))
    <script>
        Swal.fire(
            'Época Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('epoca.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Época!',
            '',
            'error'
        )
    </script>
@endif
@if (session('epoca.update.success'))
    <script>
        Swal.fire(
            'Época Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('epoca.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Época!',
            '',
            'error'
        )
    </script>
@endif
@endsection
