<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Jikulumesu </title>
    <link rel="stylesheet" href="{{asset('home/home pictures/home.css')}}">
    <script defer src="{{asset('home/home pictures/home.js')}}"></script>
<!-- fonte -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body>
    <div class="corpo">
<!-- cabeçalho-->
<header class="header">
    <nav class="menu" style="justify-content: space-around !important">
        <a href="/" class="Logo" >JIKULUMESU</a>
        <button class="group"></button>
        <ul class="listamenu">
            @if(Auth::check() && in_array(Auth::user()->nivel,["Funcionário",'Administrador']))
                <li><a href="/dashboard">Painel</a></li>
                <li>          <form action="{{ route('logout') }}" method="POST">
                @csrf
                <a href="{{ route('logout') }}"   onclick="event.preventDefault();
                this.closest('form').submit();">Terminar Sessão</a>
          </form></li>

            @elseif(Auth::check())
                <li><a href="{{route('sgv.site.login')}}">Consultar Localização</a></li>
                <li>          <form action="{{ route('logout') }}" method="POST">
                @csrf
                <a href="{{ route('logout') }}"   onclick="event.preventDefault();
                this.closest('form').submit();">Terminar Sessão</a>
          </form></li>
            @else
                <li><a href="{{route('login')}}">Entrar</a></li>
                <li><a href="{{route('sgv.site.localizar')}}">Localizar</a></li>

            @endif
        </ul>
    </nav>

</header>

<!-- Conteúdo Principal (corpo da pag1)-->

<!-- slide show+Slogan-->
<div class="slideshow">

    <div class="slidebutton">
        <!--radio button-->
<input type="radio" name="radiobtn" id="radio1">
<input type="radio" name="radiobtn" id="radio2">
<input type="radio" name="radiobtn" id="radio3">
<input type="radio" name="radiobtn" id="radio4">
<!--radiobutton done and start images-->

<div class="slide first">
<img src="{{asset('home/home pictures/teste.jpeg')}}" alt="imagem 1">
</div>

<div class="slide">
<img src="{{asset('home/home pictures/teste1.jpeg')}}" alt="imagem 2">
</div>

<div class="slide">
<img src="{{asset('home/home pictures/teste2.jpeg')}}" alt="imagem 3">
</div>

<div class="slide">
<img src="{{asset('home/home pictures/teste3.jpeg')}}" alt="imagem 4">
</div>
        <!--images done-->

        <!-- navegação nos slides-->
        <div class="navegauto">
            <div class="btnnaveg1"></div>
            <div class="btnnaveg2"></div>
            <div class="btnnaveg3"></div>
            <div class="btnnaveg4"></div>
        </div>
    </div>
    <div class="manualnaveg">
        <label for="radio1" class="btnmanual"></label>
        <label for="radio2" class="btnmanual"></label>
        <label for="radio3" class="btnmanual"></label>
        <label for="radio4" class="btnmanual"></label>
    </div>

</div>
<!-- Slide show done-->

<!-- apresentação do protótipo -->
<div class="apresentação">

<div class="imagem">
<img src="{{asset('home/home pictures/alternativa.jpeg')}}" alt="ilustração">
</div>

<div class="imagem">
<h1>texto</h1>
<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vitae, est voluptates nihil repudiandae autem quas pariatur hic laudantium vero suscipit non quibusdam, ex velit aliquam vel consequatur repellat esse officiis.</p>
</div>

</div>

<div class="presentation">


    <div class="text">
    <h1>texto</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident ipsa molestiae itaque autem! Earum voluptatem id aperiam nulla rem, ratione ipsum quo ipsam harum placeat ullam quas nostrum cumque. Fuga?</p>
    </div>

    <div class="text">
    <img src="{{asset('home/home pictures/alternativa.jpeg')}}" alt="ilustração">
    </div>

    </div>
<!-- Presentation -->
  <main class="descrição">

<div class="conteudo">
    <h3>Desenvolvedoras</h3>
</div>

<div class="conteudo">
    <h3>tracking cars</h3>
</div>

<div class="conteudo">
<h3> tracking people</h3>
</div>

  </main>



<!-- Rodapé -->
<footer class="footer">
   <ul class="footerlist">
    <li> <a href="#">ITEL</a></li>
    <li> <a href="#">CISP</a></li>
    <li> <a href="#">POLÍCIA NACIONAL</a></li>
   </ul>
</footer>


</div>
</body>
</html>
