@extends('layouts._includes.admin.body')
@section('titulo',"Página Não Encontrada")
{{$total=true}}
@section('conteudo')
    <div class="wrapper vh-100">
        <div class="align-items-center h-100 d-flex w-50 mx-auto">
        <div class="mx-auto text-center">
            <h1 class="display-1 m-0 font-weight-bolder text-muted" style="font-size:80px;">404</h1>
            <h1 class="mb-1 text-muted font-weight-bold">OOPS!</h1>
            <h6 class="mb-3 text-muted">Não COnseguimos Encontrar a Página.</h6>
            <a href="{{route('dashboard')}}" class="btn btn-lg btn-primary px-5">Voltar para a Dashboard</a>
        </div>
        </div>
    </div>
@endsection