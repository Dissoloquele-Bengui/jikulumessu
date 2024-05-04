<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carro;
use App\Models\Compra;
use App\Models\Equipa;
use App\Models\Gestor;
use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    function dashboard(){
        $data['carros']=Carro::count();

        return view('admin.index',$data);

    }
    function graficos(){
        $vendas = Compra::select(
            DB::raw('MONTHNAME(created_at) as mes'),
            DB::raw('SUM(valor) as total_compras')
        )
        ->groupBy( 'mes')
        ->get();
        $data['total_vendas']= $vendas->pluck('total_compras')->toArray();
        $data['meses']= $vendas->pluck('mes')->toArray();
        //dd($data['meses']);
        return response()->json($data);
    }

}
