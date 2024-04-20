@extends('layouts._includes.admin.body')
@section('titulo', 'Lista das  Equipas')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista das  Equipas
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
                    <th>LOGO</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($equipas as $equipa)
                        <tr>
                            <td>{{$equipa->id}}</td>
                            <td>{{{$equipa->nome}}}</td>
                            <td><img src="{{asset($equipa->logo)}}" width="100px" height="80px" style="border-radius:100%" alt="Logo do Clube"></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$equipa->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.equipa.destroy',['id'=>$equipa->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.equipa.purge',['id'=>$equipa->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$equipa->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Equipa') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.equipa.update', ['id' => $equipa->id]) }}
                                            " method="post" enctype="multipart/form-data" >
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.equipaForm.index')
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
                <h4 class="modal-title">{{ __('Adicionar Equipa') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.equipa.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="card-body">
                        {{ $equipa = null }}
                        @include('_form.equipaForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ModalCreate --}}
@if (session('equipa.destroy.success'))
    <script>
        Swal.fire(
            'Equipa Eliminada com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('equipa.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Equipa!',
            '',
            'error'
        )
    </script>
@endif
@if (session('equipa.purge.success'))
    <script>
        Swal.fire(
            'Equipa Purgada com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('equipa.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Equipa!',
            '',
            'error'
        )
    </script>
@endif
@if (session('equipa.create.success'))
    <script>
        Swal.fire(
            'Equipa Cadastrada com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('equipa.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Equipa!',
            '',
            'error'
        )
    </script>
@endif
@if (session('equipa.update.success'))
    <script>
        Swal.fire(
            'Equipa Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('equipa.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Equipa!',
            '',
            'error'
        )
    </script>
@endif
@endsection
