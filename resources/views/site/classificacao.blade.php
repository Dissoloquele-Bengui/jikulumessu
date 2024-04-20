@extends("layouts._includes.site.body")
@section("titulo","Tabela de Classificação")

@section("conteudo")
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Explore a classificação do seu campeonato favorito</p>
						<h1>Classificação</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->


  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row">
          <!-- Small table -->
          <div class="my-4 col-md-12">
              <h2 class="">
                  Tabela de Classificação do campeonato {{$campeonato->nome}}
              </h2>
            <div class="p-3 shadow card">
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1">
                  <thead class="thead-dark">
                    <tr>
                      <th>POS.</th>
                      <th>Logo</th>
                      <th>Equipa</th>
                      <th>Pontos</th>
                      <th>Vitórias</th>
                      <th>Derrotas</th>
                      <th>Empates</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($equipas as $equipa)
                          <tr>
                              <td>{{($loop->index+1)}}</td>
                              <td><img src="{{asset($equipa->logo)}}" alt="" style="width:100px;height:70px;border-radius:100%"></td>                            
                              <td>{{$equipa->equipa}}</td>
                              <td>{{{($equipa->vitorias*3 + $equipa->empates)}}}</td>
                              <td>{{{$equipa->vitorias}}}</td>
                              <td>{{{$equipa->derrotas}}}</td>
                              <td>{{{$equipa->empates}}}</td>                            
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
