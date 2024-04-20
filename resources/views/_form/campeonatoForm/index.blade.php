<div class="row">
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="nome">Nome*</label>
            <input type="text"   name="nome" class="form-control" value="{{isset($campeonato) ?$campeonato->nome: old('nome') }}" required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="tipo">Tipo*</label>
            <select name="tipo" id="tipo{{isset($campeonato)?$campeonato->id:''}}"
            onchange="{{isset($campeonato)?'add_number_phase_field_update('.$campeonato->id.')':'add_number_phase_field()'}}"
            class="form-control select2">
                <option value="" >Selecione uma opção</option>
                <option value="Liga" {{isset($campeonato)?$campeonato->tipo=="Liga"?'selected':'':''}}>Liga</option>
                <option value="Copa" {{isset($campeonato)?$campeonato->tipo=="Copa"?'selected':'':''}}>Copa</option>
                <option value="Mista" {{isset($campeonato)?$campeonato->tipo=="Mista"?'selected':'':''}}>Mista</option>
            </select>
        </div>
    </div> <!-- /.col -->
</div>
<div class="row" id="phase_container{{isset($campeonato)?$campeonato->id:''}}">


</div>
