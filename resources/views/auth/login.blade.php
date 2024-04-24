

@extends('layouts._includes.admin.body')
@section('titulo',"Login")
@section('conteudo')
@php
    $login = true
@endphp
<div class="wrapper vh-100">
    <div class="row align-items-center h-100" >
      <form class="mx-auto text-center col-lg-3 col-md-4 col-10" method="POST" action="{{ route('login') }}">

        @csrf
        <h1 class="mb-3 h2">Iniciar Sessão</h1>
        <div class="form-group">
          <label for="inputEmail" class="sr-only">Email </label>
          <input name="email" type="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address" required="" autofocus="">
        </div>
        <div class="form-group">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" name="password" required autocomplete="current-password" class="form-control form-control-lg" placeholder="Password" required="">
        </div>
        <div class="mb-3 checkbox">
          <label>
            <input type="checkbox" value="remember-me" name="remember"> Lembrar a senha </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sessão</button>
        <a class="btn btn-lg btn-link btn-block" href="/" >Voltar a página inicial</a>
        <p class="mt-5 mb-3 text-muted">© 2024</p>
      </form>
    </div>
@endsection

