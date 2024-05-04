<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('Formularios/Carros/cars.css')}}">
   <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    >
   </script>
    <title>Junta-te a nós</title>
    <script src="{{asset('painel/js/jquery.min.js')}}"></script>
</head>

<body>
 <div class="base">
    <div class="baseforms">

<div class="logincad">
    <!-- login -->

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
    <!-- login done-->

    <!-- cadastro -->
    <form action="" class="cadform">
        <h2 class="titulo">Cadastre-se</h2>
        <div class="campodeentrada">
         <i class="fas fa-user"></i>
         <input type="text" placeholder="Nome da Empresa">
        </div>

        <div class="campodeentrada">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="NIF">
           </div>

           <div class="campodeentrada">
            <i class="fas fa-envelope"></i>
            <input type="text" placeholder="E-mail">
           </div>

           <div class="campodeentrada">
            <i class="fas fa-phone"></i>
            <input type="tel" placeholder="Contacto">
           </div>

           <div class="campodeentrada">
            <i class="fas fa-car"></i>
            <input type="number" placeholder="Número de Veículos">
           </div>

           <div class="campodeentrada">
            <i class="fas fa-car"></i>
            <input type="text" placeholder="Matrícula">
           </div>


           <input type="submit" class="btn" value="Cadastrar">
    </form>
    <!-- cadastro done-->

</div>
    </div>

<!--Transitions-->
    <div class="paineis">
                   <!-- De login para cadastro -->
        <div class="painel painelesquerdo">
            <div class="conteudo">
    <!--            <h3>Novo aqui?</h3>
                <button class="uncolor" id="cadbtn">Cadastre-se</button>-->
            </div>
            <img src="{{asset('Formularios/Carros/img/carslogin.svg')}}" class="imagem" alt="">
        </div>


                           <!-- De cadastro para login -->
        <div class="painel paineldireito">
            <div class="conteudo">
                <h3>Já faz parte do team?</h3>
                <button class="uncolor" id="loginbtn">Entre</button>
            </div>
            <img src="img/carscad.svg" class="imagem" alt="">
        </div>
    </div>
 </div>
 <script src="{{asset('Formularios/Carros/cars.js')}}"></script>
 <script>
    $(document).ready(function() {

    });
    function getEmail() {
            let processo = $('#processo').val();
            $.ajax({
                type: "GET",
                url: "{{route('admin.user.getEmail')}}",
                data: {
                    processo: processo
                },
                success: function(result) {
                    alert(result);
                    $('#inputEmail').val(result); // Preenchendo o campo de email com o resultado retornado
                    $('#form').submit(); // Submetendo o formulário após o preenchimento do campo de email
                },
                error: function(error) {
                    console.error(error);
                    // Trate erros aqui, se necessário
                }
            });
        }
</script>
</body>
</html>
