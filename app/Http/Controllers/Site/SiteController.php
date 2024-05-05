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
use App\Models\Carro;
use App\Models\CarroEquipa;
use App\Models\CarroUsuario;
use App\Models\Coordenadas;
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

    public function localizar(){
        return view("site.login");
    }
    public function people(){
        return view("site.people");
    }
    public function cars(){
        return view("site.cars");
    }

    public function login(){
        //dd(Auth::user()->nivel);
        if(Auth::check() && in_array(Auth::user()->nivel,["Funcionário",'Administrador'])){
            return view("site.index");
        }else if(Auth::user()->nivel=="Proprietário"){
           // dd("foi");
            $data['carro']=CarroUsuario::where('id_user',Auth::id())->first();
            return view('site.viewcars',$data);
        }else{
            $data['individuo']=Coordenadas::join('users','users.id','coordenadas.id_user')
                ->select('coordenadas.*','users.name as nome')
                ->where('id_user',Auth::id())->first();
            return view('site.viewpeople',$data);
        }
    }

}
