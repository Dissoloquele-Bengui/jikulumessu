@extends('layouts._includes.admin.body')
@section('titulo','Actualizar Densidade')

@section('conteudo')
    <div class="card shadow mb-4">
        <div class="card-header">
        <strong class="card-title">Actualizar Densidade</strong>
        </div>

    </div>

@if (session('restaurante.update.success'))
    <script>
        Swal.fire(
            'Densidade Actualizada com sucesso!',
            '',
            'success'
        )
    </script>
@endif
@if (session('restaurante.update.error'))
    <script>
        Swal.fire(
            'Erro ao Actualizar Densidade!',
            '',
            'error'
        )
    </script>
@endif

@endsection
