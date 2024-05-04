@extends('layouts._includes.admin.body')
@section('titulo', 'Listar Clientes')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista dos  Clientes
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
                    <th>NÍVEL</th>
                    <th>E-MAIL</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{{$user->name}}}</td>
                            <td>{{{$user->nivel}}}</td>
                            <td>{{{$user->email}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalEdit{{$user->id}}">{{ __('Editar') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.user.destroy',['id'=>$user->id])}}">{{ __('Remover') }}</a>
                                        <a class="dropdown-item" href="{{route('admin.user.purge',['id'=>$user->id])}}">{{ __('Purgar') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- ModalUpdate --}}
                        <div class="text-left modal fade" id="ModalEdit{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Editar Cliente') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.user.update', ['id' => $user->id]) }}
                                            " method="post">
                                            @csrf
                                            <div class="card-body">
                                                @include('_form.userForm.index')
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
                <h4 class="modal-title">{{ __('Adicionar Cliente') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.user.store')}}" method="post">
                    @csrf
                    <div class="card-body">
                        {{ $user = null }}
                        @include('_form.userForm.index')
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function addFieldUser(){
       let option =  $('#nivel').val();
       $('#fieldUser').html('');
       // alert(option);
       if(option == "Funcionário"){
            $('#fieldUser').append(`
                <div class="col-md-12">
                    <div class="mb-3 form-group">
                        <label for="id_empresa">empresa*</label>
                        <select name="id_empresa" id="" class="form-control select2">
                            @foreach($empresas as $empresa)
                                <option value="{{$empresa->id}}" >
                                    {{$empresa->nome}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> <!-- /.col -->
            `);
       }else if(option === "Proprietário"){
            $('#fieldUser').append(`

                    <div class="col-md-6">
                        <div class="mb-3 form-group">
                            <label for="numero">Contacto*</label>
                            <input type="number"    name="numero[0]" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 form-group">
                            <label for="id_empresa">empresa*</label>
                            <select name="id_empresa" id="" class="form-control select2">
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}" >
                                        {{$empresa->nome}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- /.col -->
                    <div class="col-md-4">
                        <div class="mb-3 form-group">
                            <label for="marca">Marca*</label>
                            <input type="text"    name="marca"  class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 form-group">
                            <label for="modelo">Modelo*</label>
                            <input type="text"    name="modelo"  class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 form-group">
                            <label for="numero">Matricula*</label>
                            <input type="text"    name="matricula"  class="form-control"  required>
                        </div>
                    </div>
            `);
       }else if(option === "Cliente Singular"){
            $('#fieldUser').append(`

                <div class="col-md-4">
                    <div class="mb-3 form-group">
                        <label for="numero">Contacto*</label>
                        <input type="number"    name="numero[0]" class="form-control"  required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3 form-group">
                        <label for="numero">Contacto2*</label>
                        <input type="number"    name="numero[1]" class="form-control"  >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3 form-group">
                        <label for="numero">Contacto3*</label>
                        <input type="number"    name="numero[2]" class="form-control"  >
                    </div>
                </div>
            `);

       }else{
        $('#fieldUser').html('');
       }
    }
    function addFieldUserUpdate(id){
       let option =  $('#nivel'+id).val();

       if(option === "Funcionário"){
            $('#fieldUser'+id).append(`
                <div class="col-md-12">
                    <div class="mb-3 form-group">
                        <label for="id_empresa">empresa*</label>
                        <select name="id_empresa" id="" class="form-control select2">
                            @foreach($empresas as $empresa)
                                <option value="{{$empresa->id}}" >
                                    {{$empresa->nome}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> <!-- /.col -->
            `);
       }else if(option === "Proprietário"){
            $('#fieldUser'+id).append(`

                    <div class="col-md-4">
                        <div class="mb-3 form-group">
                            <label for="numero">Contacto*</label>
                            <input type="number"    name="numero[0]" class="form-control"  required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3 form-group">
                            <label for="id_empresa">empresa*</label>
                            <select name="id_empresa" id="" class="form-control select2">
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}" >
                                        {{$empresa->nome}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div> <!-- /.col -->
            `);
       }else if(option === "Cliente Singular"){
            $('#fieldUser'+id).append(`

                <div class="col-md-4">
                    <div class="mb-3 form-group">
                        <label for="numero">Contacto*</label>
                        <input type="number"    name="numero[0]" class="form-control"  required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3 form-group">
                        <label for="numero">Contacto2*</label>
                        <input type="number"    name="numero[1]" class="form-control"  required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3 form-group">
                        <label for="numero">Contacto3*</label>
                        <input type="number"    name="numero[2]" class="form-control"  required>
                    </div>
                </div>
            `);

       }else{
        $('#fieldUser'+id).html('');
       }
    }
</script>
{{-- ModalCreate --}}
@if (session('user.destroy.success'))
    <script>
        Swal.fire(
            'Cliente Eliminado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('user.destroy.error'))
    <script>
        Swal.fire(
            'Erro ao Eliminar Cliente!',
            '',
            'error'
        )
    </script>
@endif
@if (session('user.purge.success'))
    <script>
        Swal.fire(
            'Cliente Purgado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('user.purge.error'))
    <script>
        Swal.fire(
            'Erro ao Purgar Cliente!',
            '',
            'error'
        )
    </script>
@endif
@if (session('user.create.success'))
    <script>
        Swal.fire(
            'Cliente Cadastrado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('user.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Cliente!',
            '',
            'error'
        )
    </script>
@endif
@if (session('user.update.success'))
    <script>
        Swal.fire(
            'Cliente Actualizado com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('user.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Cliente!',
            '',
            'error'
        )
    </script>
@endif
@endsection