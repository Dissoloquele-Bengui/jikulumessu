<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AlimentoPrato;
use App\Models\Jogador;
use App\Models\AssistenciasJogador;
use App\Models\Comentario;
use App\Models\Compra;
use App\Models\Fatura;
use App\Models\Hospital;
use App\Models\Prato;
use App\Models\Restaurante;
use App\Models\Campeonato;
use App\Models\CampeonatoEquipa;
use App\Models\Jogo;
use App\Models\GolsJogador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Throwable;

class SiteController extends Controller
{
    public function index(){
        return view("site.index");
    }

    public function sobre(){
        return view("site.sobre");
    }
    public function contacto(){
        return view("site.contacto");
    }



    public function campeonatos(){
        $data['campeonatos']=Campeonato::all();
        return view("site.campeonatos",$data);
    }
    public function classificacao($id){
        $data['campeonato']=Campeonato::find($id);
        $data['equipas'] = CampeonatoEquipa::join('equipas', 'equipas.id', 'campeonato_equipas.id_equipa')
        ->selectRaw('equipas.nome as equipa,equipas.logo as logo, campeonato_equipas.*, campeonato_equipas.vitorias * 3 + campeonato_equipas.empates as pontos') // Calcula os pontos
        ->where('id_campeonato', $id)
        ->orderByRaw('pontos DESC') // Ordena pelos pontos em ordem decrescente
        ->get();
    
        return view('site.classificacao',$data);
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
    
        return view('site.calendario',$data);
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
    
        return view('site.resultados',$data);
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
        
        
    
        return view('site.gols',$data);

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
    
        return view('site.assistencias',$data);
    
    }

    public function jogadores($id){
        $data['jogadores'] = Jogador::join('equipas','equipas.id','jogadores.id_equipa')
        ->select('jogadores.*','equipas.nome as equipa')
        ->where('equipas.id',$id)
        ->get();

        return view('site.jogadores',$data);
    }

    public function equipas($id){
        $data['campeonato'] = Campeonato::find($id);
        $data['equipas']= CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
            ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
            ->select('equipas.*','campeonatos.nome as campeonato')
            ->where('campeonatos.id',$id)
            ->get();
        return view('site.equipas',$data);
    }
    public function search(Request $request){
        //dd($request);
        if($request->tipo == 1){
            $data['jogadores'] = Jogador::join('equipas','equipas.id','jogadores.id_equipa')
            ->select('jogadores.*','equipas.nome as equipa')
            ->where('jogadores.nome','like','%'.$request->nome.'%')
            ->orWhere('equipas.nome','like','%'.$request->nome.'%')
            ->get();
            return view('site.jogadores',$data);
        }else{
            $data['equipas']= CampeonatoEquipa::join('equipas','equipas.id','campeonato_equipas.id_equipa')
                ->join('campeonatos','campeonatos.id','campeonato_equipas.id_campeonato')
                ->select('equipas.*','campeonatos.nome as campeonato')
                ->where('equipas.nome','like','%'.$request->nome.'%')
                ->get();
            return view('site.equipas',$data);
        }     
    }


}
