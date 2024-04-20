<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campeonato;
use App\Models\EpocaCampeonato;
use App\Models\CampeonatoEquipa;
use App\Models\GolsJogador;
use App\Models\AssistenciasJogador;
use App\Models\Jogo;
use App\Models\Logger;

class CampeonatoController extends Controller
{


    public function __construct(){
        $this->fases = [
            'Fase de Grupos',
            'Oitavas de Final',
            'Quartas de Final',
            'Semifinais',
            'Final'
        ];
        $this->logger=new Logger();

    }
    public function loggerData($mensagem){

        $this->logger->Log('info',$mensagem);
    }



    public function index(){
        $data['campeonatos']=Campeonato::all();


        $this->loggerData("Listou os Campeonatos");

        return view('admin.campeonato.index', $data);

    }



    public function create(){


        return view('admin.campeonato.create.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request){
        $request->validate([
            'nome'=>'required',
        ],[
            'nome.required'=>'O nome é um campo obrigatório',


        ]);
        //dd($request);
        try{
            $campeonato=Campeonato::create([
                'nome'=>$request->nome,
                'tipo'=>$request->tipo,
            ]);
            if(isset($request->numero)){
                for($contador = 1; $contador<=$request->numero;$contador++){
                    EpocaCampeonato::create([
                        'id_campeonato'=>$campeonato->id,
                        'id_epoca'=>$contador
                    ]);                    
                }

            }
            if($request->tipo == "Copa" || $request->tipo == "Mista"){
                for($contador = 101; $contador<=105;$contador++){
                    EpocaCampeonato::create([
                        'id_campeonato'=>$campeonato->id,
                        'id_epoca'=>$contador
                    ]);                    
                }
            }
             $this->loggerData(" Cadastrou um campeonato " . $request->nome);

            return redirect()->back()->with('campeonato.create.success',1);

         } catch (\Throwable $th) {
            throw $th;
            dd($th);
            return redirect()->back()->with('campeonato.create.error',1);
        }


     }


      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }
    public function classificacao($id){
        $data['campeonato']=Campeonato::find($id);
        $data['equipas'] = CampeonatoEquipa::join('equipas', 'equipas.id', 'campeonato_equipas.id_equipa')
        ->selectRaw('equipas.nome as equipa,equipas.logo as logo, campeonato_equipas.*, campeonato_equipas.vitorias * 3 + campeonato_equipas.empates as pontos') // Calcula os pontos
        ->where('id_campeonato', $id)
        ->orderByRaw('pontos DESC') // Ordena pelos pontos em ordem decrescente
        ->get();
    
        return view('admin.campeonato.classificacao',$data);
    }

    public function calendario($id){
        $data['campeonato']=Campeonato::find($id);
        $data['jogos'] = Jogo::join('epocas','epocas.id','jogos.id_epoca')
            ->join('campeonato_equipas','campeonato_equipas.id','jogos.id_campeonato_equipa_1')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('jogos.*', 'epocas.nome as epoca')
            ->where('campeonatos.id',$id)
            ->get();
        
        $data['equipas']=CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('campeonato_equipas.*','equipas.nome as equipa','campeonatos.nome as campeonato')
            ->get();
        return view('admin.campeonato.calendario',$data);
    }
    public function resultado($id){
        $data['campeonato']=Campeonato::find($id);
        $data['jogos'] = Jogo::join('epocas','epocas.id','jogos.id_epoca')
            ->join('campeonato_equipas','campeonato_equipas.id','jogos.id_campeonato_equipa_1')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('jogos.*', 'epocas.nome as epoca')
            ->where('campeonatos.id',$id)
            ->where('jogos.estado',1)
            ->get();
        
        $data['equipas']=CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('campeonato_equipas.*','equipas.nome as equipa','campeonatos.nome as campeonato')
            ->get();
    
        return view('admin.campeonato.resultados',$data);
    }

