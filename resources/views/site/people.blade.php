<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('Formularios/Carros/cars.css')}}">
    <link rel="stylesheet" href="{{asset('Formularios/Pessoas/people.css')}}">

    <title>Junta-te a nós</title>
</head>

<body>

    <div class="base">
<!-- login -->

<div class="baseform">
    <div class="inandup">
        <form action="{{route('login')}}" method="post" id="form" class="loginform">
            @csrf
             <h2 class="titulo">Entre</h2>
             <div class="campodeentrada">
              <i class="fas fa-user"></i>
              <input type="number" id="processo" name="processo" placeholder="ID">
             </div>
             <input type="hidden" name="email" id="inputEmail" >
             <div class="campodeentrada">
                 <i class="fas fa-lock"></i>
                 <input type="password" name="password" placeholder="Palavra-passe">
                </div>
                <input type="" class="btn" value="Entrar" id="submitbtn" onclick="getEmail()">
         </form>
<!-- login done -->


<!-- cadastro -->
<form action="" class="cadastroform">

    <h2 class="titulo">Cadastre-se</h2>
    <div class="campodentrada">
        <i class="new"></i>
        <input type="text" placeholder="Nome completo">
    </div>

    <div class="campodentrada">
        <i class="new"></i>
        <input type="text" placeholder="Gênero">
    </div>

    <h2 class="titulo"> Insira os seus contactos </h2>
    <div class="campodentrada">
        <i class="new"></i>
        <input type="tel" placeholder="Contacto 1">
    </div>

    <div class="campodentrada">
        <i class="new"></i>
        <input type="tel" placeholder="Contacto 2">
    </div>

    <div class="campodentrada">
        <i class="new"></i>
        <input type="tel" placeholder="Contacto 3">
    </div>
    <input type="" value="Cadastrar" class="submitbtn">

    </form>
    <!-- cadastro done -->
    </div>
</div>

<!-- design -->
<div class="basepanels">
<div class="panel left-panel">
    <div class="conteudo">
<!--        <h3> Novo por aqui? </h3>
        <button class="btnuncolor" id="cadbtn">Cadastre-se</button>-->
    </div>
    <img src="{{asset('Formularios/Carros/img/login.svg')}}" class="imagem">
</div>

<!--<div class="panel right-panel">
    <div class="conteudo">
        <h3> Já está conectado? </h3>

        <button class="btnuncolor" id="loginbtn">Entre Agora</button>
    </div>
    <img src="{{asset('Formularios/Carros/img/cadastro.svg')}}" class="imagem">
</div>-->
    </div>
</div>
<!-- end -->

<script src="{{asset('Formularios/Pessoas/people.js')}}"></script>
<script src="{{asset('painel/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#submitbtn').on('click', function() {
            let processo = $('#processo').val();
            $.ajax({
                type: "GET",
                url: "{{route('admin.user.getEmail')}}",
                data: {
                    processo: processo
                },
                success: function(result) {
                    $('#inputEmail').val(result); // Preenchendo o campo de email com o resultado retornado
                    $('#form').submit(); // Submetendo o formulário após o preenchimento do campo de email
                },
                error: function(error) {
                    console.error(error);
                    // Trate erros aqui, se necessário
                }
            });
        });
    });
</script>
</body>
</html>
