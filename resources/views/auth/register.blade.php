
{{$login = true}}
@extends('layouts._includes.admin.body')
@section('titulo',"Login")
@section('conteudo')

<div class="wrapper vh-100">
    <div class="row align-items-center h-100" >
      <form class="col-lg-6 col-md-8 col-10 mx-auto text-center" method="POST" action="{{ route('register') }}">

        @csrf
        <h1 class="h2 mb-3">Registar</h1>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="inputEmail" class="sr-only">Nome </label>
                    <input name="name" type="text" id="name" class="form-control form-control-lg" placeholder="Nome Completo" required autofocus="">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail" class="sr-only">Email </label>
                  <input name="email" type="email" id="inputEmail" class="form-control form-control-lg" placeholder="Endereço de Email " required autofocus="">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputNif" class="sr-only">NIF* </label>
                    <input name="nif" type="text" id="inputNif" class="form-control form-control-lg" placeholder="NIF" required autofocus="">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputContacto" class="sr-only">Contacto </label>
                  <input name="contacto" type="number" id="inputContacto" class="form-control form-control-lg" placeholder="Contacto " required autofocus="">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputNif" class="sr-only">Data de Nascimento* </label>
                    <input name="data_nasc" type="date" id="inputNif" class="form-control form-control-lg" placeholder="Data de Nascimento" required autofocus="">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputMorada" class="sr-only">Morada* </label>
                    <input name="morada" type="text" id="inputMorada" class="form-control form-control-lg" placeholder="Endereço" required autofocus="">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputPassword" class="sr-only">Password</label>
                  <input type="password" name="password" required autocomplete="current-password" class="form-control form-control-lg" placeholder="Password" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="password_confirmation" required autocomplete="current-password" class="form-control form-control-lg" placeholder="Confirmar a Password" required>
                </div>
            </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me" name="remember"> Lembrar a senha </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Registrar Se</button>
        <p class="mt-5 mb-3 text-muted">© 2024</p>
      </form>
    </div>
@endsection

