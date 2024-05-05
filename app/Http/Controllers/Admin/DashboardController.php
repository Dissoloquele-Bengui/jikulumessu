<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carro;
use App\Models\CarroUsuario;
use App\Models\Compra;
use App\Models\Equipa;
use App\Models\Gestor;
use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    function dashboard(){
        $data['veiculos']=CarroUsuario::count();
        $data['clientes']=User::where('nivel','like','%Cliente%')->count();

        $dados = User::select(
            DB::raw('MONTHNAME(created_at) as mes'),
            DB::raw('COUNT(id) as total_clientes')
        )
        ->groupBy( 'mes')
        ->whereNotIn('nivel',['Administrador','Funcionário'])
        ->get();
        $data['total_clientes']= $dados->pluck('total_clientes')->toArray();
        $data['meses']= $dados->pluck('mes')->toArray();
        return view('admin.index',$data);

    }

}
