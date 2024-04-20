	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="text-center col-lg-12 col-sm-12">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="{{route('sgcf.site.index')}}" style="font-size: 20px; margin-top:15px;color:white;font-weight: bolder">
                                SGCF
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item">
                                    <a href="{{route('sgcf.site.index')}}">Página Inicial</a>
								</li>
								<li><a href="{{route('sgcf.site.campeonatos')}}">Campeonatos</a>

								</li>

                                @if (Auth::check())
                                        <li><a href="{{route('dashboard')}}">Paínel Administrativo</a>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <a href="{{ route('logout') }}"   onclick="event.preventDefault();
                                                this.closest('form').submit();">Terminar Sessão</a>
                                          </form>
                                        </li>
								@else
                                    <li><a href="{{route('login')}}">Login</a></li>
                                @endif

								<li>
									<div class="header-icons">

										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
                            <form action="{{route('sgcf.site.search')}}" method="POST">
                                @csrf
                                <h3>Pesquisar Por:</h3>
                                <div class="container" >
                                    <div class="row col-md-6" style="margin: 0 auto"  >
                                        <div class="col-md-12">
                                        <div class="mb-3 form-group">
                                            <label for="usuario" class="text-white">Nome*</label>
                                            <input type="text" name="nome" class="form-control" style="width:500px; height:40px; font-size:16px;">
                                        </div>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3 form-group">
                                                <label for="descricao" class="text-white">Tipo de Pesquisa*</label>
                                                <select name="tipo"  class="form-control select2" required>
                                                    <option value="">Selecione um hospital</option>
                                                    <option value="0">Equipa</option>
                                                    <option value="1">Jogador</option>

                                                </select>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <button type="submit">Pesquisar <i class="fas fa-search"></i></button>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search area -->

