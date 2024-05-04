<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="{{asset('Formularios/form.css')}}">
<!-- fonte -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  </head>

<body class="base">

  <div class="teste">
  <div class="calltoaction">
    <img src="Formulários/Imagem1.png" alt="">
    <h2 class="tc">JIKULUMESU</h2>
    <p class="tc">Conecte-se e proteja</p>
    </p>
  </div>

   <div class="entradas">
    <div class="pessoas">
        <p class="pe"> Localize os seus entequeridos </p>
        <button class="login">
            <a href="{{route('sgv.site.people')}}">Localize</a>
        </button>
    </div>
  <div class="carros">
    <p class="pe">Salve a sua viatura</p>
    <button class="login">
        <a href="{{route('sgv.site.cars')}}">Localize</a>
    </button>
  </div>
</div>
</div>
</body>
</html>
