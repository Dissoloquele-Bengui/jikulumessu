@extends('layouts._includes.admin.body')
@section('titulo', 'Calendário dos Jogos')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Calendário dos Jogos do Campeonato {{$campeonato->nome}}
            </h2>
          <div class="p-3 shadow card">
            <div class="card-body">
              <!-- table -->
              <table class="table datatables" id="dataTable-1">
                <thead class="thead-dark">
                  <tr>
                    <th>EQUIPE 1</th>
                    <th>EQUIPE 2</th>
                    <th>DIA</th>
                    <th>HORÁRIO</th>
                    <th>RODADA</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($jogos as $jogo)
                        @php
                            $equipa_1 = $equipas->where('id',$jogo->id_campeonato_equipa_1)->first()->equipa;
                            $equipa_2 = $equipas->where('id',$jogo->id_campeonato_equipa_2)->first()->equipa;
                        @endphp
                        <tr>
                            <td>{{$equipa_1}}</td>
                            <td>{{$equipa_2}}</td>
                            <td>{{$jogo->dia}}</td>
                            <td>{{$jogo->hora_inicio." ".$jogo->hora_termino}}</td>
                            <td>{{{$jogo->epoca}}}</td>
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
