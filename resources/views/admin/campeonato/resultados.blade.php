@extends('layouts._includes.admin.body')
@section('titulo', 'Resultado dos Jogos')

@section('conteudo')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Resultado dos Jogos do Campeonato {{$campeonato->nome}}
            </h2>
          <div class="p-3 shadow card">
            <div class="card-body">
              <!-- table -->
              <table class="table datatables" id="dataTable-1">
                <thead class="thead-dark">
                  <tr>
                    <th>EQUIPE 1</th>
                    <th>EQUIPE 2</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($jogos as $jogo)
                        @php
                            $equipa_1 = $equipas->where('id',$jogo->id_campeonato_equipa_1)->first();
                            $equipa_2 = $equipas->where('id',$jogo->id_campeonato_equipa_2)->first();
                        @endphp
                        <tr>
                            <td>
                                <img src="{{asset($equipa1->logo)}}" width="100px" height="70px" style="border-radius:100%" alt=""> 
                                {{$equipa_1->equipa}} 
                                <span class="text-right">{{$jogo->gols_1}}</span>
                            </td>

                            <td>
                                <span class="text-right">{{$jogo->gols_2}}</span> 
                                {{$equipa_2->equipa}}  
                                <img src="{{asset($equipa_2->logo)}}" width="100px" height="70px" style="border-radius:100%" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="text-center fs-3">Dia {{$jogo->dia}}</p>
                                <p class="text-center fs-3">Horário {{$jogo->hora_inicio." ".$jogo->hora_termino}}</p>
                                <p class="text-center fs-3">Jornada {{{$jogo->epoca}}}</p>
                            </td>
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
