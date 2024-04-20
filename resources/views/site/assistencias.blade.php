@extends("layouts._includes.site.body")
@section("titulo","Tabela dos Melhores Assistentes")

@section("conteudo")
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Explore os melhores assistentes do seu campeonato favorito</p>
						<h1>Melhores Assistentes</h1>
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
                  Tabela dos Melhores Assistentes
              </h2>
            <div class="p-3 shadow card">
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1">
                  <thead class="thead-dark">
                    <tr>
                      <th>POS.</th>
                      <th>NOME</th>
                      <th>EQUIPA</th>
                      <th>GOLS ASSISTIDOS</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($jogadores as $jogador)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{{$jogador->jogador}}}</td>
                              <td><img src="{{asset($jogador->logo)}}" width="100px" height="70px" style="border-radius:100%" alt=""> {{$jogador->equipa}}</td>
                              <td>
                                  {{$jogador->numeros}}
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
