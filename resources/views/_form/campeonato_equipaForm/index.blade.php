<div class="row">
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="id_campeonato">Campeonato*</label>
            <select name="id_campeonato" id="" class="form-control select2">
                @foreach($campeonatos as $campeonato)
                    <option value="{{$campeonato->id}}" {{isset($campeonato_equipa)?$campeonato_equipa->id_campeonato==$campeonato->id?'selected':'':''}}>
                        {{$campeonato->nome}}
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
                    <option value="{{$equipa->id}}" {{isset($campeonato_equipa)?$campeonato_equipa->id_equipa==$equipa->id?'selected':'':''}}>
                        {{$equipa->nome}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->

</div>
