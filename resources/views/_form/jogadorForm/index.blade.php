<div class="row">
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="nome">Nome Completo*</label>
            <input type="text"   id="nome" name="nome" class="form-control" value="{{isset($jogador) ?$jogador->nome: old('nome') }}" required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="dt_nascimento">Data de Nascimento*</label>
            <input type="date"  value="{{isset($jogador) ?$jogador->data_nascimento: old('data_nascimento') }}"  name="data_nascimento" class="form-control"  required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="numero">Numero de Camisa*</label>
            <input type="number" value="{{isset($jogador) ?$jogador->numero: old('numero') }}"    name="numero" class="form-control"  required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="posicao">Posição*</label>
            <input type="text"    name="posicao" class="form-control" value="{{isset($jogador) ?$jogador->posicao: old('posicao') }}" required>
        </div>
    </div> <!-- /.col -->


    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="id_equipa">Equipa*</label>
            <select name="id_equipa" id="" class="form-control select2">
                @foreach($equipas as $equipa)
                    <option value="{{$equipa->id}}" {{isset($jogador)?$jogador->id_equipa==$equipa->id?'selected':'':''}}>
                        {{$equipa->nome}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->
</div>
