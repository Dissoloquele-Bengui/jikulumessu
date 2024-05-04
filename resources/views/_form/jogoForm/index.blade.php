<div class="row">
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="nome">Carro*</label>
            <select name="id_carro" onchange="{{isset($jogo)?'change_team_fields_update('.$jogo->id.')':'change_team_fields()'}}" id="id_carro{{isset($jogo)?$jogo->id:''}}" class="form-control select2">
                <option value="">Selecione uma opção</option>
                @foreach($carros as $carro)
                    <option value="{{$carro->id}}" {{isset($jogo)?$jogo->id_carro==$carro->id?'selected':'':''}}>
                        {{$carro->nome}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="nome">Empresa*</label>
            <select name="id_empresa" id="id_empresa{{isset($jogo)?$jogo->id:''}}" class="form-control select2">
                <option value="">Selecione uma opção</option>
                @foreach($empresas as $empresa)
                    <option value="{{$empresa->id}}" {{isset($jogo)?$jogo->id_empresa==$empresa->id?'selected':'':''}}>
                       Fase  {{$empresa->nome}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6 id_equipa{{isset($jogo)?$jogo->id:''}}" >
        <div class="mb-3 form-group">
            <label for="id_carro_equipa_1">Equipa de Casa*</label>
            <select name="id_carro_equipa_1" id="id_carro_equipa_1{{isset($jogo)?$jogo->id:''}}" class="form-control select2">
                @foreach($equipas as $equipa)
                    <option value="{{$equipa->id}}" {{isset($jogo)?$jogo->id_carro_equipa_1==$equipa->id?'selected':'':''}}>
                        {{$equipa->equipa}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6 id_equipa">
        <div class="mb-3 form-group">
            <label for="id_carro_equipa_2">Equipa Visitante*</label>
            <select name="id_carro_equipa_2" id="id_carro_equipa_2{{isset($jogo)?$jogo->id:''}}" class="form-control select2">
                @foreach($equipas as $equipa)
                    <option value="{{$equipa->id}}" {{isset($jogo)?$jogo->id_carro_equipa_2==$equipa->id?'selected':'':''}}>
                        {{$equipa->equipa}}
                    </option>
                @endforeach
            </select>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="dia">Dia*</label>
            <input type="date"  value="{{isset($jogo) ?$jogo->dia: old('dia') }}"  name="dia" class="form-control"  required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="hora_inicio">Hora de Inicio*</label>
            <input type="time" value="{{isset($jogo) ?$jogo->hora_inicio: old('hora_inicio') }}"    name="hora_inicio" class="form-control"  required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-4">
        <div class="mb-3 form-group">
            <label for="hora_termino">Hora de Termino*</label>
            <input type="time"    name="hora_termino" class="form-control" value="{{isset($jogo) ?$jogo->hora_termino: old('hora_termino') }}" required>
        </div>
    </div> <!-- /.col -->



</div>
