<div class="row">
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="id_carro">Carro*</label>
            <select name="id_carro" id="" class="form-control select2">
                @foreach($carros as $carro)
                    <option value="{{$carro->id}}" {{isset($carro_equipa)?$carro_equipa->id_carro==$carro->id?'selected':'':''}}>
                        {{$carro->nome}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="id_equipa">Equipa*</label>
            <select name="id_equipa" id="" class="form-control select2">
                @foreach($equipas as $equipa)
                    <option value="{{$equipa->id}}" {{isset($carro_equipa)?$carro_equipa->id_equipa==$equipa->id?'selected':'':''}}>
                        {{$equipa->nome}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->

</div>
