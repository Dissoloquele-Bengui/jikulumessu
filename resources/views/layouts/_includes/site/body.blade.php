@include("layouts._includes.site.head")
<body>
    @include("layouts._includes.site.menu")

    @yield("conteudo")
	
    @include("layouts._includes.site.footer")

	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2024 Dissoloquele Bengui,  Todos Direitos Reservados.
					</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->

	<!-- jquery -->
    <script src="{{asset('site/assets/js/jquery-1.11.3.min.js')}}"></script>
	<!-- bootstrap -->
	<script src="{{asset('painel/js/popper.min.js')}}"></script>
	<script src="{{asset('site/assets/bootstrap/js/bootstrap.min.js')}}"></script>
	<!-- count down -->
	<script src="{{asset('site/assets/js/jquery.countdown.js')}}"></script>
	<!-- isotope -->
	<script src="{{asset('site/assets/js/jquery.isotope-3.0.6.min.js')}}"></script>
	<!-- waypoints -->
	<script src="{{asset('site/assets/js/waypoints.js')}}"></script>
	<!-- owl carousel -->
	<script src="{{asset('site/assets/js/owl.carousel.min.js')}}"></script>
	<!-- magnific popup -->
	<script src="{{asset('site/assets/js/jquery.magnific-popup.min.js')}}"></script>
	<!-- mean menu -->
	<script src="{{asset('site/assets/js/jquery.meanmenu.min.js')}}"></script>
	<!-- sticker js -->
	<script src="{{asset('site/assets/js/sticker.js')}}"></script>
	<!-- main js -->
	<script src="{{asset('site/assets/js/main.js')}}"></script>

	<script>
		function formatarDataLaravelParaPortugues(dataLaravel) {
			// Converte a string de data do Laravel para um objeto Date
			const data = new Date(dataLaravel);

			// Obtém o dia, mês e ano
			const dia = data.getDate();
			const mes = data.getMonth() + 1; // Lembrando que os meses em JavaScript começam do zero
			const ano = data.getFullYear();

			// Formata a data no padrão português
			const dataFormatada = `${dia}/${mes}/${ano}`;

			return dataFormatada;
		}

	$('select.form-control').select2();
	function getNotificacao(id_estado){

		$.ajax({
		url: "{{ route('admin.notificacao.vizualize') }}",
		type: "GET",
		data: {
			id: id_estado
		},
		success: function (result) {
			console.log(result)
			$('.modal-right-notificacoes-ap').modal('hide');
			$('#notificacao-title').html('');
			$('#notificacao-assunto').html('');
			$('#notificacao-descricao').html('');
			$('#notificacao-data').html('');
			$('#notificacao-title').append(result.notificacoes['categoria']);
			$('#notificacao-assunto').append("Assunto: "+result.notificacoes['assunto']);

			$('#form_voto').hide();
			$('#notificacao-descricao').append(result.notificacoes['descricao']);
			$('#notificacao-data').append("Aos "+formatarDataLaravelParaPortugues(result.notificacoes['created_at']));
			$('#ModalNotificacao').modal('show');
			let total = $('#count-view').text();
			//alert(total);
			$('#count-view').html();
			if(total-1 ==0){
				$('#count-view').hide();
			}else{
				$('#count-view').append((total-1))
			}

		},
		error: function (xhr, status, error) {
			console.error("Erro na requisição Ajax: " + status + " - " + error);
		}
		});
	}

</script>
</body>
</html>
