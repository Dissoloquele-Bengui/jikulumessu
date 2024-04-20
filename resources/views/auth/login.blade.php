

@extends('layouts._includes.admin.body')
@section('titulo',"Login")
@section('conteudo')
{{$login = true}}
<div class="wrapper vh-100">
    <div class="row align-items-center h-100" >
      <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" method="POST" action="{{ route('login') }}">
        
        @csrf
        <h1 class="h2 mb-3">Iniciar Sessão</h1>
        <div class="form-group">
          <label for="inputEmail" class="sr-only">Email </label>
          <input name="email" type="email" id="inputEmail" class="form-control form-control-lg" placeholder="Email address" required="" autofocus="">
        </div>
        <div class="form-group">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" name="password" required autocomplete="current-password" class="form-control form-control-lg" placeholder="Password" required="">
        </div>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me" name="remember"> Lembrar a senha </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Let me in</button>
        <p class="mt-5 mb-3 text-muted">© 2024</p>
      </form>
    </div>
@endsection