    public function gols($id){
        $data['campeonato'] = Campeonato::find($id);
        $data['jogadores'] = GolsJogador::join('jogos', 'jogos.id', 'gols_jogadors.id_jogo')
            ->join('campeonato_equipas', 'campeonato_equipas.id', 'jogos.id_campeonato_equipa_1')
            ->join('campeonatos', 'campeonatos.id', 'campeonato_equipas.id_campeonato')
            ->rightJoin('jogadores', 'jogadores.id', 'gols_jogadors.id_jogador')
            ->join('equipas', 'equipas.id', 'jogadores.id_equipa')
            ->selectRaw('jogadores.nome as jogador, campeonatos.id as id_campeonato, equipas.logo as logo, equipas.nome as equipa, sum(gols_jogadors.numero) as numeros')
            ->where('campeonatos.id', $id)
            ->groupBy('jogadores.nome', 'campeonatos.id', 'equipas.nome','equipas.logo') 
            ->orderByRaw('numeros DESC')
            ->get();
        
        
    
        return view('admin.campeonato.gol',$data);

    }
    public function assistencias($id){
        $data['campeonato'] = Campeonato::find($id);
        $data['jogadores'] = AssistenciasJogador::join('jogos', 'jogos.id', 'assistencias_jogadors.id_jogo')
            ->join('campeonato_equipas', 'campeonato_equipas.id', 'jogos.id_campeonato_equipa_1')
            ->join('campeonatos', 'campeonatos.id', 'campeonato_equipas.id_campeonato')
            ->rightJoin('jogadores', 'jogadores.id', 'assistencias_jogadors.id_jogador')
            ->join('equipas', 'equipas.id', 'jogadores.id_equipa')
            ->selectRaw('jogadores.nome as jogador, campeonatos.id as id_campeonato, equipas.logo as logo, equipas.nome as equipa, sum(assistencias_jogadors.numero) as numeros')
            ->where('campeonatos.id', $id)
            ->groupBy('jogadores.nome', 'campeonatos.id', 'equipas.nome','equipas.logo') 
            ->orderByRaw('numeros DESC')
            ->get();
    
        return view('admin.campeonato.assistencia',$data);
    
    }


    public function edit(int $id)
    {
        //
        $data["campeonato"] = Campeonato::find($id);


        return view('admin.campeonato.edit.index',$data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



     public function update(Request $request, int $id)
     {
        $request->validate([
            'nome'=>'required',
        ],[
            'nome.required'=>'O nome é um campo obrigatório',

        ]);
          try {
             //code...
             $campeonato = Campeonato::find($id);

             $c =Campeonato::findOrFail($id)->update([
                'nome'=>$request->nome,
                'tipo'=>$request->tipo,
             ]);
             EpocaCampeonato::where('id_campeonato',$id)->forcedelete();
             if(isset($request->numero)){
                for($contador = 1; $contador<=$request->numero;$contador++){
                    
                    EpocaCampeonato::create([
                        'id_campeonato'=>$campeonato->id,
                        'id_epoca'=>$contador
                    ]);                    
                }

            }
            if($request->tipo == "Copa" || $request->tipo == "Mista"){
                for($contador = 101; $contador<=105;$contador++){
                    EpocaCampeonato::create([
                        'id_campeonato'=>$campeonato->id,
                        'id_epoca'=>$contador
                    ]);                    
                }
            }
            $this->loggerData("Editou o campeonato que possui o id $campeonato->id  e nome  $campeonato->nome");
             return redirect()->back()->with('campeonato.update.success',1);
          } catch (\Throwable $th) {
             return redirect()->back()->with('campeonato.update.error',1);
          }
     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
        try {
            //code...
            $campeonato =Campeonato::findOrFail( $id);

            Campeonato::findOrFail($id)->delete();
            $this->loggerData(" Eliminou o campeonato , ($campeonato->nome)");
            return redirect()->back()->with('campeonato.destroy.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('campeonato.destroy.error',1);
        }
    }

    public function purge(int $id)
    {
        //
        try {
            //code...
            $campeonato = Campeonato::findOrFail($id);
            Campeonato::findOrFail($id)->forceDelete();
            $this->loggerData(" Purgou a campeonato  ($campeonato->nome)");
            return redirect()->back()->with('campeonato.purge.success',1);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('campeonato.purge.error',1);
        }
    }


}
