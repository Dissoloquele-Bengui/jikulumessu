@extends("layouts._includes.site.body")
@section("titulo", "Página Inicial")
@section("conteudo")
    	<!-- hero area -->
	<div class="hero-area hero-bg" style="background-image: url({{asset('assets/banner2.webp')}})">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-2 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle">Gestão de Campeonatos</p>
							<h3 style="color:white">Gerencie seus campeonatos de futebol com facilidade.</h3>
							<div class="hero-btns">
								<a href="#"  class=" boxed-btn">Comece agora</a>
								<a href="{{route('sgcf.site.sobre')}}" class="bordered-btn">Sobre Nós</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->

	<!-- features list section -->
	<div class="list-section pt-80 pb-80">
		<div class="container">

			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-user-md"></i>
						</div>
						<div class="content">
							<h3>Gestão de Equipes</h3>
							<p>Gerencie suas equipes com eficiência!</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon">
							<i class="fas fa-phone-volume"></i>
						</div>
						<div class="content">
							<h3>Suporte 24/7</h3>
							<p>Obtenha suporte a qualquer hora</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon">
							<i class="fas fa-sync"></i>
						</div>
						<div class="content">
							<h3>Atualizações em Tempo Real</h3>
							<p>Receba atualizações instantâneas sobre seus campeonatos!</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<!-- end features list section -->

	<!-- product section -->
	<div class="product-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">
						<h3><span class="orange-text">Nossos</span> Serviços de Gestão</h3>
						<p>No nosso sistema de gestão de campeonatos de futebol, oferecemos uma plataforma completa para você administrar seus torneios de forma eficaz e organizada. Desde a gestão de equipes até a atualização em tempo real dos resultados, estamos aqui para simplificar sua vida como organizador.</p>
					</div>
				</div>
			</div>

			
            
		</div>
	</div>
	<!-- end product section -->



	<!-- advertisement section -->
	<div class="abt-section mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<div class="abt-bg" >
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="abt-text">
						<p class="top-sub">Desde 2024</p>
						<h2><span class="orange-text">Gestão de Campeonatos</span></h2>
						<p>Bem-vindo ao nosso sistema de gestão de campeonatos de futebol. Estamos aqui para simplificar sua vida como organizador, proporcionando ferramentas poderosas para gerenciar equipes, agendar jogos e manter seus torneios atualizados. Com nossa plataforma, você pode focar no que realmente importa: o jogo!</p>
						<a href="{{route('sgcf.site.sobre')}}" class="boxed-btn mt-4">Saiba Mais...</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end advertisement section -->
	<!-- end shop banner -->


@endsection
