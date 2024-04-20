<div class="row">
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="Gol">Gols dos(as) {{$equipas
                ->where('id',$jogo->id_campeonato_equipa_1)
                ->first()
                ->equipa}}*</label>
            <input type="number"  value="{{isset($jogo) ?$jogo->gols_1: old('gol_1') }}"  name="gol_1" class="form-control"  required>
        </div>
    </div> <!-- /.col -->
    <div class="col-md-6">
        <div class="mb-3 form-group">
            <label for="Gol">Gols dos(as) {{$equipas
                ->where('id',$jogo->id_campeonato_equipa_2)
                ->first()
                ->equipa}}*</label>
            <input type="number"  value="{{isset($jogo) ?$jogo->gols_2: old('gol_2') }}"  name="gol_2" class="form-control"  required>
        </div>
    </div> <!-- /.col -->

</div>
<div class="row" id="gol_jogador{{$jogo->id}}">
    
    <div class="col-md-12">
        <p class="text text-center" style="border-bottom:1px solid silver">GOLS</p>
        
    </div>  
    @foreach(getGolsJogo($jogo->id) as $gol)
        <div class="col-md-6 golJogadorDB{{$gol->id}}">
            <div class="mb-3 form-group">
                <label for="Gol">Jogador*</label>
                <select name="gol_id[{{$gol->id}}]" class="select2 form-control">
                    <option value="{{$gol->jogador_id}}">{{$gol->jogador}} | {{$gol->equipa}}</option>
                </select>
            </div>
        </div> <!-- /.col -->
        <div class="col-md-6 golJogadorDB{{$gol->id}}">
            <div class="mb-3 form-group">
                <label for="Gol">Quantidade de Gols*</label>
                <input type="number" value="{{$gol->numero}}" name="qtd_gol[{{$gol->id}}}]" class="form-control" required>
                <a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="add_gol_field({{$jogo->id}})">
                    +
                </a>
                
                <a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="removeGolJogadorDB({{$gol->id}})">-</a>
            </div>
        </div> 
    @endforeach
</div>
<div class="row" id="assistencia_jogador{{$jogo->id}}">
    <div class="col-md-12">
        <p class="text text-center" style="border-bottom:1px solid silver">ASSISTÊNCIAS</p>
             
    </div>        
        @foreach(getAssistenciasJogo($jogo->id) as $assistencia)
        
            <div class="col-md-6 assistenciaJogadorDB{{$assistencia->id}}">
                <div class="mb-3 form-group">
                    <label for="Assistencia">Jogador*</label>
                    <select name="assistencia_id[{{$assistencia->id}}]" class="select2 form-control">
                        <option value="{{$assistencia->jogador_id}}">{{$assistencia->jogador}} | {{$assistencia->equipa}}</option>
                    </select>
                </div>
            </div> <!-- /.col -->
            <div class="col-md-6 assistenciaJogadorDB{{$assistencia->id}}">
                <div class="mb-3 form-group">
                    <label for="Assistencia">Quantidade de Assistencias*</label>
                    <input type="number" value="{{$assistencia->numero}}" name="qtd_assistencias[{{$assistencia->id}}}]" class="form-control" required>
                    <a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="add_assistencia_field({{$jogo->id}})">
                        +
                    </a>
                    
                 <a style="font-size:20px !important;" class="btn p-2 text text-right" onclick="removeAssistenciaJogadorDB({{$assistencia->id}})">-</a>
                </div>
            </div> <!-- /.col -->
                
        @endforeach
</div>


