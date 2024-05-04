<div class="row">
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="nome">Nome*</label>
            <input type="text"   name="nome" class="form-control" value="{{isset($carro) ?$carro->nome: old('nome') }}" required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="usuario_id">Proprietários*</label>
            <select name="usuario_id" id="" class="form-control select2">
                @foreach($usuarios as $usuario)
                    <option value="{{$usuario->id}}" {{isset($carro)?$carro->id_user==$usuario->id?'selected':'':''}}>
                        {{$usuario->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="marca">Marca*</label>
            <input type="text"    name="marca"  class="form-control"  required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="modelo">Modelo*</label>
            <input type="text"    name="modelo"  class="form-control"  required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="numero">Matricula*</label>
            <input type="text"    name="matricula"  class="form-control"  required>
        </div>
    </div>

</div>
