@extends('layouts._includes.admin.body')
@section('titulo','Cadastrar Densidade')

@section('conteudo')
    <div class="card shadow mb-4">
        <div class="card-header">
        <strong class="card-title">Cadastrar Densidade</strong>
        </div>
        
    </div>

@if (session('restaurante.create.success'))
    <script>
        Swal.fire(
            'Densidade Cadastrada com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('restaurante.create.error'))
    <script>
        Swal.fire(
            'Erro ao Cadastrar Densidade!',
            '',
            'error'
        )
    </script>
@endif

@endsection
