@extends("layouts._includes.site.body")
@section("titulo","Perfil")

@section("conteudo")
    <!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="text-center col-lg-8 offset-lg-2">
					<div class="breadcrumb-text">
						<h1>Edite o seu perfil!</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- contact form -->
	<div class="contact-from-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div style="margin: 10px auto!important" class="mb-5 col-lg-10 mb-lg-0">
					<div class="form-title">
						<h2>Meu Perfil</h2>

				 	<div id="form_status">
                        <div class="row">
                            <div class="p-2 pl-3 col-md-4">
                                @auth
                                    @if (isset(Auth::user()->profile_photo_path))
                                        <img src="{{asset(Auth::user()->profile_photo_path)}}" alt="Foto de perfil">
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
					<div class="contact-form">
						<form method="POST" action="{{route('sgcf.site.editar')}}" enctype="multipart/form-data">
							@csrf
                            <p>
								<input type="text" placeholder="Nome" name="name" id="name" value="{{Auth::user()->name}}">
								<input type="email" placeholder="Email" name="email" id="email" value="{{Auth::user()->email}}">
							</p>
							<p>
								<input type="tel" placeholder="Phone" name="phone" id="phone" value="{{Auth::user()->phone}}">
								<input type="text" placeholder="Morada" name="morada" id="subject" value="{{Auth::user()->morada}}">
							</p>
                            <p>
								<input type="tel" placeholder="Password" name="password" id="password">
								<input type="text" placeholder="Confimar Password" name="conf_pass" id="conf-password">
							</p>
                            <p>
								<input class="form-control" type="file" style="width:98.5%;height:45px" placeholder="Foto de Perfil" name="imagem" id="imagem" {{!isset(Auth::user()->profile_photo_path)?'required':''}}>
                                
							</p>
							<p><input type="submit" value="Editar"></p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end contact form -->




@endsection
