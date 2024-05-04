<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\EmpresaCarro;
use App\Models\Logger;
use App\Models\Jogador;
use App\Models\Equipa;

use App\Models\AssistenciasJogador;
use App\Models\GolsJogador;
use App\Models\Carro;
use App\Models\Jogo;
use App\Models\CarroEquipa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class JogoController extends Controller
{
    //


    public function __construct(){

        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }


    public function index(){


        $data['jogos'] = Jogo::join('empresas','empresas.id','jogos.id_empresa')
            ->select('jogos.*', 'empresas.nome as empresa')
            ->get();
        $data['equipas']=CarroEquipa::join('equipas','equipas.id','carro_equipas.id_equipa')
            ->join('carros','carros.id','carro_equipas.id_carro')
            ->select('carro_equipas.*','equipas.nome as equipa','carros.nome as carro')
            ->get();
        $data['empresas']= EmpresaCarro::join('empresas','empresas.id','empresa_carros.id_empresa')
            ->select('empresa_carros.*', 'empresas.nome')
            ->get();
        $data['carros']=Carro::all();
        $data['jogadores']=Jogador::all();
        $this->loggerData("Listou Jogos");

        return view('admin.jogo.index', $data);

    }
    public function getDataByCarro(Request $request){
        $data['empresas']= EmpresaCarro::join('empresas','empresas.id','empresa_carros.id_empresa')
        ->select( 'empresa_carros.*', 'empresas.nome')
        ->where('empresa_carros.id_carro',$request->id)
        ->get();
        $data['equipas']=CarroEquipa::join('equipas','equipas.id','carro_equipas.id_equipa')
            ->join('carros','carros.id','carro_equipas.id_carro')
            ->select('carro_equipas.*','equipas.nome as equipa','carros.nome as carro')
            ->where('carro_equipas.id_carro',$request->id)
            ->get();
        return response()->json($data);


    }
    public function create(){


        return view('admin.jogo.create.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        //dd($request);

       // dd($request);
        try{
            if($request->id_carro_equipa_2==$request->id_carro_equipa_1){
                return redirect()->back()->with('jogo.create.error',1);
            }
            $jogo=Jogo::create([
                'id_carro_equipa_2'=>$request->id_carro_equipa_2,
                'id_carro_equipa_1'=>$request->id_carro_equipa_1,
                'hora_inicio'=>$request->hora_inicio,
                'hora_termino'=>$request->hora_termino,
                'dia'=>$request->dia,
                'id_empresa'=>$request->id_empresa

            ]);

            $this->loggerData(" Vinculou a equipa de id $request->id_equipa ao carro de id: $request->id_carro" );

            return redirect()->back()->with('jogo.create.success',1);

        } catch (\Throwable $th) {
            throw $th;
            //dd($th);
            return redirect()->back()->with('jogo.create.error',1);
        }


    }
    public function update_result(Request $request,$id){
        try {
            //code...
            //dd($request);
            $jogo = Jogo::find($id);

            // Obtém os resultados anteriores
            $resultado_anterior = [
                'gols_1' => $jogo->gols_1,
                'gols_2' => $jogo->gols_2,
            ];

            // Atualiza os resultados
            Jogo::findOrFail($id)->update([
                'gols_1' => $request->gol_1,
                'gols_2' => $request->gol_2,
                'estado' => 1
            ]);

            // Verifica se houve alteração no resultado e se o estado do jogo é 1
            if ($jogo->estado == 1 && ($resultado_anterior['gols_1'] != $request->gol_1 || $resultado_anterior['gols_2'] != $request->gol_2)) {
                // Time 1 ganhava antes e agora empata ou perde
                if ($resultado_anterior['gols_1'] > $resultado_anterior['gols_2'] && !($request->gol_1 > $request->gol_2)) {
                    $total_1 = CarroEquipa::where('id', $jogo->id_carro_equipa_1)->first()->vitorias;
                    $total_2 = CarroEquipa::where('id', $jogo->id_carro_equipa_2)->first()->derrotas;

                    // Subtrai apenas se o total não for zero
                    if ($total_1 > 0 && $total_2 > 0) {
                        CarroEquipa::where('id', $jogo->id_carro_equipa_1)->update([
                            'vitorias' => $total_1 - 1 // subtrai a vitória anterior
                        ]);
                        CarroEquipa::where('id', $jogo->id_carro_equipa_2)->update([
                            'derrotas' => $total_2 - 1 // subtrai a derrota anterior
                        ]);
                    }
                }
                // Time 2 ganhava antes e agora empata ou perde
                elseif ($resultado_anterior['gols_2'] > $resultado_anterior['gols_1'] && !($request->gol_1 > $request->gol_2)) {
                    $total_1 = CarroEquipa::where('id', $jogo->id_carro_equipa_1)->first()->derrotas;
                    $total_2 = CarroEquipa::where('id', $jogo->id_carro_equipa_2)->first()->vitorias;

                    // Subtrai apenas se o total não for zero
                    if ($total_1 > 0 && $total_2 > 0) {
                        CarroEquipa::where('id', $jogo->id_carro_equipa_2)->update([
                            'vitorias' => $total_2 - 1 // subtrai a vitória anterior
                        ]);
                        CarroEquipa::where('id', $jogo->id_carro_equipa_1)->update([
                            'derrotas' => $total_1 - 1 // subtrai a derrota anterior
                        ]);
                    }
                }
                // Empate anterior e agora não é mais um empate
                elseif ($resultado_anterior['gols_1'] == $resultado_anterior['gols_2'] && !($request->gol_1 == $request->gol_2)) {
                    $total_1 = CarroEquipa::where('id', $jogo->id_carro_equipa_1)->first()->empates;
                    $total_2 = CarroEquipa::where('id', $jogo->id_carro_equipa_2)->first()->empates;

                    // Subtrai apenas se o total não for zero
                    if ($total_1 > 0 && $total_2 > 0) {
                        CarroEquipa::where('id', $jogo->id_carro_equipa_1)->update([
                            'empates' => $total_1 - 1 // subtrai o empate anterior
                        ]);
                        CarroEquipa::where('id', $jogo->id_carro_equipa_2)->update([
                            'empates' => $total_2 - 1 // subtrai o empate anterior
                        ]);
                    }
                }
            }
           // dd($request->gol_2 == $request->gol_1 && ($resultado_anterior['gols_2'] == $resultado_anterior['gols_1']));
            // Verifica se houve alteração no resultado e se o estado do jogo é 1
            if ($jogo->estado == 1 && ($resultado_anterior['gols_1'] != $request->gol_1 || $resultado_anterior['gols_2'] != $request->gol_2)) {
                // Time 1 ganhava antes e agora empata ou perde
                if ($resultado_anterior['gols_1'] > $resultado_anterior['gols_2'] && !($request->gol_1 > $request->gol_2)) {
                    $total_1 = CarroEquipa::where('id', $jogo->id_carro_equipa_1)->first()->vitorias;
                    $total_2 = CarroEquipa::where('id', $jogo->id_carro_equipa_2)->first()->derrotas;

                    // Subtrai apenas se o total não for zero
                    if ($total_1 > 0 && $total_2 > 0) {
                        CarroEquipa::where('id', $jogo->id_carro_equipa_1)->update([
                            'vitorias' => $total_1 - 1 // subtrai a vitória anterior
                        ]);
                        CarroEquipa::where('id', $jogo->id_carro_equipa_2)->update([
                            'derrotas' => $total_2 - 1 // subtrai a derrota anterior
                        ]);
                    }
                }
                // Time 2 ganhava antes e agora empata ou perde
                elseif ($resultado_anterior['gols_2'] > $resultado_anterior['gols_1'] && !($request->gol_1 > $request->gol_2)) {
                    $total_1 = CarroEquipa::where('id', $jogo->id_carro_equipa_1)->first()->derrotas;
                    $total_2 = CarroEquipa::where('id', $jogo->id_carro_equipa_2)->first()->vitorias;

                    // Subtrai apenas se o total não for zero
                    if ($total_1 > 0 && $total_2 > 0) {
                        CarroEquipa::where('id', $jogo->id_carro_equipa_2)->update([
                            'vitorias' => $total_2 - 1 // subtrai a vitória anterior
                        ]);
                        CarroEquipa::where('id', $jogo->id_carro_equipa_1)->update([
                            'derrotas' => $total_1 - 1 // subtrai a derrota anterior
                        ]);
                    }
                }
                // Empate anterior e agora não é mais um empate
                elseif ($resultado_anterior['gols_1'] == $resultado_anterior['gols_2'] && !($request->gol_1 == $request->gol_2)) {
                    $total_1 = CarroEquipa::where('id', $jogo->id_carro_equipa_1)->first()->empates;
                    $total_2 = CarroEquipa::where('id', $jogo->id_carro_equipa_2)->first()->empates;

                    // Subtrai apenas se o total não for zero
                    if ($total_1 > 0 && $total_2 > 0) {
                        CarroEquipa::where('id', $jogo->id_carro_equipa_1)->update([
                            'empates' => $total_1 - 1 // subtrai o empate anterior
                        ]);
                        CarroEquipa::where('id', $jogo->id_carro_equipa_2)->update([
                            'empates' => $total_2 - 1 // subtrai o empate anterior
                        ]);
                    }
                }
            }
            //Atualização do resultado do Jogo
            if($request->gol_1 > $request->gol_2 && !($resultado_anterior['gols_2'] >= $resultado_anterior['gols_1'])){
                //dd(CarroEquipa::all());
               $total_1 =  CarroEquipa::where('id',$jogo->id_carro_equipa_1)->first()->vitorias;
               $total_2 =  CarroEquipa::where('id',$jogo->id_carro_equipa_2)->first()->derrotas;
                CarroEquipa::where('id',$jogo->id_carro_equipa_1)->update([
                    'vitorias'=>$total_1+1
                ]);
                CarroEquipa::where('id',$jogo->id_carro_equipa_2)->update([
                    'derrotas'=>$total_2+1
                ]);
            }else if($request->gol_2 > $request->gol_1 && !($resultado_anterior['gols_1'] >= $resultado_anterior['gols_2'])){
                //dd("foi");
                $total_1 =  CarroEquipa::where('id',$jogo->id_carro_equipa_1)->first()->derrotas;
                $total_2 =  CarroEquipa::where('id',$jogo->id_carro_equipa_2)->first()->vitorias;
                 CarroEquipa::where('id',$jogo->id_carro_equipa_2)->update([
                     'vitorias'=>$total_2+1
                 ]);
                 CarroEquipa::where('id',$jogo->id_carro_equipa_1)->update([
                     'derrotas'=>$total_1+1
                 ]);
            }else if($request->gol_2 == $request->gol_1 && ($resultado_anterior['gols_2'] != $resultado_anterior['gols_1'])){
                $total_1 =  CarroEquipa::where('id',$jogo->id_carro_equipa_1)->first()->empates;
                $total_2 =  CarroEquipa::where('id',$jogo->id_carro_equipa_2)->first()->empates;
                CarroEquipa::where('id',$jogo->id_carro_equipa_2)->update([
                    'empates'=>$total_2+1
                ]);
                CarroEquipa::where('id',$jogo->id_carro_equipa_1)->update([
                    'empates'=>$total_1+1
                ]);
            }
            //dd(count($request->qtd_gol));
            if(isset($request->qtd_gol)){
                for($x = 0; $x < count($request->qtd_gol);$x++){
                    if(isset($request->qtd_gol[$x]) && isset($request->jogador_id[$x])){
                        if(!GolsJogador::where('id_jogador',$request->jogador_id[$x])->where('id_jogo',$id)->exists()){
                            GolsJogador::create([
                                'id_jogador'=>$request->jogador_id[$x],
                                'numero'=>$request->qtd_gol[$x],
                                'id_jogo'=>$id
                            ]);
                        }else{
                            GolsJogador::where('id_jogador',$request->jogador_id[$x])->where('id_jogo',$id)->update([
                                'numero'=>$request->qtd_gol[$x]
                            ]);
                        }
                    }
                }

            }
            if(isset($request->qtd_assistencias)){
                for($x = 0; $x < count($request->qtd_assistencias);$x++){
                    if(isset($request->qtd_assistencias[$x]) && isset($request->assistencia_id[$x])){
                        if(!AssistenciasJogador::where('id_jogador',$request->assistencia_id[$x])->where('id_jogo',$id)->exists()){
                            AssistenciasJogador::create([
                                'id_jogador'=>$request->assistencia_id[$x],
                                'numero'=>$request->qtd_assistencias[$x],
                                'id_jogo'=>$id
                            ]);
                        }else{
                            AssistenciasJogador::where('id_jogador',$request->assistencia_id[$x])->where('id_jogo',$id)->update([
                                'numero'=>$request->qtd_assistencias[$x]
                            ]);
                        }

                    }
                }

            }
            $this->loggerData("Editou o resultado do jogo que possui o id $jogo->id ");

            return redirect()->back()->with('jogo.update.success',1);

        } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('jogo.update.error',1);
        }
    }
    public function remove_gol(Request $request){
        try {
            //code...
            $id = $request->id;
            $jogo =GolsJogador::findOrFail($id);

            GolsJogador::findOrFail($id)->delete();
            return response()->json('Gol(s) Eliminado(s) com sucesso',200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json('Erro ao tentar eliminar gol(s)',200);
        }
    }
    public function remove_assistencia(Request $request){
        try {
            //code...
            $id = $request->id;
            $jogo =AssistenciasJogador::findOrFail($id);

            AssistenciasJogador::findOrFail($id)->delete();
            return response()->json('Assisntencia(s) Eliminada(s) com sucesso',200);
        } catch (\Throwable $th) {
            throw $th;
            //dd($th);
            return response()->json('Erro ao tentar eliminar Assisntencia(s)',200);
        }
    }
    public function add_gol_field(Request $request){
        $jogo = Jogo::findOrFail($request->id);
        $equipas = CarroEquipa::whereIn('id',[$jogo->id_carro_equipa_1,$jogo->id_carro_equipa_2])
        ->get();
        $equipas = $equipas
            ->pluck('id_equipa')
            ->toArray();
        $data['jogadores']=Jogador::join('equipas','equipas.id','jogadores.id_equipa')->whereIn('jogadores.id_equipa',$equipas)
            ->select('jogadores.*','equipas.nome as equipa')
            ->get();

        return response()->json($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
        $data["jogo"] = Jogo::find($id);
        $data['equipas']=CarroEquipa::join('equipas','equipas.id','carro_equipas.id_equipa')
            ->join('carros','carros.id','carro_equipas.id_carro')
            ->select('carro_equipas.*','equipas.nome as equipa','carros.nome as carro')
            ->get();
        $data['empresas']= EmpresaCarro::join('empresas','empresas.id','empresa_carros.id_empresa')
            ->select('empresa_carros.*', 'empresas.nome')
            ->get();
        $data['carros']=Carro::all();
        $data['jogadores']=Jogador::all();
        return view('admin.jogo.edit.index',$data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    public function update(Request $request, $id)
    {
        //
        //
        //dd($request);
        $request->validate([
            'id_equipa'=>'required',

        ],[
            'id_equipa.required'=>'A jogo é um campo obrigatório',

        ]);


        try {
            //code...
            $jogo = Jogo::find($id);

            Jogo::findOrFail($id)->update([
                'id_carro_equipa_2'=>$request->id_carro_equipa_2,
                'id_carro_equipa_1'=>$request->id_carro_equipa_1,
                'hora_inicio'=>$request->hora_inicio,
                'hora_termino'=>$request->hora_termino,
                'dia'=>$request->dia,
            ]);

            $this->loggerData("Editou o jogo que possui o id $jogo->id ");

            return redirect()->back()->with('jogo.update.success',1);

        } catch (\Throwable $th) {

            return redirect()->back()->with('jogo.update.error',1);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            //code...
            $jogo =Jogo::findOrFail($id);

            Jogo::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o jogo  de id, ($jogo->id)");
            return redirect()->back()->with('jogo.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('jogo.destroy.error',1);
        }
    }

    public function purge($id)
    {
        //
        try {
            //code...
            $jogo = Jogo::findOrFail($id);
            Jogo::findOrFail($id)->forceDelete();
            $this->loggerData("Purgou o jogo  de id, jogo $jogo->name");
            return redirect()->back()->with('jogo.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('jogo.purge.error',1);
        }
    }


}
