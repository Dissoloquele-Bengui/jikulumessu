@extends('layouts._includes.admin.body')
@section('titulo', 'Listar Carros')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista dos  Carros
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
                    <th>MARCA</th>
                    <th>MODELO</th>
                    <th>MATRICULA</th>
                    <th>PROPRIETÉRIO</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($carros as $carro)
                        <tr>
                            <td>{{$carro->id}}</td>
                            <td>{{{$carro->marca}}}</td>
                            <td>{{{$carro->modelo}}}</td>
                            <td>{{{$carro->matricula}}}</td>
                            <td>{{{$carro->proprietario}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$carro->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.carro.destroy',['id'=>$carro->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.carro.purge',['id'=>$carro->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$carro->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Carro') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.carro.update', ['id' => $carro->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.carroForm.index')
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
                <h4 class="modal-title">{{ __('Adicionar Carro') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.carro.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $carro = null }}
                        @include('_form.carroForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}
@if (session('carro.destroy.success'))
    <script>
        Swal.fire(
            'Carro Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('carro.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Carro!',
            '',
            'error'
        )
    </script>
@endif
@if (session('carro.purge.success'))
    <script>
        Swal.fire(
            'Carro Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('carro.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Carro!',
            '',
            'error'
        )
    </script>
@endif
@if (session('carro.create.success'))
    <script>
        Swal.fire(
            'Carro Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('carro.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Carro!',
            '',
            'error'
        )
    </script>
@endif
@if (session('carro.update.success'))
    <script>
        Swal.fire(
            'Carro Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('carro.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Carro!',
            '',
            'error'
        )
    </script>
@endif
@endsection
