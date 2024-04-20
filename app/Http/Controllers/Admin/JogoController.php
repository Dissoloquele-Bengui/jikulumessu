<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Epoca;
use App\Models\EpocaCampeonato;
use App\Models\Logger;
use App\Models\Jogador;
use App\Models\Equipa;

use App\Models\AssistenciasJogador;
use App\Models\GolsJogador;
use App\Models\Campeonato;
use App\Models\Jogo;
use App\Models\CampeonatoEquipa;
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
        

        $data['jogos'] = Jogo::join('epocas','epocas.id','jogos.id_epoca')
            ->select('jogos.*', 'epocas.nome as epoca')
            ->get();
        $data['equipas']=CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('campeonato_equipas.*','equipas.nome as equipa','campeonatos.nome as campeonato')
            ->get();
        $data['epocas']= EpocaCampeonato::join('epocas','epocas.id','epoca_campeonatos.id_epoca')
            ->select('epoca_campeonatos.*', 'epocas.nome')
            ->get();
        $data['campeonatos']=Campeonato::all();
        $data['jogadores']=Jogador::all();
        $this->loggerData("Listou Jogos");

        return view('admin.jogo.index', $data);

    }
    public function getDataByCampeonato(Request $request){
        $data['epocas']= EpocaCampeonato::join('epocas','epocas.id','epoca_campeonatos.id_epoca')
        ->select( 'epoca_campeonatos.*', 'epocas.nome')
        ->where('epoca_campeonatos.id_campeonato',$request->id)
        ->get();
        $data['equipas']=CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('campeonato_equipas.*','equipas.nome as equipa','campeonatos.nome as campeonato')
            ->where('campeonato_equipas.id_campeonato',$request->id)
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
            $jogo=Jogo::create([
                'id_campeonato_equipa_2'=>$request->id_campeonato_equipa_2,
                'id_campeonato_equipa_1'=>$request->id_campeonato_equipa_1,
                'hora_inicio'=>$request->hora_inicio,
                'hora_termino'=>$request->hora_termino,
                'dia'=>$request->dia,
                'id_epoca'=>$request->id_epoca
                               
            ]);

            $this->loggerData(" Vinculou a equipa de id $request->id_equipa ao campeonato de id: $request->id_campeonato" );

            return redirect()->back()->with('user.create.success',1);

        } catch (\Throwable $th) {
            throw $th;
            //dd($th);
            return redirect()->back()->with('user.create.error',1);
        }


    }
    public function update_result(Request $request,$id){
        try {
            //code...
            //dd($request);
            $jogo = Jogo::find($id);

            Jogo::findOrFail($id)->update([
                'gols_1'=>$request->gol_1,
                'gols_2'=>$request->gol_2,
                'estado'=>1
            ]);
            if($request->gol_1 > $request->gol_2){
               $total_1 =  CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_1)->vitorias;
               $total_2 =  CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_2)->derrotas;
                CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_1)->update([
                    'vitorias'=>$total_1+1
                ]);
                CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_2)->update([
                    'derrotas'=>$total_2+1
                ]);
            }else if($request->gol_1 > $request->gol_2){
                $total_1 =  CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_1)->derrotas;
                $total_2 =  CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_2)->vitorias;
                 CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_2)->update([
                     'vitorias'=>$total_2+1
                 ]);
                 CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_1)->update([
                     'derrotas'=>$total_1+1
                 ]);
            }else{
                $total_1 =  CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_1)->empates;
                $total_2 =  CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_2)->empates;
                CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_2)->update([
                    'empates'=>$total_2+1
                ]);
                CampeonatoEquipa::where('id_equipa',$jogo->id_campeonato_equipa_1)->update([
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

            return redirect()->back()->with('user.update.success',1);

        } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('user.update.error',1);
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
        $equipas = CampeonatoEquipa::whereIn('id',[$jogo->id_campeonato_equipa_1,$jogo->id_campeonato_equipa_2])
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
        $data['equipas']=CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('campeonato_equipas.*','equipas.nome as equipa','campeonatos.nome as campeonato')
            ->get();
        $data['epocas']= EpocaCampeonato::join('epocas','epocas.id','epoca_campeonatos.id_epoca')
            ->select('epoca_campeonatos.*', 'epocas.nome')
            ->get();
        $data['campeonatos']=Campeonato::all();
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
                'id_campeonato_equipa_2'=>$request->id_campeonato_equipa_2,
                'id_campeonato_equipa_1'=>$request->id_campeonato_equipa_1,
                'hora_inicio'=>$request->hora_inicio,
                'hora_termino'=>$request->hora_termino,
                'dia'=>$request->dia,
            ]);

            $this->loggerData("Editou o jogo que possui o id $jogo->id ");

            return redirect()->back()->with('user.update.success',1);

        } catch (\Throwable $th) {

            return redirect()->back()->with('user.update.error',1);
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
            return redirect()->back()->with('user.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.destroy.error',1);
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
            return redirect()->back()->with('user.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.purge.error',1);
        }
    }


}
