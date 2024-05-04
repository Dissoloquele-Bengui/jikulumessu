@extends('layouts._includes.site.body')
@section('titulo',"Página Não Encontrada")

@section('conteudo')
    <!-- breadcrumb-section -->
		<div class="breadcrumb-section breadcrumb-bg">
			<div class="container">
				<div class="row">
					<div class="text-center col-lg-8 offset-lg-2">
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
						<div class="text-center col-lg-8 offset-lg-2">
							<div class="error-text">
								<i class="far fa-sad-cry"></i>
								<h1>Oops! Página Não Encontrada.</h1>
								<p>A página requisitada não foi encontrada.</p>
								<a href="/" class="boxed-btn">Voltar Aos Trilhos</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
