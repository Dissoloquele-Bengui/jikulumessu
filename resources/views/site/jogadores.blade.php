@extends("layouts._includes.site.body")
@section("titulo","Lista dos Jogadores")

@section("conteudo")
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Descubra os jogadores participantes do seu campeonato favorito</p>
						<h1>Lista dos Jogadores</h1>
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
              Lista dos Jogadores
            </h2>
          <div class="p-3 shadow card">
            <div class="card-body">
              <!-- table -->
              <table class="table datatables" id="dataTable-1">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>DATA DE NASCIMENTO</th>
                    <th>POSIÇÃO</th>
                    <th>EQUIPA</th>
                    <th>NÚMERO DE CAMISA</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($jogadores as $jogador)
                        <tr>
                            <td>{{$jogador->id}}</td>
                            <td>{{{$jogador->nome}}}</td>
                            <td>{{{$jogador->data_nascimento}}}</td>
                            <td>{{{$jogador->posicao}}}</td>
                            <td>{{{$jogador->equipa}}}</td>
                            <td>{{{$jogador->numero}}}</td>
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
