@extends('layouts._includes.admin.body')
@section('titulo','Listar Logs')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="text"> Lista de
                Actividades
            </h2>
          <div class="p-3 shadow card">
            <div class="card-body">
              <div class="mb-3 toolbar row">


              </div>

              </div>
              <!-- table -->
              <table class="table datatables" id="dataTable-1">
                <thead class="thead-dark">
                  <tr>
                    <th>ID do Usuário</th>
                    <th>Nome do Usuário</th>
                    <th>Endereço IP</th>
                    <th>Descrição</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{$log->it_id_user}}</td>
                            <td>{{$log->nome}}</td>
                            <td>{{{$log->vc_endereco}}}</td>
                            <td>{{$log->vc_descricao}}</td>

                        </tr>
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

@endsection
