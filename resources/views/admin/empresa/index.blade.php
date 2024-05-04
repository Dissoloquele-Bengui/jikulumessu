@extends('layouts._includes.admin.body')
@section('titulo', 'Listar Empresas')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista das  Empresas
            </h2>
          <div class="p-3 shadow card">
            <div class="card-body">
              <div class="mb-3 toolbar row">
                @if (Auth::user()->nivel!="Funcionário")
                    <div class="ml-auto col">
                        <div class="float-right dropdown">
                        <button class="float-right ml-3 btn btn-primary"
                        class="btn botao" data-toggle="modal" data-target="#ModalCreate"
                        type="button">Adicionar +</button>

                        </div>
                    </div>
                @endif

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
                    @foreach ($empresas as $empresa)
                        <tr>
                            <td>{{$empresa->id}}</td>
                            <td>{{{$empresa->nome}}}</td>
                            <td>
                                @if (Auth::user()->nivel!="Funcionário")
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                        <span class="sr-only text-muted">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$empresa->id}}">{{ __('Editar') }}</a>
                                            <a class="dropdown-item" href="{{route('admin.empresa.destroy',['id'=>$empresa->id])}}">{{ __('Remover') }}</a>
                                            <a class="dropdown-item" href="{{route('admin.empresa.purge',['id'=>$empresa->id])}}">{{ __('Purgar') }}</a>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$empresa->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Empresa') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.empresa.update', ['id' => $empresa->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.empresaForm.index')
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
                <h4 class="modal-title">{{ __('Adicionar Empresa') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.empresa.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $empresa = null }}
                        @include('_form.empresaForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}
@if (session('empresa.destroy.success'))
    <script>
        Swal.fire(
            'Empresa Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('empresa.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Empresa!',
            '',
            'error'
        )
    </script>
@endif
@if (session('empresa.purge.success'))
    <script>
        Swal.fire(
            'Empresa Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('empresa.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Empresa!',
            '',
            'error'
        )
    </script>
@endif
@if (session('empresa.create.success'))
    <script>
        Swal.fire(
            'Empresa Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('empresa.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Empresa!',
            '',
            'error'
        )
    </script>
@endif
@if (session('empresa.update.success'))
    <script>
        Swal.fire(
            'Empresa Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('empresa.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Empresa!',
            '',
            'error'
        )
    </script>
@endif
@endsection
