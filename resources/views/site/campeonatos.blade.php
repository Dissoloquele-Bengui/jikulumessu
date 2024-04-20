@extends("layouts._includes.site.body")
@section("titulo","Campeonatos")

@section("conteudo")
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Descubra uma ampla variedade de campeonatos de futebol</p>
						<h1>Campeonatos</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->


	<div class="container">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row">
        <!-- Small table -->
        <div class="my-4 col-md-12">
            <h2 class="">
              Lista dos Campeonatos de Futebol
            </h2>
          <div class="p-3 shadow card">
            <div class="card-body">
             
              <!-- table -->
              <table class="table datatables" id="dataTable-1">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>TIPO</th>
                    <th>OPÇÕES</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($campeonatos as $campeonato)
                        <tr>
                            <td>{{$campeonato->id}}</td>
                            <td>{{{$campeonato->nome}}}</td>
                            <td>{{{$campeonato->tipo}}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" ariaexpanded="false">
                                    <span class="sr-only text-muted">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="{{route('sgcf.site.equipas',['id'=>$campeonato->id])}}">{{ __('Equipas') }}</a>
                                        <a class="dropdown-item" href="{{route('sgcf.site.classificacao',['id'=>$campeonato->id])}}">{{ __('Classificação') }}</a>
                                        <a class="dropdown-item" href="{{route('sgcf.site.calendario',['id'=>$campeonato->id])}}">{{ __('Calendário') }}</a>
                                        <a class="dropdown-item" href="{{route('sgcf.site.resultado',['id'=>$campeonato->id])}}">{{ __('Resultados') }}</a>
                                        <a class="dropdown-item" href="{{route('sgcf.site.gols',['id'=>$campeonato->id])}}">{{ __('Melhores Marcadores') }}</a>
                                        <a class="dropdown-item" href="{{route('sgcf.site.assistencias',['id'=>$campeonato->id])}}">{{ __('Melhores Assistentes') }}</a>
                                    </div>
                                </div>
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
