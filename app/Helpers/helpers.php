<?php

use App\Models\Comentario;
use App\Models\Hospital;
use App\Models\Horario;
use App\Models\TipoConsulta;
use App\Models\User;
use App\Models\AssistenciasJogador;
use App\Models\Contacto;
use App\Models\GolsJogador;
use App\Models\EstadoNotificacao;
use App\Models\Medico;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('myCustomFunction')) {
    function myCustomFunction()
    {
        return 'Esta é uma função personalizada!';
    }
}
function formatarDataPortugues($data)
{
    return date("d/m/Y", strtotime($data));
}


function  upload( $file){

    $nomeFile = uniqid() . '.' . $file->getClientOriginalExtension();
    $caminhoFile = public_path('docs/files/imagens'); // Pasta de destino

    $file->move($caminhoFile, $nomeFile);
    return "docs/files/imagens/".$nomeFile;


}

function getGolsJogo($id){
    return GolsJogador::join('jogadores','jogadores.id','gols_jogadors.id_jogador')
        ->join('equipas','equipas.id','jogadores.id_equipa')
        ->select('gols_jogadors.*','jogadores.nome as jogador','equipas.nome as equipa')
        ->where('gols_jogadors.id_jogo',$id)
        ->get();

}
function getAssistenciasJogo($id){
    return AssistenciasJogador::join('jogadores','jogadores.id','assistencias_jogadors.id_jogador')
        ->join('equipas','equipas.id','jogadores.id_equipa')
        ->select('assistencias_jogadors.*','jogadores.nome as jogador','equipas.nome as equipa')
        ->where('assistencias_jogadors.id_jogo',$id)
        ->get();

}

function minhasNotificacoes(){

    //dd(Auth::id());
    if(Auth::check()){
        $data['notificacoes'] = EstadoNotificacao::join('users', 'estado_notificacoes.id_usuario', 'users.id')
        ->leftJoin('notificacoes', 'estado_notificacoes.id_notificacao', 'notificacoes.id')
        ->leftJoin('categoria_notificacoes', 'notificacoes.id_categoria', 'categoria_notificacoes.id')
        ->select('notificacoes.*', 'categoria_notificacoes.vc_nome as categoria', 'estado_notificacoes.id as id_estado', 'estado_notificacoes.estado as estado', 'estado_notificacoes.*')
        ->where('estado_notificacoes.id_usuario', Auth::user()->id)
        ->where('estado_notificacoes.created_at', '>=', Carbon::now()->subDays(360))
        ->get();
    $data['not_view'] = EstadoNotificacao::where('estado', 0)
        ->where('estado_notificacoes.id_usuario', Auth::user()->id)
        ->count();
    }
    if(!isset($data)){
        $data['notificacoes']=[];
        $data['not_view']=[];
    }
    return isset($data)?$data:[];
}
function contacto($id){
    return Contacto::where('id_user',$id)
        ->pluck('numero')
        ->toArray();
}
?>
