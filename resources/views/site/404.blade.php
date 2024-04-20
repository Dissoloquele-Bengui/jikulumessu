@extends('layouts._includes.site.body')
@section('titulo',"Página Não Encontrada")

@section('conteudo')
    <!-- breadcrumb-section -->
		<div class="breadcrumb-section breadcrumb-bg">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 text-center">
						<div class="breadcrumb-text">
							<h1>404 - Página Não Encontrada</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end breadcrumb section -->
		<!-- error section -->
		<div class="full-height-section error-section">
			<div class="full-height-tablecell">
				<div class="container">
					<div class="row">
						<div class="col-lg-8 offset-lg-2 text-center">
							<div class="error-text">
								<i class="far fa-sad-cry"></i>
								<h1>Oops! Página Não Encontrada.</h1>
								<p>A página requisitada não foi encontrada.</p>
								<a href="{{route('sgcf.site.index')}}" class="boxed-btn">Voltar Aos Trilhos</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection